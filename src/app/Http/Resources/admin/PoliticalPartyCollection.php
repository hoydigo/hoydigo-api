<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PoliticalPartyCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => array_map(function ($party) {
                return [
                    'id' => $party->id,
                    'name' => $party->name,
                    'description' => $party->description,
                    'political_position' => [
                        'id' => $party->politicalPosition->id,
                        'name' => $party->politicalPosition->name,
                        'description' => $party->politicalPosition->description
                    ],
                ];
            }, $this->all())
        ];
    }
}
