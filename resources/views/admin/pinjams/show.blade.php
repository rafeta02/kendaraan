@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.pinjam.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.pinjams.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.pinjam.fields.id') }}
                        </th>
                        <td>
                            {{ $pinjam->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pinjam.fields.kendaraan') }}
                        </th>
                        <td>
                            {{ $pinjam->kendaraan->plat_no ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pinjam.fields.date_start') }}
                        </th>
                        <td>
                            {{ $pinjam->date_start }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pinjam.fields.date_end') }}
                        </th>
                        <td>
                            {{ $pinjam->date_end }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pinjam.fields.date_borrow') }}
                        </th>
                        <td>
                            {{ $pinjam->date_borrow }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pinjam.fields.date_return') }}
                        </th>
                        <td>
                            {{ $pinjam->date_return }}
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
                            {{ App\Models\Pinjam::STATUS_SELECT[$pinjam->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pinjam.fields.status_text') }}
                        </th>
                        <td>
                            {{ $pinjam->status_text }}
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
                    <tr>
                        <th>
                            {{ trans('cruds.pinjam.fields.driver_status') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $pinjam->driver_status ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pinjam.fields.driver') }}
                        </th>
                        <td>
                            {{ $pinjam->driver->nama ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pinjam.fields.key_status') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $pinjam->key_status ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pinjam.fields.satpam') }}
                        </th>
                        <td>
                            {{ $pinjam->satpam->nama ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pinjam.fields.is_done') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $pinjam->is_done ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.pinjams.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection