@extends('layouts.admin')
@section('content')
@can('log_peminjaman_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.log-peminjamen.create') }}">
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
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-LogPeminjaman">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        Peminjaman ID
                    </th>
                    <th>
                        Kendaraan
                    </th>
                    <th>
                        Keperluan
                    </th>
                    <th>
                        {{ trans('cruds.logPeminjaman.fields.peminjam') }}
                    </th>
                    <th>
                        {{ trans('cruds.logPeminjaman.fields.jenis') }}
                    </th>
                    <th>
                        Log
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('log_peminjaman_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.log-peminjamen.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
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

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.log-peminjamen.index') }}",
    columns: [
        { data: 'placeholder', name: 'placeholder' },
        { data: 'peminjaman.id', name: 'peminjaman.id' },
        { data: 'kendaraan_no_nama', name: 'kendaraan_no_nama' },
        { data: 'peminjaman_reason', name: 'peminjaman.reason' },
        { data: 'peminjam_name', name: 'peminjam.name' },
        { data: 'jenis', name: 'jenis' },
        { data: 'log', name: 'log' },
        { data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-LogPeminjaman').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

});

</script>
@endsection
