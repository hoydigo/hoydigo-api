<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePoliticalPartyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                    => 'required|string|size:5|unique:political_parties',
            'political_position_id' => 'required|string|size:3|exists:political_positions,id',
            'name'                  => 'required|string|max:40',
            'description'           => 'nullable|string|max:140',
        ];
    }
}
