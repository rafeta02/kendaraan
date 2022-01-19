<?php

namespace App\Http\Requests;

use App\Models\Kendaraan;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateKendaraanRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('kendaraan_edit');
    }

    public function rules()
    {
        return [
            'plat_no' => [
                'string',
                'required',
            ],
            'merk' => [
                'string',
                'required',
            ],
            'jenis' => [
                'required',
            ],
            'kondisi' => [
                'required',
            ],
            'drivers.*' => [
                'integer',
            ],
            'drivers' => [
                'array',
            ],
        ];
    }
}
