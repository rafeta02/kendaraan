@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('pinjam_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.pinjams.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.pinjam.title_singular') }}
                        </a>
                    </div>
                </div>
            @endcan
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.pinjam.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Pinjam">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.kendaraan.fields.plat_no') }}
                                    </th>
                                    <th>
                                        Kendaraan
                                    </th>
                                    <th>
                                        {{ trans('cruds.pinjam.fields.waktu_peminjaman') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.pinjam.fields.reason') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.pinjam.fields.status') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pinjams as $key => $pinjam)
                                    <tr data-entry-id="{{ $pinjam->id }}">
                                        <td>
                                            {{ $pinjam->kendaraan->no_pol ?? '' }}
                                        </td>
                                        <td>
                                            {{ $pinjam->kendaraan->no_nama ?? '' }}
                                        </td>
                                        <td>
                                            {{ $pinjam->waktu_peminjaman }}
                                        </td>
                                        <td>
                                            {{ $pinjam->reason ?? '' }}
                                        </td>
                                        <td>
                                            @if($pinjam->status == 'selesai')
                                                 <span class="badge badge-dark">Dikembalikan {{ $pinjam->date_return_formatted }}</span>
                                            @elseif ($pinjam->status == 'ditolak')
                                                <span class="badge badge-dark">Ditolak dg alasan :<br>({{ $pinjam->status_text }})</span>
                                            @else
                                                <span class="badge badge-{{ App\Models\Pinjam::STATUS_BACKGROUND[$pinjam->status] ?? '' }}">{{ App\Models\Pinjam::STATUS_SELECT[$pinjam->status] ?? '' }}</span>
                                            @endif
                                        </td>
                                        {{-- <td>
                                            <span style="display:none">{{ $pinjam->driver_status ?? '' }}</span>
                                            <input type="checkbox" disabled="disabled" {{ $pinjam->driver_status ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <span style="display:none">{{ $pinjam->key_status ?? '' }}</span>
                                            <input type="checkbox" disabled="disabled" {{ $pinjam->key_status ? 'checked' : '' }}>
                                        </td> --}}
                                        <td>
                                            @can('pinjam_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.pinjams.show', $pinjam->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @if($pinjam->status == 'diajukan')
                                                @can('pinjam_edit')
                                                    <a class="btn btn-xs btn-info" href="{{ route('frontend.pinjams.edit', $pinjam->id) }}">
                                                        {{ trans('global.edit') }}
                                                    </a>
                                                @endcan
                                            @endif

                                            @if($pinjam->status == 'diajukan')
                                                @can('pinjam_delete')
                                                    <form action="{{ route('frontend.pinjams.destroy', $pinjam->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                    </form>
                                                @endcan
                                            @endif

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
@can('pinjam_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.pinjams.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Pinjam:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection

