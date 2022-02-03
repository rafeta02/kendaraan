@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.pinjam.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-md btn-default" href="{{ route('admin.process.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
                @if ($pinjam->status == 'diajukan')
                    @can('process_accept')
                    <button class="btn btn-md btn-success button-accept" data-id="{{ $pinjam->id }}">Accept</button>
                    @endcan
                    @can('process_accept')
                    <button class="btn btn-md btn-danger button-reject" data-id="{{ $pinjam->id }}">Reject</button>
                    @endcan
                @elseif ($pinjam->status == 'diproses')
                    @if ($pinjam->kendaraan->jenis == 'mobil' && $pinjam->driver_status == 0)
                        @can('process_driver')
                        <button class="btn btn-md btn-primary button-driver" data-id="{{ $pinjam->id }}">Choose Driver</button>
                        @else
                        <span class="badge badge-warning text-left">Menunggu Sopir</span>
                        @endcan
                    @endif

                    @if ($pinjam->kendaraan->jenis == 'motor' || ($pinjam->kendaraan->jenis == 'mobil' && $pinjam->driver_status == 1))
                        @can('process_satpam')
                        <button class="btn btn-md btn-info button-satpam" data-id="{{ $pinjam->id }}">Notify Satpam</button>
                        @endcan
                    @endif

                    @if (($pinjam->kendaraan->jenis == 'motor' || $pinjam->driver_status == 1) && $pinjam->key_status == 1)
                        @can('process_dipinjam')
                        <button class="btn btn-md btn-warning button-dipinjam" data-id="{{ $pinjam->id }}">Telah Dipinjam</button>
                        @endcan
                    @endif
                @elseif ($pinjam->status == 'dipinjam')
                    @can('process_selesai')
                    <button class="btn btn-md btn-danger button-selesai" data-id="{{ $pinjam->id }}">Selesai</button>
                    @endcan
                @endif

            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.kendaraan.fields.plat_no') }}
                        </th>
                        <td>
                            {{ $pinjam->kendaraan->no_pol ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Kendaraan
                        </th>
                        <td>
                            {{ $pinjam->kendaraan->no_nama ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pinjam.fields.waktu_peminjaman') }}
                        </th>
                        <td>
                            {{ $pinjam->waktu_peminjaman }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pinjam.fields.reason') }}
                        </th>
                        <td>
                            {{ $pinjam->reason }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pinjam.fields.status') }}
                        </th>
                        <td>
                            @if($pinjam->status == 'selesai')
                                     <span class="badge badge-dark">Dikembalikan :<br>{{ $pinjam->date_return_formatted }}</span>
                            @elseif ($pinjam->status == 'ditolak')
                                <span class="badge badge-dark">Ditolak dg alasan :<br>({{ $pinjam->status_text }})</span>
                            @else
                                <span class="badge badge-{{ App\Models\Pinjam::STATUS_BACKGROUND[$pinjam->status] ?? '' }}">{{ App\Models\Pinjam::STATUS_SELECT[$pinjam->status] ?? '' }}</span>
                                @if ($pinjam->driver_status)
                                    <br>
                                    <span class="badge badge-{{ App\Models\Pinjam::STATUS_BACKGROUND[$pinjam->status] ?? '' }} text-left">Driver : <i class="fa fa-check"></i><br>{{ $pinjam->driver->nama }}<br>({{ $pinjam->driver->no_wa }})</span>
                                @endif
                                @if ($pinjam->key_status)
                                    <br>
                                    <span class="badge badge-{{ App\Models\Pinjam::STATUS_BACKGROUND[$pinjam->status] ?? '' }} text-left">Kunci sudah dikoordinasikan<br> ke Satpam <i class="fa fa-check"></i></span>
                                @endif
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pinjam.fields.status_text') }}
                        </th>
                        <td>
                            @if ($pinjam->status == 'ditolak')
                                Peminjaman "ditolak" dengan alasan "{{ $pinjam->status_text }}"
                            @else
                                {{ $pinjam->status_text }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pinjam.fields.borrowed_by') }}
                        </th>
                        <td>
                            {{ $pinjam->borrowed_by->name ?? '' }}
                        </td>
                    </tr>
                    @if ($pinjam->driver_status)
                    <tr>
                        <th>
                            {{ trans('cruds.pinjam.fields.driver') }}
                        </th>
                        <td>
                            {{ $pinjam->driver->nama ?? '' }}<br>
                            ({{ $pinjam->driver->no_wa ?? '' }})
                        </td>
                    </tr>
                    @endif
                    @if ($pinjam->key_status)
                    <tr>
                        <th>
                            {{ trans('cruds.pinjam.fields.key_status') }}
                        </th>
                        <td>
                            Kunci sudah dikoordinasikan dengan Satpam.
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-md btn-default" href="{{ route('admin.process.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="driverModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Please choose driver</h4>
            </div>
            <div class="modal-body">
                <form id="driverForm" class="form-horizontal">
                   <input type="hidden" name="pinjam_id" id="driver_pinjam_id">
                    <div class="form-group">
                        <label for="driver" class="col-sm-2 control-label">Driver</label>
                        <div class="col-sm-12">
                            <select class="form-control select2" name="driver_id" id="driverSelect">
                                @foreach($drivers as $id => $entry)
                                    <option value="{{ $id }}">{{ $entry }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="assignBtn" value="save">Assign</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="rejectionModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reason Rejection</h4>
            </div>
            <div class="modal-body">
                <form id="rejectionForm" class="form-horizontal">
                   <input type="hidden" name="pinjam_id" id="rejection_pinjam_id">
                    <div class="form-group">
                        <label for="driver" class="col-sm-2 control-label">Reason</label>
                        <div class="col-sm-12">
                            <textarea class="form-control ckeditor" name="reason_rejection" id="reason_rejection"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger" id="rejectionBtn" value="save">Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('body').on('click', '.button-accept', function () {
        event.preventDefault();
        const id = $(this).data('id');
        swal({
            title: 'Apakah pengajuan akan diterima ?',
            text: 'Pengajuan peminjaman kendaraan akan diterima',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
            showSpinner: true
        }).then(function(value) {
            if (value) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.process.accept') }}",
                    data: {
                        id: id
                    },
                    success: function (response) {
                        if (response.status == 'success') {
                            location.reload();
                            swal("Success", response.message, "success");
                        } else {
                            swal("Warning!", response.message, 'error');
                        }
                    }
                });
            }
        });
    });

    $('body').on('click', '.button-driver', function () {
        event.preventDefault();
        const id = $(this).data('id');
        $('#driver_pinjam_id').val(id);
        $('#driverModal').modal('show');
        // $.ajax({
        //     type: "GET",
        //     url: "{{ route('admin.process.chooseDriver') }}",
        //     data: {
        //         id: id
        //     },
        //     success: function (response) {
        //         if (response.status == 'success') {
        //             let pinjam = response.data.pinjam;
        //             $('#driver_pinjam_id').val(pinjam.id);
        //             $('#driverModal').modal('show');
        //         } else {
        //             swal("Warning!", response.message, 'error');
        //         }
        //     }
        // })
    });
    $('body').on('click', '.button-reject', function () {
        event.preventDefault();
        console.log('celicked');
        const id = $(this).data('id');
        $('#rejection_pinjam_id').val(id);
        $('#rejectionModal').modal('show');
    });

    $('#rejectionBtn').click(function (e) {
        e.preventDefault();
        if (!$.trim($("#reason_rejection").val())) {
            swal("Warning!", 'Reason is empty', 'error');
            return;
        } else {
            swal({
            title: 'Apakah pengajuan akan ditolak ?',
            text: 'Pengajuan peminjaman kendaraan akan ditolak',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
            showSpinner: true
            }).then(function(value) {
                if (value) {
                    $(this).html('Sending..');
                    $.ajax({
                        data: $('#rejectionForm').serialize(),
                        url: "{{ route('admin.process.reject') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function (response) {
                            if (response.status == 'success') {
                                $('#rejectionForm').trigger("reset");
                                $('#rejectionModal').modal('hide');
                                location.reload();
                                swal("Success", response.message, 'success');
                            } else {
                                $('#rejectionBtn').html('Reject');
                                swal("Warning!", response.message, 'error');
                            }

                        },
                        error: function (response) {
                            $('#assignBtn').html('Assign');
                        }
                    });
                }
            });
        }
    });

    $('#assignBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
        $.ajax({
          data: $('#driverForm').serialize(),
          url: "{{ route('admin.process.saveDriver') }}",
          type: "POST",
          dataType: 'json',
          success: function (response) {
            if (response.status == 'success') {
                $('#driverForm').trigger("reset");
                $('#driverModal').modal('hide');
                location.reload();
                swal("Success", response.message, 'success');
            } else {
                $('#assignBtn').html('Assign');
                swal("Warning!", response.message, 'error');
            }

          },
          error: function (response) {
              $('#assignBtn').html('Assign');
          }
      });
    });

    $('body').on('click', '.button-satpam', function () {
        event.preventDefault();
        const id = $(this).data('id');
        swal({
            title: 'Apakah ingin memberitahu Satpam ?',
            text: 'Kunci mobil akan dititipkan ke Satpam',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
            showSpinner: true
        }).then(function(value) {
            if (value) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.process.sendSatpam') }}",
                    data: {
                        id: id
                    },
                    success: function (response) {
                        if (response.status == 'success') {
                            response.data.satpam.forEach(element => {
                                window.open(element.link_wa, '_blank');
                            });
                            location.reload();
                            swal("Success", response.message, "success");
                        } else {
                            swal("Warning!", response.message, 'error');
                        }
                    }
                });
            }
        });
    });

    $('body').on('click', '.button-dipinjam', function () {
        event.preventDefault();
        const id = $(this).data('id');
        swal({
            title: 'Apakah kendaraan sudah dipinjam ?',
            text: 'Kendaraan telah dipinjam oleh pengaju',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
            showSpinner: true
        }).then(function(value) {
            if (value) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.process.borrowed') }}",
                    data: {
                        id: id
                    },
                    success: function (response) {
                        if (response.status == 'success') {
                            location.reload();
                            swal("Success", response.message, "success");
                        } else {
                            swal("Warning!", response.message, 'error');
                        }
                    }
                });
            }
        });
    });

    $('body').on('click', '.button-selesai', function () {
        event.preventDefault();
        const id = $(this).data('id');
        swal({
            title: 'Apakah kendaraan telah dikembalikan ?',
            text: 'Kendaraan telah dikembalikan oleh pengaju',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
            showSpinner: true
        }).then(function(value) {
            if (value) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.process.done') }}",
                    data: {
                        id: id
                    },
                    success: function (response) {
                        if (response.status == 'success') {
                            location.reload();
                            swal("Success", response.message, "success");
                        } else {
                            swal("Warning!", response.message, 'error');
                        }
                    }
                });
            }
        });
    });

    $( "#filterForm" ).submit(function( event ) {
        event.preventDefault();
        location.reload();
    });

});
</script>
@endsection
