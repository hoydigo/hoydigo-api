<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInfluencerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'country_id'            => 'string|size:3|exists:countries,id',
            'political_position_id' => 'string|size:3|exists:political_positions,id',
            'political_party_id'    => 'string|size:5|exists:political_parties,id',
            'name'                  => 'string',
            'twitter_username'      => 'string|regex:/^@?(\w){1,15}$/',
        ];
    }
}
