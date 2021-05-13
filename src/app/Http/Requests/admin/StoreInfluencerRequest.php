<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreInfluencerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'political_position_id' => 'required|string|size:3|exists:political_positions,id',
            'political_party_id'    => 'nullable|string|size:5|exists:political_parties,id',
            'name'                  => 'required|string',
            'image'                 => 'nullable|string',
            'twitter_id'            => 'nullable|string',
            'twitter_username'      => 'required|string|regex:/^@?(\w){1,15}$/',
            'twitter_description'   => 'nullable|string',
            'twitter_url'           => 'nullable|string',
            'twitter_verified'      => 'nullable|boolean',
        ];
    }
}
