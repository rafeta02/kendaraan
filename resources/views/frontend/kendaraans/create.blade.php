@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.kendaraan.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.kendaraans.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="plat_no">{{ trans('cruds.kendaraan.fields.plat_no') }}</label>
                            <input class="form-control" type="text" name="plat_no" id="plat_no" value="{{ old('plat_no', '') }}" required>
                            @if($errors->has('plat_no'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('plat_no') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.kendaraan.fields.plat_no_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="merk">{{ trans('cruds.kendaraan.fields.merk') }}</label>
                            <input class="form-control" type="text" name="merk" id="merk" value="{{ old('merk', '') }}" required>
                            @if($errors->has('merk'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('merk') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.kendaraan.fields.merk_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.kendaraan.fields.jenis') }}</label>
                            <select class="form-control" name="jenis" id="jenis" required>
                                <option value disabled {{ old('jenis', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Kendaraan::JENIS_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('jenis', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('jenis'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('jenis') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.kendaraan.fields.jenis_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.kendaraan.fields.kondisi') }}</label>
                            <select class="form-control" name="kondisi" id="kondisi" required>
                                <option value disabled {{ old('kondisi', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Kendaraan::KONDISI_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('kondisi', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('kondisi'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('kondisi') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.kendaraan.fields.kondisi_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('cruds.kendaraan.fields.operasional') }}</label>
                            <select class="form-control" name="operasional" id="operasional">
                                <option value disabled {{ old('operasional', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Kendaraan::OPERASIONAL_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('operasional', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('operasional'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('operasional') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.kendaraan.fields.operasional_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="drivers">{{ trans('cruds.kendaraan.fields.driver') }}</label>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                            </div>
                            <select class="form-control select2" name="drivers[]" id="drivers" multiple>
                                @foreach($drivers as $id => $driver)
                                    <option value="{{ $id }}" {{ in_array($id, old('drivers', [])) ? 'selected' : '' }}>{{ $driver }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('drivers'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('drivers') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.kendaraan.fields.driver_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="unit_kerja_id">{{ trans('cruds.kendaraan.fields.unit_kerja') }}</label>
                            <select class="form-control select2" name="unit_kerja_id" id="unit_kerja_id">
                                @foreach($unit_kerjas as $id => $entry)
                                    <option value="{{ $id }}" {{ old('unit_kerja_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('unit_kerja'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('unit_kerja') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.kendaraan.fields.unit_kerja_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection