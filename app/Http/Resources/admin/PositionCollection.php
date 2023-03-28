<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PositionCollection extends ResourceCollection
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
            'data' => array_map(function ($position) {
                $data = [];

                $data['id'] = $position->id;
                $data['name'] = $position->name;
                $data['description'] = $position->description;

                if ($position->country_id) {
                    $data['country'] = [
                        'id' => $position->country->id,
                        'name' => $position->country->name,
                        'continent' => $position->country->continent,
                    ];
                }

                if ($position->state_id) {
                    $data['state'] = [
                        'id' => $position->state->id,
                        'name' => $position->state->name,
                    ];
                }

                if ($position->city_id) {
                    $data['city'] = [
                        'id' => $position->city->id,
                        'name' => $position->city->name,
                    ];
                }

                return $data;

            }, $this->all())
        ];
    }
}
