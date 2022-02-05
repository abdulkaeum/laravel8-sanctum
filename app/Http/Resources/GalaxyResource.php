<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GalaxyResource extends JsonResource
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
            'light_years' => $this->light_years,
            'name' => $this->name,
            'about' => $this->about
        ];
    }

    public function with($request)
    {
        return [
            'info' => 'Top 5 Galaxies That Look Awesome',
            'src' => 'https://steemit.com/science/@darthnava/top-5-galaxies-that-look-awesome'
        ];
    }
}
