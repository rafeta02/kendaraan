@can('pinjam_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.pinjams.create') }}">
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
            <table class=" table table-bordered table-striped table-hover datatable datatable-borrowedByPinjams">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.pinjam.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.pinjam.fields.kendaraan') }}
                        </th>
                        <th>
                            {{ trans('cruds.kendaraan.fields.merk') }}
                        </th>
                        <th>
                            {{ trans('cruds.kendaraan.fields.jenis') }}
                        </th>
                        <th>
                            {{ trans('cruds.pinjam.fields.date_start') }}
                        </th>
                        <th>
                            {{ trans('cruds.pinjam.fields.date_end') }}
                        </th>
                        <th>
                            {{ trans('cruds.pinjam.fields.date_return') }}
                        </th>
                        <th>
                            {{ trans('cruds.pinjam.fields.reason') }}
                        </th>
                        <th>
                            {{ trans('cruds.pinjam.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.pinjam.fields.borrowed_by') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.email') }}
                        </th>
                        <th>
                            {{ trans('cruds.pinjam.fields.driver_status') }}
                        </th>
                        <th>
                            {{ trans('cruds.pinjam.fields.key_status') }}
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

                            </td>
                            <td>
                                {{ $pinjam->id ?? '' }}
                            </td>
                            <td>
                                {{ $pinjam->kendaraan->plat_no ?? '' }}
                            </td>
                            <td>
                                {{ $pinjam->kendaraan->merk ?? '' }}
                            </td>
                            <td>
                                @if($pinjam->kendaraan)
                                    {{ $pinjam->kendaraan::JENIS_SELECT[$pinjam->kendaraan->jenis] ?? '' }}
                                @endif
                            </td>
                            <td>
                                {{ $pinjam->date_start ?? '' }}
                            </td>
                            <td>
                                {{ $pinjam->date_end ?? '' }}
                            </td>
                            <td>
                                {{ $pinjam->date_return ?? '' }}
                            </td>
                            <td>
                                {{ $pinjam->reason ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Pinjam::STATUS_SELECT[$pinjam->status] ?? '' }}
                            </td>
                            <td>
                                {{ $pinjam->borrowed_by->name ?? '' }}
                            </td>
                            <td>
                                {{ $pinjam->borrowed_by->email ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $pinjam->driver_status ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $pinjam->driver_status ? 'checked' : '' }}>
                            </td>
                            <td>
                                <span style="display:none">{{ $pinjam->key_status ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $pinjam->key_status ? 'checked' : '' }}>
                            </td>
                            <td>
                                @can('pinjam_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.pinjams.show', $pinjam->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('pinjam_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.pinjams.edit', $pinjam->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('pinjam_delete')
                                    <form action="{{ route('admin.pinjams.destroy', $pinjam->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('pinjam_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.pinjams.massDestroy') }}",
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
  let table = $('.datatable-borrowedByPinjams:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection