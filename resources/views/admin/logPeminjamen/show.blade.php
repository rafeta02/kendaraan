@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.logPeminjaman.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.log-peminjamen.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.logPeminjaman.fields.id') }}
                        </th>
                        <td>
                            {{ $logPeminjaman->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.logPeminjaman.fields.peminjaman') }}
                        </th>
                        <td>
                            {{ $logPeminjaman->peminjaman->reason ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.logPeminjaman.fields.kendaraan') }}
                        </th>
                        <td>
                            {{ $logPeminjaman->kendaraan->plat_no ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.logPeminjaman.fields.peminjam') }}
                        </th>
                        <td>
                            {{ $logPeminjaman->peminjam->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.logPeminjaman.fields.jenis') }}
                        </th>
                        <td>
                            {{ App\Models\LogPeminjaman::JENIS_SELECT[$logPeminjaman->jenis] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.logPeminjaman.fields.log') }}
                        </th>
                        <td>
                            {!! $logPeminjaman->log !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.log-peminjamen.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection