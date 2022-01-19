@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.subUnit.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.sub-units.index') }}">
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
                            <a class="btn btn-default" href="{{ route('frontend.sub-units.index') }}">
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