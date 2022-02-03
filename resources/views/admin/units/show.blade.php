@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.unit.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.units.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.unit.fields.id') }}
                        </th>
                        <td>
                            {{ $unit->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.unit.fields.nama') }}
                        </th>
                        <td>
                            {{ $unit->nama }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.unit.fields.slug') }}
                        </th>
                        <td>
                            {{ $unit->slug }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.units.index') }}">
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
            <a class="nav-link" href="#unit_sub_units" role="tab" data-toggle="tab">
                {{ trans('cruds.subUnit.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="unit_sub_units">
            @includeIf('admin.units.relationships.unitSubUnits', ['subUnits' => $unit->unitSubUnits])
        </div>
    </div>
</div>

@endsection