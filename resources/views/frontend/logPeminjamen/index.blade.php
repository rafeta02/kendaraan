@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('log_peminjaman_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.log-peminjamen.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.logPeminjaman.title_singular') }}
                        </a>
                    </div>
                </div>
            @endcan
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.logPeminjaman.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-LogPeminjaman">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.logPeminjaman.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.logPeminjaman.fields.peminjaman') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.pinjam.fields.date_start') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.pinjam.fields.date_end') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.logPeminjaman.fields.kendaraan') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.kendaraan.fields.merk') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.logPeminjaman.fields.peminjam') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.logPeminjaman.fields.jenis') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($logPeminjamen as $key => $logPeminjaman)
                                    <tr data-entry-id="{{ $logPeminjaman->id }}">
                                        <td>
                                            {{ $logPeminjaman->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $logPeminjaman->peminjaman->reason ?? '' }}
                                        </td>
                                        <td>
                                            {{ $logPeminjaman->peminjaman->date_start ?? '' }}
                                        </td>
                                        <td>
                                            {{ $logPeminjaman->peminjaman->date_end ?? '' }}
                                        </td>
                                        <td>
                                            {{ $logPeminjaman->kendaraan->plat_no ?? '' }}
                                        </td>
                                        <td>
                                            {{ $logPeminjaman->kendaraan->merk ?? '' }}
                                        </td>
                                        <td>
                                            {{ $logPeminjaman->peminjam->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ App\Models\LogPeminjaman::JENIS_SELECT[$logPeminjaman->jenis] ?? '' }}
                                        </td>
                                        <td>
                                            @can('log_peminjaman_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.log-peminjamen.show', $logPeminjaman->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('log_peminjaman_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.log-peminjamen.edit', $logPeminjaman->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('log_peminjaman_delete')
                                                <form action="{{ route('frontend.log-peminjamen.destroy', $logPeminjaman->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                </form>
                                            @endcan

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
@can('log_peminjaman_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.log-peminjamen.massDestroy') }}",
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
  let table = $('.datatable-LogPeminjaman:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection