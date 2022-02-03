<?php

namespace App\Http\Requests;

use App\Models\Satpam;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySatpamRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('satpam_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:satpams,id',
        ];
    }
}
