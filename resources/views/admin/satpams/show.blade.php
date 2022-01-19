@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.satpam.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.satpams.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.satpam.fields.id') }}
                        </th>
                        <td>
                            {{ $satpam->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.satpam.fields.nip') }}
                        </th>
                        <td>
                            {{ $satpam->nip }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.satpam.fields.nama') }}
                        </th>
                        <td>
                            {{ $satpam->nama }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.satpam.fields.no_wa') }}
                        </th>
                        <td>
                            {{ $satpam->no_wa }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.satpams.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection