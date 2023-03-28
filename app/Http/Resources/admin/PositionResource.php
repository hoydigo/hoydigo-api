<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Resources\Json\JsonResource;

class PositionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $position = [];

        $position['id'] = $this->id;
        $position['name'] = $this->name;
        $position['description'] = $this->description;

        if ($this->country_id) {
            $position['country'] = [
                'id' => $this->country->id,
                'name' => $this->country->name,
                'continent' => $this->country->continent,
            ];
        }

        if ($this->state_id) {
            $position['state'] = [
                'id' => $this->state->id,
                'name' => $this->state->name,
            ];
        }

        if ($this->city_id) {
            $position['city'] = [
                'id' => $this->city->id,
                'name' => $this->city->name,
            ];
        }

        return $position;
    }
}
