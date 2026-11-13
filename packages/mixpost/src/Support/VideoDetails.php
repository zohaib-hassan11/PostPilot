<?php

namespace Inovector\Mixpost\Support;

use Closure;
use Inovector\Mixpost\Models\Media;

/**
 * Video metadata shared by every video platform (YouTube, TikTok, Instagram Reels…):
 * title, description, tags, custom thumbnail and privacy.
 *
 * One place owns the rules and the clean-up, so the post form, the API and every
 * social provider read exactly the same data. Limits follow YouTube (the strictest).
 *
 * Stored on mixpost_posts.video_details as JSON (null when nothing was entered).
 */
final class VideoDetails
{
    public const TITLE_MAX = 100;          // YouTube title limit

    public const DESCRIPTION_MAX = 5000;   // YouTube description limit

    public const TAGS_MAX = 30;            // tags per video we accept

    public const TAG_MAX = 100;            // characters per tag

    public const TAGS_TOTAL_MAX = 500;     // YouTube: all tags together (incl. separators)

    public const PRIVACY = ['public', 'unlisted', 'private'];

    public const DEFAULT_PRIVACY = 'public';

    public function __construct(
        public readonly ?string $title = null,
        public readonly ?string $description = null,
        public readonly array $tags = [],
        public readonly ?int $thumbnailMediaId = null,
        public readonly string $privacy = self::DEFAULT_PRIVACY,
    ) {
    }

    /** Validation rules, nested under $prefix (the request key). */
    public static function rules(string $prefix = 'video_details'): array
    {
        return [
            $prefix => ['nullable', 'array'],
            "$prefix.title" => ['nullable', 'string', 'max:'.self::TITLE_MAX],
            "$prefix.description" => ['nullable', 'string', 'max:'.self::DESCRIPTION_MAX],
            "$prefix.tags" => ['nullable', 'array', 'max:'.self::TAGS_MAX, self::tagsTotalLengthRule()],
            "$prefix.tags.*" => ['nullable', 'string', 'max:'.self::TAG_MAX],   // blanks are dropped by fromArray()
            "$prefix.thumbnail_media_id" => ['nullable', 'integer', self::thumbnailIsImageRule()],
            "$prefix.privacy" => ['nullable', 'string', 'in:'.implode(',', self::PRIVACY)],
        ];
    }

    /** Build from request/database input, normalising whitespace, duplicates and empties. */
    public static function fromArray(?array $data): self
    {
        $data ??= [];

        $tags = collect($data['tags'] ?? [])
            ->map(fn ($tag) => trim(ltrim(trim((string) $tag), '#')))
            ->filter(fn ($tag) => $tag !== '')
            ->unique(fn ($tag) => mb_strtolower($tag))
            ->values()
            ->all();

        $privacy = $data['privacy'] ?? null;

        return new self(
            title: self::clean($data['title'] ?? null),
            description: self::clean($data['description'] ?? null, keepNewLines: true),
            tags: $tags,
            thumbnailMediaId: isset($data['thumbnail_media_id']) && $data['thumbnail_media_id'] !== '' ? (int) $data['thumbnail_media_id'] : null,
            privacy: in_array($privacy, self::PRIVACY, true) ? $privacy : self::DEFAULT_PRIVACY,
        );
    }

    public function isEmpty(): bool
    {
        return $this->title === null
            && $this->description === null
            && $this->tags === []
            && $this->thumbnailMediaId === null
            && $this->privacy === self::DEFAULT_PRIVACY;
    }

    /** What we store: null when the user entered nothing. */
    public function toStorage(): ?array
    {
        return $this->isEmpty() ? null : $this->toArray();
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'tags' => $this->tags,
            'thumbnail_media_id' => $this->thumbnailMediaId,
            'privacy' => $this->privacy,
        ];
    }

    public function thumbnail(): ?Media
    {
        return $this->thumbnailMediaId ? Media::find($this->thumbnailMediaId) : null;
    }

    private static function clean(?string $value, bool $keepNewLines = false): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = $keepNewLines ? trim($value) : trim(preg_replace('/\s+/u', ' ', $value));

        return $value === '' ? null : $value;
    }

    private static function tagsTotalLengthRule(): Closure
    {
        return function (string $attribute, mixed $value, Closure $fail) {
            if (! is_array($value)) {
                return;
            }

            $total = collect($value)->sum(fn ($tag) => mb_strlen(trim((string) $tag))) + max(0, count($value) - 1);

            if ($total > self::TAGS_TOTAL_MAX) {
                $fail('All tags together must be '.self::TAGS_TOTAL_MAX.' characters or fewer (YouTube limit).');
            }
        };
    }

    private static function thumbnailIsImageRule(): Closure
    {
        return function (string $attribute, mixed $value, Closure $fail) {
            $media = Media::find($value);

            if (! $media) {
                $fail('The selected thumbnail no longer exists in the media library.');

                return;
            }

            if (! $media->isImage() || $media->isImageGif()) {
                $fail('The thumbnail must be an image (JPG or PNG).');
            }
        };
    }
}
