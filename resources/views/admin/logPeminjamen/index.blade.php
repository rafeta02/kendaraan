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
{ data: 'id', name: 'id' },
{ data: 'peminjaman_reason', name: 'peminjaman.reason' },
{ data: 'peminjaman.date_start', name: 'peminjaman.date_start' },
{ data: 'peminjaman.date_end', name: 'peminjaman.date_end' },
{ data: 'kendaraan_plat_no', name: 'kendaraan.plat_no' },
{ data: 'kendaraan.merk', name: 'kendaraan.merk' },
{ data: 'peminjam_name', name: 'peminjam.name' },
{ data: 'jenis', name: 'jenis' },
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