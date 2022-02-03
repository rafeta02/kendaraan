@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.subUnit.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sub-units.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.subUnit.fields.id') }}
                        </th>
                        <td>
                            {{ $subUnit->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subUnit.fields.unit') }}
                        </th>
                        <td>
                            {{ $subUnit->unit->nama ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subUnit.fields.nama') }}
                        </th>
                        <td>
                            {{ $subUnit->nama }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subUnit.fields.slug') }}
                        </th>
                        <td>
                            {{ $subUnit->slug }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sub-units.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#unit_kerja_kendaraans" role="tab" data-toggle="tab">
                {{ trans('cruds.kendaraan.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="unit_kerja_kendaraans">
            @includeIf('admin.subUnits.relationships.unitKerjaKendaraans', ['kendaraans' => $subUnit->unitKerjaKendaraans])
        </div>
    </div>
</div>

@endsection