<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Pinjam;
use App\Models\LogPeminjaman;
use App\Models\Driver;
use App\Models\Satpam;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use DB;
use Carbon\Carbon;

class AdminAccController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('pinjam_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $drivers = Driver::all()->pluck('nama', 'id');

        if ($request->ajax()) {
            if (!empty($request->date_start) && !empty($request->date_end)) {
                $date_start = Carbon::parse($request->date_start)->format('Y-m-d H:i:s');
                $date_end = Carbon::parse($request->date_end)->format('Y-m-d H:i:s');
                $query = Pinjam::whereBetween('created_at', [$date_start, $date_end])->where('status', $request->status)->with(['kendaraan', 'borrowed_by', 'processed_by', 'created_by'])->select(sprintf('%s.*', (new Pinjam())->table));
            } else {
                $query = Pinjam::with(['kendaraan', 'borrowed_by', 'processed_by', 'driver', 'satpam', 'created_by'])->select(sprintf('%s.*', (new Pinjam())->table));
            }

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                return view('partials.admintablesActions', compact('row'));
            });

            $table->addColumn('kendaraan.plat_no', function ($row) {
                return $row->kendaraan ? $row->kendaraan->no_pol : '';
            });

            $table->editColumn('kendaraan.merk', function ($row) {
                return $row->kendaraan ? $row->kendaraan->no_nama : '';
            });

            $table->addColumn('waktu_peminjaman', function ($row) {
                return $row->waktu_peminjaman;
            });

            $table->addColumn('borrowed_by_name', function ($row) {
                return $row->borrowed_by ? $row->borrowed_by->name : '';
            });
            $table->editColumn('reason', function ($row) {
                return $row->reason ? $row->reason : '';
            });
            $table->editColumn('status', function ($row) {
                if ($row->status == 'selesai') {
                    return '<span class="badge badge-dark">Dikembalikan :<br>'. $row->date_return_formatted. '</span>';
                } else {
                    if ($row->status == 'diproses') {
                        $status = '<span class="badge badge-'.Pinjam::STATUS_BACKGROUND[$row->status].'">'.Pinjam::STATUS_SELECT[$row->status].'</span>';
                        $driver = '';
                        if ($row->driver_status) {
                            $driver = '<span class="badge badge-warning text-left">Driver : <i class="fa fa-check"></i><br>'.$row->driver->nama.'</span>';
                        }
                        $satpam = '';
                        if ($row->key_status) {
                            $satpam = '<span class="badge badge-warning text-left">Satpam : <i class="fa fa-check"></i></span>';
                        }

                        return $status.' '.$driver.' '.$satpam;
                    }
                    return '<span class="badge badge-'.Pinjam::STATUS_BACKGROUND[$row->status].'">'.Pinjam::STATUS_SELECT[$row->status].'</span>';
                }
            });

            $table->addColumn('tanggal_pengajuan', function ($row) {
                return $row->tanggal_pengajuan;
            });

            $table->rawColumns(['actions', 'placeholder', 'kendaraan', 'borrowed_by', 'driver_status', 'key_status', 'status']);

            return $table->make(true);
        }

        return view('admin.adminAcc.index', compact('drivers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function acceptPengajuan(Request $request)
    {
        try {
            DB::transaction(function() use ($request) {
                $data = Pinjam::find($request->id);
                $data->status = 'diproses';
                $data->status_text = 'Peminjaman kendaraan "'.$data->kendaraan->no_nama .'" Diproses oleh "'. auth()->user()->name .'"';

                $log = LogPeminjaman::create([
                    'peminjaman_id' => $data->id,
                    'kendaraan_id' => $data->kendaraan_id,
                    'peminjam_id' => $data->borrowed_by_id,
                    'jenis' => 'diproses',
                    'log' => 'Peminjaman kendaraan '. $data->kendaraan->no_nama. ' Diproses oleh "'. auth()->user()->name .'" Untuk tanggal '. $data->WaktuPeminjaman . ' Dengan keperluan "' . $data->reason .'"',
                ]);

                $data->save();
            });
            return response()->json(['status' => 'success', 'message' => 'Pengajuan berhasil diterima']);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function chooseDriver(Request $request)
    {
        $drivers = Driver::all()->pluck('nama', 'id');
        $pinjam = Pinjam::find($request->id);

        if ($pinjam) {
            return response()->json(['status' => 'success', 'message' => 'Data ditemukan', 'data' => ['driver' => $drivers, 'pinjam' => $pinjam]]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Not Found']);
        }
    }

    public function saveDriver(Request $request)
    {
        try {
            DB::transaction(function() use ($request) {
                $driver = Driver::find($request->driver_id);

                $data = Pinjam::find($request->pinjam_id);
                $data->driver_status = 1;
                $data->driver_id = $driver->id;
                $data->status_text = 'Peminjaman kendaraan "'.$data->kendaraan->no_nama .'" Diproses oleh "'. auth()->user()->name .'" Telah menugas kan '. $driver->driver_id. ' Sebagai Supir';

                $log = LogPeminjaman::create([
                    'peminjaman_id' => $data->id,
                    'kendaraan_id' => $data->kendaraan_id,
                    'peminjam_id' => $data->borrowed_by_id,
                    'jenis' => 'diproses',
                    'log' => 'Peminjaman kendaraan '. $data->kendaraan->no_nama. ' Diproses oleh "'. auth()->user()->name .'" Telah menugas kan '. $driver->driver_id. ' Sebagai Supir Untuk tanggal '. $data->WaktuPeminjaman . ' Dengan keperluan "' . $data->reason .'"',
                ]);

                $data->save();
            });
            return response()->json(['status' => 'success', 'message' => 'Driver berhasil di assign']);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function sendSatpam(Request $request)
    {
        try {
            DB::transaction(function() use ($request) {
                $data = Pinjam::find($request->id);
                $data->key_status = 1;
                $data->status_text = 'Peminjaman kendaraan "'.$data->kendaraan->no_nama .'" Diproses oleh "'. auth()->user()->name .'" Telah memberikan pemberitahuan ke Satpam';

                $log = LogPeminjaman::create([
                    'peminjaman_id' => $data->id,
                    'kendaraan_id' => $data->kendaraan_id,
                    'peminjam_id' => $data->borrowed_by_id,
                    'jenis' => 'diproses',
                    'log' => 'Peminjaman kendaraan '. $data->kendaraan->no_nama. ' Diproses oleh "'. auth()->user()->name .'" Telah memberikan pemberitahuan ke Satpam, Untuk tanggal '. $data->WaktuPeminjaman . ' Dengan keperluan "' . $data->reason .'"',
                ]);

                $data->save();
            });

            $satpams = Satpam::all();
            return response()->json(['status' => 'success', 'message' => 'Pemberitahuan ke satpam berhasil', 'data' => ['satpam' => $satpams]]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function telahDipinjam(Request $request)
    {
        try {
            DB::transaction(function() use ($request) {
                $data = Pinjam::find($request->id);
                $data->status = 'dipinjam';
                $data->date_borrow = Carbon::now()->format('Y-m-d');
                $data->status_text = 'Peminjaman kendaraan "'.$data->kendaraan->no_nama .'" Proses telah diselesaikan oleh "'. auth()->user()->name .'" Dan telah dipinjam kan ke ' .$data->borrowed_by->name;

                $log = LogPeminjaman::create([
                    'peminjaman_id' => $data->id,
                    'kendaraan_id' => $data->kendaraan_id,
                    'peminjam_id' => $data->borrowed_by_id,
                    'jenis' => 'dipinjam',
                    'log' => 'Peminjaman kendaraan '. $data->kendaraan->no_nama. ' Proses telah diselesaikan oleh "'. auth()->user()->name .'" Dan telah dipinjam kan ke ' .$data->borrowed_by->name.', Untuk tanggal '. $data->WaktuPeminjaman . ' Dengan keperluan "' . $data->reason .'"',
                ]);

                $data->save();
            });

            $satpams = Satpam::all();
            return response()->json(['status' => 'success', 'message' => 'Kendaraan telah dipinjamkan']);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function selesai(Request $request)
    {
        try {
            DB::transaction(function() use ($request) {
                $data = Pinjam::find($request->id);
                $data->status = 'selesai';
                $data->date_return = Carbon::now()->format('Y-m-d');
                $data->status_text = 'Peminjaman kendaraan "'.$data->kendaraan->no_nama .'" Telah dikembalikan dan Proses telah diselesaikan oleh "'. auth()->user()->name.", Peminjaman Selesai.";

                $log = LogPeminjaman::create([
                    'peminjaman_id' => $data->id,
                    'kendaraan_id' => $data->kendaraan_id,
                    'peminjam_id' => $data->borrowed_by_id,
                    'jenis' => 'selesai',
                    'log' => 'Peminjaman kendaraan '. $data->kendaraan->no_nama. ' Telah dikembalikan dan Proses telah diselesaikan oleh "'. auth()->user()->name .'" Untuk tanggal '. $data->WaktuPeminjaman . ' Dengan keperluan "' . $data->reason .'", Peminjaman Selesai.',
                ]);

                $data->save();
            });

            $satpams = Satpam::all();
            return response()->json(['status' => 'success', 'message' => 'Kendaraan telah telah dikembalikan dan peminjaman selesai']);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
