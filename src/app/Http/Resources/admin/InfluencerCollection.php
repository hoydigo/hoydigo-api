<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Resources\Json\ResourceCollection;

class InfluencerCollection extends ResourceCollection
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
            'data' => array_map(function ($influencer) {
                $data = [];

                $data['id'] = $influencer->id;
                $data['name'] = $influencer->name;
                $data['image'] = $influencer->image;
                $data['twitter_id'] = $influencer->twitter_id;
                $data['twitter_username'] = $influencer->twitter_username;
                $data['twitter_description'] = $influencer->twitter_description;
                $data['twitter_url'] = $influencer->twitter_url;
                $data['twitter_verified'] = $influencer->twitter_verified;
                $data['status'] = $influencer->status;

                if ($influencer->country_id) {
                    $data['country'] = [
                        'id' => $influencer->country->id,
                        'name' => $influencer->country->name,
                        'continent' => $influencer->country->continent,
                    ];
                }

                if ($influencer->political_position_id) {
                    $data['political_position'] = [
                        'id' => $influencer->political_position->id,
                        'name' => $influencer->political_position->name,
                        'description' => $influencer->political_position->description,
                    ];
                }

                if ($influencer->political_party_id) {
                    $data['political_party'] = [
                        'id' => $influencer->political_party->id,
                        'name' => $influencer->political_party->name,
                        'description' => $influencer->political_party->description,
                    ];
                }

                return $data;

            }, $this->all())
        ];
    }
}
