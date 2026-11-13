<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inovector\Mixpost\Models\Media;
use Inovector\Mixpost\Models\Post;
use Inovector\Mixpost\Support\VideoDetails;
use Inovector\MixpostAuth\MixpostAuth;
use Tests\TestCase;

/**
 * Video details (title, description, tags, thumbnail, privacy) on posts.
 * Runs on the separate `social_hub_testing` database (phpunit.xml) — never the real one.
 */
class VideoDetailsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $user = MixpostAuth::getUserClass()::create([
            'name' => 'Tester',
            'email' => 'tester@example.test',
            'password' => bcrypt('secret-password'),
        ]);
        $this->actingAs($user);
    }

    private function payload(array $videoDetails = null): array
    {
        $data = [
            'accounts' => [],
            'tags' => [],
            'versions' => [[
                'account_id' => 0,
                'is_original' => true,
                'content' => [['body' => 'Hello world', 'media' => []]],
            ]],
            'date' => null,
            'time' => null,
        ];

        if ($videoDetails !== null) {
            $data['video_details'] = $videoDetails;
        }

        return $data;
    }

    private function media(string $mime, string $name): Media
    {
        return Media::create([
            'name' => $name, 'mime_type' => $mime, 'disk' => 'public', 'path' => "mixpost/$name",
            'size' => 1024, 'size_total' => 1024, 'conversions' => [],
        ]);
    }

    private function image(): Media
    {
        return $this->media('image/jpeg', 'thumb.jpg');
    }

    public function test_store_saves_normalised_video_details(): void
    {
        $thumb = $this->image();

        $this->post(route('mixpost.posts.store'), $this->payload([
            'title' => '  My   launch   video  ',
            'description' => "Line one\nLine two  ",
            'tags' => ['#AI', 'automation', 'ai', '  ', 'n8n'],
            'thumbnail_media_id' => $thumb->id,
            'privacy' => 'unlisted',
        ]))->assertSessionHasNoErrors()->assertRedirect();

        $post = Post::latest('id')->first();

        $this->assertSame([
            'title' => 'My launch video',
            'description' => "Line one\nLine two",
            'tags' => ['AI', 'automation', 'n8n'],          // '#' stripped, duplicates (case-insensitive) and blanks removed
            'thumbnail_media_id' => (int) $thumb->id,
            'privacy' => 'unlisted',
        ], $post->videoDetails()->toArray());   // via the value object: fixed key order (MySQL JSON reorders keys)
    }

    public function test_store_without_video_details_keeps_column_null(): void
    {
        $this->post(route('mixpost.posts.store'), $this->payload())->assertRedirect();
        $this->post(route('mixpost.posts.store'), $this->payload(['title' => '   ', 'tags' => [], 'privacy' => 'public']))->assertRedirect();

        $this->assertSame(2, Post::count());
        $this->assertSame(0, Post::whereNotNull('video_details')->count());
    }

    public function test_update_changes_and_clears_video_details(): void
    {
        $this->post(route('mixpost.posts.store'), $this->payload(['title' => 'First']));
        $post = Post::latest('id')->first();

        $this->put(route('mixpost.posts.update', ['post' => $post->uuid]), $this->payload(['title' => 'Second', 'privacy' => 'private']))
            ->assertNoContent();
        $this->assertSame('Second', $post->fresh()->videoDetails()->title);
        $this->assertSame('private', $post->fresh()->videoDetails()->privacy);

        $this->put(route('mixpost.posts.update', ['post' => $post->uuid]), $this->payload(['title' => '']))
            ->assertNoContent();
        $this->assertNull($post->fresh()->video_details);
    }

    public function test_edit_page_returns_video_details_with_thumbnail(): void
    {
        $thumb = $this->image();
        $this->post(route('mixpost.posts.store'), $this->payload(['title' => 'With thumb', 'thumbnail_media_id' => $thumb->id]));
        $post = Post::latest('id')->first();

        $this->get(route('mixpost.posts.edit', ['post' => $post->uuid]))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->where('post.video_details.title', 'With thumb')
                ->where('post.video_details.thumbnail_media_id', (int) $thumb->id)
                ->where('post.video_details.thumbnail.id', fn ($id) => (int) $id === (int) $thumb->id));
    }

    /** @dataProvider invalidDetails */
    public function test_rejects_invalid_video_details(array $details, string $errorKey): void
    {
        $this->post(route('mixpost.posts.store'), $this->payload($details))
            ->assertSessionHasErrors($errorKey);

        $this->assertSame(0, Post::count());
    }

    public static function invalidDetails(): array
    {
        return [
            'title over 100 chars' => [['title' => str_repeat('a', VideoDetails::TITLE_MAX + 1)], 'video_details.title'],
            'description over 5000' => [['description' => str_repeat('a', VideoDetails::DESCRIPTION_MAX + 1)], 'video_details.description'],
            'unknown privacy' => [['privacy' => 'friends-only'], 'video_details.privacy'],
            'too many tags' => [['tags' => array_map(fn ($i) => "t$i", range(1, VideoDetails::TAGS_MAX + 1))], 'video_details.tags'],
            'tags over 500 total' => [['tags' => array_fill(0, 6, str_repeat('x', 90))], 'video_details.tags'],
            'missing thumbnail' => [['thumbnail_media_id' => 999999], 'video_details.thumbnail_media_id'],
        ];
    }

    public function test_thumbnail_must_be_an_image_not_a_video(): void
    {
        $video = $this->media('video/mp4', 'clip.mp4');

        $this->post(route('mixpost.posts.store'), $this->payload(['thumbnail_media_id' => $video->id]))
            ->assertSessionHasErrors('video_details.thumbnail_media_id');
    }
}
