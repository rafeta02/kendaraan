@if ($row->status == 'diajukan')
    @can('process_accept')
    <button class="btn btn-xs btn-success button-accept" data-id="{{ $row->id }}">Accept</button>
    @endcan
@elseif ($row->status == 'diproses')
    @if ($row->kendaraan->jenis == 'mobil' && $row->driver_status == 0)
        @can('process_driver')
        <button class="btn btn-xs btn-primary button-driver" data-id="{{ $row->id }}">Choose Driver</button>
        @endcan
    @endif

    @if ($row->kendaraan->jenis == 'motor' || ($row->kendaraan->jenis == 'mobil' && $row->driver_status == 1))
        @can('process_satpam')
        <button class="btn btn-xs btn-info button-satpam" data-id="{{ $row->id }}">Notify Satpam</button>
        @endcan
    @endif

    @if (($row->kendaraan->jenis == 'motor' || $row->driver_status == 1) && $row->key_status == 1)
        @can('process_dipinjam')
        <button class="btn btn-xs btn-warning button-dipinjam" data-id="{{ $row->id }}">Telah Dipinjam</button>
        @endcan
    @endif
@elseif ($row->status == 'dipinjam')
    @can('process_selesai')
    <button class="btn btn-xs btn-danger button-selesai" data-id="{{ $row->id }}">Selesai</button>
    @endcan
@endif
