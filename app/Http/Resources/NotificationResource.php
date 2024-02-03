<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $link = $this->read_at 
                ? $this->data['link']
                : $this->data['link'] . "?notif=" . $this->id; // need to parse properly as url query params
                
        return [
            'icon' => $this->data['icons'],
            'details' => $this->data['details'],
            'link' => $link, 
            'read_at' => $this->read_at,
            'created_at' => $this->created_at
        ];
    }
}
