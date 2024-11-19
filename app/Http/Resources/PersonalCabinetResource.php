<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonalCabinetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'category_id' => $this->category_id,
            'views' => $this->views,
            'createdAt' => $this->createdAt,
            'user_id' => $this->user_id,
            'rating' => $this->rating,
            'published' => $this->published
        ];
    }
}
