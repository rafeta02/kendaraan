@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.pinjam.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.pinjams.update", [$pinjam->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="kendaraan_id">{{ trans('cruds.pinjam.fields.kendaraan') }}</label>
                <select class="form-control select2 {{ $errors->has('kendaraan') ? 'is-invalid' : '' }}" name="kendaraan_id" id="kendaraan_id" required>
                    @foreach($kendaraans as $id => $entry)
                        <option value="{{ $id }}" {{ (old('kendaraan_id') ? old('kendaraan_id') : $pinjam->kendaraan->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('kendaraan'))
                    <div class="invalid-feedback">
                        {{ $errors->first('kendaraan') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pinjam.fields.kendaraan_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="date_start">{{ trans('cruds.pinjam.fields.date_start') }}</label>
                <input class="form-control date {{ $errors->has('date_start') ? 'is-invalid' : '' }}" type="text" name="date_start" id="date_start" value="{{ old('date_start', $pinjam->date_start) }}" required>
                @if($errors->has('date_start'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date_start') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pinjam.fields.date_start_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="date_end">{{ trans('cruds.pinjam.fields.date_end') }}</label>
                <input class="form-control date {{ $errors->has('date_end') ? 'is-invalid' : '' }}" type="text" name="date_end" id="date_end" value="{{ old('date_end', $pinjam->date_end) }}" required>
                @if($errors->has('date_end'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date_end') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pinjam.fields.date_end_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_return">{{ trans('cruds.pinjam.fields.date_return') }}</label>
                <input class="form-control date {{ $errors->has('date_return') ? 'is-invalid' : '' }}" type="text" name="date_return" id="date_return" value="{{ old('date_return', $pinjam->date_return) }}">
                @if($errors->has('date_return'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date_return') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pinjam.fields.date_return_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="reason">{{ trans('cruds.pinjam.fields.reason') }}</label>
                <input class="form-control {{ $errors->has('reason') ? 'is-invalid' : '' }}" type="text" name="reason" id="reason" value="{{ old('reason', $pinjam->reason) }}" required>
                @if($errors->has('reason'))
                    <div class="invalid-feedback">
                        {{ $errors->first('reason') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pinjam.fields.reason_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.pinjam.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Pinjam::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $pinjam->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pinjam.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('driver_status') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="driver_status" value="0">
                    <input class="form-check-input" type="checkbox" name="driver_status" id="driver_status" value="1" {{ $pinjam->driver_status || old('driver_status', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="driver_status">{{ trans('cruds.pinjam.fields.driver_status') }}</label>
                </div>
                @if($errors->has('driver_status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('driver_status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pinjam.fields.driver_status_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('key_status') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="key_status" value="0">
                    <input class="form-check-input" type="checkbox" name="key_status" id="key_status" value="1" {{ $pinjam->key_status || old('key_status', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="key_status">{{ trans('cruds.pinjam.fields.key_status') }}</label>
                </div>
                @if($errors->has('key_status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('key_status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pinjam.fields.key_status_helper') }}</span>
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