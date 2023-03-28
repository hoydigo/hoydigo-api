<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Resources\Json\JsonResource;

class PoliticalPartyResource extends JsonResource
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
            'political_position' => [
                'id' => $this->politicalPosition->id,
                'name' => $this->politicalPosition->name,
                'description' => $this->politicalPosition->description
            ],
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
