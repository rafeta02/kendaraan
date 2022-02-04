@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.logPeminjaman.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.log-peminjamen.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="peminjaman_id">{{ trans('cruds.logPeminjaman.fields.peminjaman') }}</label>
                            <select class="form-control select2" name="peminjaman_id" id="peminjaman_id" required>
                                @foreach($peminjamen as $id => $entry)
                                    <option value="{{ $id }}" {{ old('peminjaman_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('peminjaman'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('peminjaman') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.logPeminjaman.fields.peminjaman_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="kendaraan_id">{{ trans('cruds.logPeminjaman.fields.kendaraan') }}</label>
                            <select class="form-control select2" name="kendaraan_id" id="kendaraan_id" required>
                                @foreach($kendaraans as $id => $entry)
                                    <option value="{{ $id }}" {{ old('kendaraan_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('kendaraan'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('kendaraan') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.logPeminjaman.fields.kendaraan_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="peminjam_id">{{ trans('cruds.logPeminjaman.fields.peminjam') }}</label>
                            <select class="form-control select2" name="peminjam_id" id="peminjam_id" required>
                                @foreach($peminjams as $id => $entry)
                                    <option value="{{ $id }}" {{ old('peminjam_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('peminjam'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('peminjam') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.logPeminjaman.fields.peminjam_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.logPeminjaman.fields.jenis') }}</label>
                            <select class="form-control" name="jenis" id="jenis" required>
                                <option value disabled {{ old('jenis', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\LogPeminjaman::JENIS_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('jenis', 'diajukan') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('jenis'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('jenis') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.logPeminjaman.fields.jenis_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="log">{{ trans('cruds.logPeminjaman.fields.log') }}</label>
                            <textarea class="form-control" name="log" id="log">{{ old('log') }}</textarea>
                            @if($errors->has('log'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('log') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.logPeminjaman.fields.log_helper') }}</span>
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