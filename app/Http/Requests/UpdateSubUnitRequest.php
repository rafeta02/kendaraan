<?php

namespace App\Http\Requests;

use App\Models\SubUnit;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSubUnitRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('sub_unit_edit');
    }

    public function rules()
    {
        return [
            'unit_id' => [
                'required',
                'integer',
            ],
            'nama' => [
                'string',
                'required',
            ],
        ];
    }
}
