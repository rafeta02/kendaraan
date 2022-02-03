@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        List Pengajuan Peminjaman Kendaraan
    </div>

    <div class="card-body">
        <form id="filterForm">
        {{-- <form method="GET" action="{{ route("admin.process.index") }}" enctype="multipart/form-data"> --}}
            <div class="row">
                <div class="form-group col-6">
                    <label class="required" for="date_start">{{ trans('cruds.pinjam.fields.date_start') }}</label>
                    <input class="form-control date {{ $errors->has('date_start') ? 'is-invalid' : '' }}" type="text" name="date_start" id="date_start" value="{{ old('date_start') }}" required>
                    @if($errors->has('date_start'))
                        <div class="invalid-feedback">
                            {{ $errors->first('date_start') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.pinjam.fields.date_start_helper') }}</span>
                </div>
                <div class="form-group col-6">
                    <label class="required" for="date_end">{{ trans('cruds.pinjam.fields.date_end') }}</label>
                    <input class="form-control date {{ $errors->has('date_end') ? 'is-invalid' : '' }}" type="text" name="date_end" id="date_end" value="{{ old('date_end') }}" required>
                    @if($errors->has('date_end'))
                        <div class="invalid-feedback">
                            {{ $errors->first('date_end') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.pinjam.fields.date_end_helper') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.pinjam.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Pinjam::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', 'diajukan') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pinjam.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit" id="filterBtn">
                    {{ trans('global.filter') }}
                </button>
            </div>
        </form>
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Pinjam">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.kendaraan.fields.plat_no') }}
                    </th>
                    <th>
                        Kendaraan
                    </th>
                    <th>
                        Pengaju
                    </th>
                    <th>
                        Tanggal Pengajuan
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
        </table>
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
  let dtOverrideGlobals = {
    // buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: {
        url: "{{ route('admin.process.index') }}",
        data: function(data) {
            data.date_start = $('#date_start').val(),
            data.date_end = $('#date_end').val(),
            data.status = $('#status').val()
        }
    },
    columns: [
        { data: 'placeholder', name: 'placeholder' },
        { data: 'kendaraan.plat_no', name: 'kendaraan.plat_no' },
        { data: 'kendaraan.merk', name: 'kendaraan.merk' },
        { data: 'borrowed_by_name', name: 'borrowed_by_name' },
        { data: 'tanggal_pengajuan', name: 'tanggal_pengajuan' },
        { data: 'waktu_peminjaman', name: 'waktu_peminjaman' },
        { data: 'reason', name: 'reason' },
        { data: 'status', name: 'status' },
        { data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Pinjam').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

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
                            table.ajax.reload();
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
                                table.ajax.reload();
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
                table.ajax.reload();
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
                            table.ajax.reload();
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
                            table.ajax.reload();
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
                            table.ajax.reload();
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
        table.ajax.reload();
    });

});
</script>
@endsection
