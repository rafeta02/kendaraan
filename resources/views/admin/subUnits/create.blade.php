@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.subUnit.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sub-units.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="unit_id">{{ trans('cruds.subUnit.fields.unit') }}</label>
                <select class="form-control select2 {{ $errors->has('unit') ? 'is-invalid' : '' }}" name="unit_id" id="unit_id" required>
                    @foreach($units as $id => $entry)
                        <option value="{{ $id }}" {{ old('unit_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('unit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('unit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.subUnit.fields.unit_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="nama">{{ trans('cruds.subUnit.fields.nama') }}</label>
                <input class="form-control {{ $errors->has('nama') ? 'is-invalid' : '' }}" type="text" name="nama" id="nama" value="{{ old('nama', '') }}" required>
                @if($errors->has('nama'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nama') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.subUnit.fields.nama_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="slug">{{ trans('cruds.subUnit.fields.slug') }}</label>
                <input class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" type="text" name="slug" id="slug" value="{{ old('slug', '') }}">
                @if($errors->has('slug'))
                    <div class="invalid-feedback">
                        {{ $errors->first('slug') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.subUnit.fields.slug_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection