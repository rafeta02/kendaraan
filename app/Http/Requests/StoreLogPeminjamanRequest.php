<?php

namespace App\Http\Requests;

use App\Models\LogPeminjaman;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreLogPeminjamanRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('log_peminjaman_create');
    }

    public function rules()
    {
        return [
            'peminjaman_id' => [
                'required',
                'integer',
            ],
            'kendaraan_id' => [
                'required',
                'integer',
            ],
            'peminjam_id' => [
                'required',
                'integer',
            ],
            'jenis' => [
                'required',
            ],
        ];
    }
}
