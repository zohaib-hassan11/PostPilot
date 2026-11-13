<?php

namespace Inovector\Mixpost\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Inovector\Mixpost\Facades\Settings;
use Inovector\Mixpost\Util;

class PostResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request): array
    {
        return [
            'id' => $this->uuid,
            'status' => $this->status(),
            'accounts' => AccountResource::collection($this->whenLoaded('accounts')),
            'versions' => PostVersionResource::collection($this->whenLoaded('versions')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'scheduled_at' => [
                'date' => $this->scheduled_at?->tz(Settings::get('timezone'))->toDateString(),
                'time' => $this->scheduled_at?->tz(Settings::get('timezone'))->format('H:i'),
                'human' => $this->scheduled_at ? Util::dateTimeFormat($this->scheduled_at, Settings::get('timezone')) : null,
            ],
            'video_details' => $this->videoDetailsResource(),
            'published_at' => [
                'human' => $this->published_at?->tz(Settings::get('timezone'))->format('D, M j, '.Util::timeFormat()),
            ],
        ];
    }

    /** Video metadata + the thumbnail as a media item (url/thumb) for the editor preview. */
    protected function videoDetailsResource(): array
    {
        $details = $this->resource->videoDetails();
        $thumbnail = $details->thumbnail();

        return [
            ...$details->toArray(),
            'thumbnail' => $thumbnail ? (new MediaResource($thumbnail))->resolve() : null,
        ];
    }

    protected function status()
    {
        if ($this->isScheduleProcessing()) {
            return 'PUBLISHING';
        }

        return $this->status->name;
    }
}
