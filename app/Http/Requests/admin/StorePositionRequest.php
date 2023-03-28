<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePositionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'          => 'required|string|size:6|unique:positions',
            'country_id'  => 'required|string|size:3|exists:countries,id',
            'state_id'    => 'integer|exists:states,id,country_id,' . $this->country_id,
            'city_id'     => 'integer|exists:cities,id,state_id,' . $this->state_id . ',country_id,' . $this->country_id,
            'sector'      => 'required|string|max:100',
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string|max:280',
        ];
    }
}
