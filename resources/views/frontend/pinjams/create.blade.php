@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    Pengajuan {{ trans('cruds.pinjam.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.pinjams.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="kendaraan_id">{{ trans('cruds.pinjam.fields.kendaraan') }}</label>
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
                            <span class="help-block">{{ trans('cruds.pinjam.fields.kendaraan_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="date_start">{{ trans('cruds.pinjam.fields.date_start') }}</label>
                            <input class="form-control date-picker" type="text" name="date_start" id="date_start" value="{{ old('date_start') }}" required>
                            @if($errors->has('date_start'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('date_start') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.pinjam.fields.date_start_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="date_end">{{ trans('cruds.pinjam.fields.date_end') }}</label>
                            <input class="form-control date-picker" type="text" name="date_end" id="date_end" value="{{ old('date_end') }}" required>
                            @if($errors->has('date_end'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('date_end') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.pinjam.fields.date_end_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="reason">{{ trans('cruds.pinjam.fields.reason') }}</label>
                            <input class="form-control" type="text" name="reason" id="reason" value="{{ old('reason', '') }}" required>
                            @if($errors->has('reason'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('reason') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.pinjam.fields.reason_helper') }}</span>
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
@section('scripts')
<script>
$(function () {
    $('#date_start').datetimepicker().on('dp.change', function (e) {
        $('#date_end').data('DateTimePicker').minDate(e.date);
        $(this).data("DateTimePicker").hide();
    });

    $('#date_end').datetimepicker().on('dp.change', function (e) {
        $('#date_start').data('DateTimePicker').maxDate(e.date);
        $(this).data("DateTimePicker").hide();
    });
});
</script>
@endsection
