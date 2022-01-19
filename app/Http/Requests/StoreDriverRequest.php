<?php

namespace App\Http\Requests;

use App\Models\Driver;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDriverRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('driver_create');
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
