<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReplyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => (int) $this->user_id,
            'topic_id' => (int) $this->topic_id,
            'content' => $this->content,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'user' => new UserResource($this->whenLoaded('user')),
            'topic' => new TopicResource($this->whenLoaded('topic')),
        ];
    }
}
