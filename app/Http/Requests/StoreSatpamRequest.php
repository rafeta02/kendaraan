<?php

namespace App\Http\Requests;

use App\Models\Satpam;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSatpamRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('satpam_create');
    }

    public function rules()
    {
        return [
            'nip' => [
                'string',
                'required',
            ],
            'nama' => [
                'string',
                'required',
            ],
            'no_wa' => [
                'string',
                'nullable',
            ],
        ];
    }
}
