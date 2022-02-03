@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.user.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.users.update", [$user->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                            <input class="form-control" type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
                            @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="password">{{ trans('cruds.user.fields.password') }}</label>
                            <input class="form-control" type="password" name="password" id="password">
                            @if($errors->has('password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.password_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="roles">{{ trans('cruds.user.fields.roles') }}</label>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                            </div>
                            <select class="form-control select2" name="roles[]" id="roles" multiple required>
                                @foreach($roles as $id => $role)
                                    <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || $user->roles->contains($id)) ? 'selected' : '' }}>{{ $role }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('roles'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('roles') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.roles_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="nip">{{ trans('cruds.user.fields.nip') }}</label>
                            <input class="form-control" type="text" name="nip" id="nip" value="{{ old('nip', $user->nip) }}">
                            @if($errors->has('nip'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('nip') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.nip_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="no_identitas">{{ trans('cruds.user.fields.no_identitas') }}</label>
                            <input class="form-control" type="text" name="no_identitas" id="no_identitas" value="{{ old('no_identitas', $user->no_identitas) }}">
                            @if($errors->has('no_identitas'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('no_identitas') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.no_identitas_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="nama">{{ trans('cruds.user.fields.nama') }}</label>
                            <input class="form-control" type="text" name="nama" id="nama" value="{{ old('nama', $user->nama) }}">
                            @if($errors->has('nama'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('nama') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.nama_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="alamat">{{ trans('cruds.user.fields.alamat') }}</label>
                            <textarea class="form-control" name="alamat" id="alamat">{{ old('alamat', $user->alamat) }}</textarea>
                            @if($errors->has('alamat'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('alamat') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.alamat_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="no_hp">{{ trans('cruds.user.fields.no_hp') }}</label>
                            <input class="form-control" type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $user->no_hp) }}">
                            @if($errors->has('no_hp'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('no_hp') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.no_hp_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="foto_url">{{ trans('cruds.user.fields.foto_url') }}</label>
                            <div class="needsclick dropzone" id="foto_url-dropzone">
                            </div>
                            @if($errors->has('foto_url'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('foto_url') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.foto_url_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="unit_id">{{ trans('cruds.user.fields.unit') }}</label>
                            <select class="form-control select2" name="unit_id" id="unit_id">
                                @foreach($units as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('unit_id') ? old('unit_id') : $user->unit->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('unit'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('unit') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.unit_helper') }}</span>
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
    Dropzone.options.fotoUrlDropzone = {
    url: '{{ route('frontend.users.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
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
      $('form').find('input[name="foto_url"]').remove()
      $('form').append('<input type="hidden" name="foto_url" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="foto_url"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($user) && $user->foto_url)
      var file = {!! json_encode($user->foto_url) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="foto_url" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
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