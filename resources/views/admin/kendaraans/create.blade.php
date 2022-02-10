@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.kendaraan.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.kendaraans.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="plat_no">{{ trans('cruds.kendaraan.fields.plat_no') }}</label>
                <input class="form-control {{ $errors->has('plat_no') ? 'is-invalid' : '' }}" type="text" name="plat_no" id="plat_no" value="{{ old('plat_no', '') }}" required>
                @if($errors->has('plat_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('plat_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.kendaraan.fields.plat_no_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="merk">{{ trans('cruds.kendaraan.fields.merk') }}</label>
                <input class="form-control {{ $errors->has('merk') ? 'is-invalid' : '' }}" type="text" name="merk" id="merk" value="{{ old('merk', '') }}" required>
                @if($errors->has('merk'))
                    <div class="invalid-feedback">
                        {{ $errors->first('merk') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.kendaraan.fields.merk_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.kendaraan.fields.jenis') }}</label>
                <select class="form-control {{ $errors->has('jenis') ? 'is-invalid' : '' }}" name="jenis" id="jenis" required>
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
                <select class="form-control {{ $errors->has('kondisi') ? 'is-invalid' : '' }}" name="kondisi" id="kondisi" required>
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
                <select class="form-control {{ $errors->has('operasional') ? 'is-invalid' : '' }}" name="operasional" id="operasional">
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
                <select class="form-control select2 {{ $errors->has('drivers') ? 'is-invalid' : '' }}" name="drivers[]" id="drivers" multiple>
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
                <select class="form-control select2 {{ $errors->has('unit_kerja') ? 'is-invalid' : '' }}" name="unit_kerja_id" id="unit_kerja_id">
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
                <label for="foto">{{ trans('cruds.kendaraan.fields.foto') }}</label>
                <div class="needsclick dropzone {{ $errors->has('foto') ? 'is-invalid' : '' }}" id="foto-dropzone">
                </div>
                @if($errors->has('foto'))
                    <div class="invalid-feedback">
                        {{ $errors->first('foto') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.kendaraan.fields.foto_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="owned_by_id">{{ trans('cruds.kendaraan.fields.owned_by') }}</label>
                <select class="form-control select2 {{ $errors->has('owned_by') ? 'is-invalid' : '' }}" name="owned_by_id" id="owned_by_id">
                    @foreach($owned_bies as $id => $entry)
                        <option value="{{ $id }}" {{ old('owned_by_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('owned_by'))
                    <div class="invalid-feedback">
                        {{ $errors->first('owned_by') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.kendaraan.fields.owned_by_helper') }}</span>
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

@section('scripts')
<script>
    var uploadedFotoMap = {}
Dropzone.options.fotoDropzone = {
    url: '{{ route('admin.kendaraans.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="foto[]" value="' + response.name + '">')
      uploadedFotoMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedFotoMap[file.name]
      }
      $('form').find('input[name="foto[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($kendaraan) && $kendaraan->foto)
      var files = {!! json_encode($kendaraan->foto) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="foto[]" value="' + file.file_name + '">')
        }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@endsection