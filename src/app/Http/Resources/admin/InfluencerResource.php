<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Resources\Json\JsonResource;

class InfluencerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $influencer = [];

        $influencer['id'] = $this->id;
        $influencer['name'] = $this->name;
        $influencer['image'] = $this->image;
        $influencer['twitter_id'] = $this->twitter_id;
        $influencer['twitter_username'] = $this->twitter_username;
        $influencer['twitter_description'] = $this->twitter_description;
        $influencer['twitter_url'] = $this->twitter_url;
        $influencer['twitter_verified'] = $this->twitter_verified;
        $influencer['status'] = $this->status;

        if ($this->country_id) {
            $influencer['country'] = [
                'id' => $this->country->id,
                'name' => $this->country->name,
                'continent' => $this->country->continent,
            ];
        }

        if ($this->political_position_id) {
            $influencer['political_position'] = [
                'id' => $this->political_position->id,
                'name' => $this->political_position->name,
                'description' => $this->political_position->description,
            ];
        }

        if ($this->political_party_id) {
            $influencer['political_party'] = [
                'id' => $this->political_party->id,
                'name' => $this->political_party->name,
                'description' => $this->political_party->description,
            ];
        }

        return $influencer;
    }
}
