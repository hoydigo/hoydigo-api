<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePoliticalPartyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'political_position_id' => 'string|size:3|exists:political_positions,id',
            'name'                  => 'string|max:40',
            'description'           => 'string|max:140',
        ];
    }
}
