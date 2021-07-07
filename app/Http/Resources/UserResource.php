<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'image_url' => $this->image_url,
            'theme' => $this->theme,
            'language' => $this->language,
            'currency' => $this->currency,
            'provider' => $this->provider,
            'created_at' => $this->created_at
        ];
    }
}
