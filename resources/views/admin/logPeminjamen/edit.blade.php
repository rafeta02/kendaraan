@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.logPeminjaman.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.log-peminjamen.update", [$logPeminjaman->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="peminjaman_id">{{ trans('cruds.logPeminjaman.fields.peminjaman') }}</label>
                <select class="form-control select2 {{ $errors->has('peminjaman') ? 'is-invalid' : '' }}" name="peminjaman_id" id="peminjaman_id" required>
                    @foreach($peminjamen as $id => $entry)
                        <option value="{{ $id }}" {{ (old('peminjaman_id') ? old('peminjaman_id') : $logPeminjaman->peminjaman->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                <select class="form-control select2 {{ $errors->has('kendaraan') ? 'is-invalid' : '' }}" name="kendaraan_id" id="kendaraan_id" required>
                    @foreach($kendaraans as $id => $entry)
                        <option value="{{ $id }}" {{ (old('kendaraan_id') ? old('kendaraan_id') : $logPeminjaman->kendaraan->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                <select class="form-control select2 {{ $errors->has('peminjam') ? 'is-invalid' : '' }}" name="peminjam_id" id="peminjam_id" required>
                    @foreach($peminjams as $id => $entry)
                        <option value="{{ $id }}" {{ (old('peminjam_id') ? old('peminjam_id') : $logPeminjaman->peminjam->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                <select class="form-control {{ $errors->has('jenis') ? 'is-invalid' : '' }}" name="jenis" id="jenis" required>
                    <option value disabled {{ old('jenis', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\LogPeminjaman::JENIS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('jenis', $logPeminjaman->jenis) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
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
                <textarea class="form-control ckeditor {{ $errors->has('log') ? 'is-invalid' : '' }}" name="log" id="log">{!! old('log', $logPeminjaman->log) !!}</textarea>
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



@endsection

@section('scripts')
<script>
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.log-peminjamen.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $logPeminjaman->id ?? 0 }}');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

@endsection