@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.pinjam.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.pinjams.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                            <a class="btn btn-info" href="{{ route('frontend.pinjams.edit', $pinjam->id) }}">
                                {{ trans('global.edit') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.kendaraan.fields.plat_no') }}
                                    </th>
                                    <td>
                                        {{ $pinjam->kendaraan->no_pol ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Kendaraan
                                    </th>
                                    <td>
                                        {{ $pinjam->kendaraan->no_nama ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.pinjam.fields.waktu_peminjaman') }}
                                    </th>
                                    <td>
                                        {{ $pinjam->waktu_peminjaman }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.pinjam.fields.reason') }}
                                    </th>
                                    <td>
                                        {{ $pinjam->reason }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.pinjam.fields.status') }}
                                    </th>
                                    <td>
                                        @if($pinjam->status == 'selesai')
                                                 <span class="badge badge-dark">Dikembalikan :<br>{{ $pinjam->date_return_formatted }}</span>
                                        @elseif ($pinjam->status == 'ditolak')
                                            <span class="badge badge-dark">Ditolak dg alasan :<br>({{ $pinjam->status_text }})</span>
                                        @else
                                            <span class="badge badge-{{ App\Models\Pinjam::STATUS_BACKGROUND[$pinjam->status] ?? '' }}">{{ App\Models\Pinjam::STATUS_SELECT[$pinjam->status] ?? '' }}</span>
                                            @if ($pinjam->driver_status)
                                                <br>
                                                <span class="badge badge-{{ App\Models\Pinjam::STATUS_BACKGROUND[$pinjam->status] ?? '' }} text-left">Driver : <i class="fa fa-check"></i><br>{{ $pinjam->driver->nama }}<br>({{ $pinjam->driver->no_wa }})</span>
                                            @endif
                                            @if ($pinjam->key_status)
                                                <br>
                                                <span class="badge badge-{{ App\Models\Pinjam::STATUS_BACKGROUND[$pinjam->status] ?? '' }} text-left">Kunci sudah dikoordinasikan<br> ke Satpam <i class="fa fa-check"></i></span>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.pinjam.fields.status_text') }}
                                    </th>
                                    <td>
                                        @if ($pinjam->status == 'ditolak')
                                            Peminjaman "ditolak" dengan alasan "{{ $pinjam->status_text }}"
                                        @else
                                            {{ $pinjam->status_text }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.pinjam.fields.borrowed_by') }}
                                    </th>
                                    <td>
                                        {{ $pinjam->borrowed_by->name ?? '' }}
                                    </td>
                                </tr>
                                @if ($pinjam->driver_status)
                                <tr>
                                    <th>
                                        {{ trans('cruds.pinjam.fields.driver') }}
                                    </th>
                                    <td>
                                        {{ $pinjam->driver->nama ?? '' }}<br>
                                        ({{ $pinjam->driver->no_wa ?? '' }})
                                    </td>
                                </tr>
                                @endif
                                @if ($pinjam->key_status)
                                <tr>
                                    <th>
                                        {{ trans('cruds.pinjam.fields.key_status') }}
                                    </th>
                                    <td>
                                        Kunci sudah dikoordinasikan dengan Satpam.
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.pinjams.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
