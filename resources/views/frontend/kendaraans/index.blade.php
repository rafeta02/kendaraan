@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.kendaraan.title_singular') }} {{ trans('global.list') }}
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route("frontend.kendaraans.index") }}" enctype="multipart/form-data">
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="plat_no">{{ trans('cruds.kendaraan.fields.plat_no') }}</label>
                                <input class="form-control" type="text" name="plat_no" id="plat_no" value="{{ old('plat_no', '') }}">
                                @if($errors->has('plat_no'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('plat_no') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.kendaraan.fields.plat_no_helper') }}</span>
                            </div>
                            <div class="form-group col-6">
                                <label for="merk">{{ trans('cruds.kendaraan.fields.merk') }}</label>
                                <input class="form-control" type="text" name="merk" id="merk" value="{{ old('merk', '') }}">
                                @if($errors->has('merk'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('merk') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.kendaraan.fields.merk_helper') }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>{{ trans('cruds.kendaraan.fields.jenis') }}</label>
                                <select class="form-control" name="jenis" id="jenis">
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
                            <div class="form-group col-6">
                                <label>Apakah tersedia ?</label>
                                <select class="form-control" name="used" id="used">
                                    <option value disabled {{ old('used', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                    <option value="nope" {{ old('used') === 'nope' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="used" {{ old('used') === 'used' ? 'selected' : '' }}>Dipinjam</option>

                                </select>
                                @if($errors->has('used'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('used') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.kendaraan.fields.jenis_helper') }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
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
                        </div>

                        <div class="form-group mt-3">
                            <button class="btn btn-primary" type="submit">
                                Cari
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Kendaraan">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.kendaraan.fields.plat_no') }}
                                    </th>
                                    <th>
                                        Kendaraan
                                    </th>
                                    <th>
                                        Operasional
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kendaraans as $key => $kendaraan)
                                    <tr data-entry-id="{{ $kendaraan->id }}">
                                        <td>
                                            {{ $kendaraan->plat_no ?? '' }}
                                        </td>
                                        <td>
                                            {{ $kendaraan->no_nama ?? '' }}
                                        </td>
                                        <td>
                                            {{ App\Models\Kendaraan::OPERASIONAL_SELECT[$kendaraan->operasional] ?? '' }}<br>
                                            ({{ $kendaraan->unit_kerja->nama ?? '' }})
                                        </td>
                                        <td class="justify-content-center align-items-center">
                                            @if ($kendaraan->peminjaman->count() > 0)
                                                <ul>
                                                    @foreach ($kendaraan->peminjaman as $peminjaman)
                                                        <li>
                                                            <span class="text-left badge badge-{{ App\Models\Pinjam::STATUS_BACKGROUND[$peminjaman->status] ?? '' }}"> Peminjaman oleh "{{ $peminjaman->borrowed_by->name }}" <br> Untuk tanggal {{ $peminjaman->waktu_peminjaman }} <br> Status : {{ App\Models\Pinjam::STATUS_SELECT[$peminjaman->status] ?? '' }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>

                                                {{-- <span class="text-left badge badge-{{ App\Models\Pinjam::STATUS_BACKGROUND[$kendaraan->peminjaman->status] ?? '' }}"> Peminjaman oleh "{{ $kendaraan->peminjaman->borrowed_by->name }}"<br> Status : {{ App\Models\Pinjam::STATUS_SELECT[$kendaraan->peminjaman->status] ?? '' }}</span> --}}
                                            @else
                                                <span class="badge badge-success">Tersedia</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-sm btn-block btn-primary" href="{{ route('frontend.pinjams.create', ['kendaraan' => $kendaraan->id]) }}">
                                                Ajukan
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
$(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Kendaraan:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
