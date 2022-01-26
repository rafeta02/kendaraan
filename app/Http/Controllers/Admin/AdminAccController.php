<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Pinjam;
use App\Models\LogPeminjaman;
use App\Models\Driver;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use DB;

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

        if (!empty($request->date_start) && !empty($request->date_end)) {
            $query = Pinjam::whereBetween('date_time', [$request->date_start, $request->date_end])->with(['kendaraan', 'borrowed_by', 'processed_by', 'created_by'])->select(sprintf('%s.*', (new Pinjam())->table));
        } else {
            $query = Pinjam::with(['kendaraan', 'borrowed_by', 'processed_by', 'created_by'])->select(sprintf('%s.*', (new Pinjam())->table));
        }

        if ($request->ajax()) {

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'pinjam_show';
                $editGate = 'pinjam_edit';
                $deleteGate = 'pinjam_delete';
                $crudRoutePart = 'pinjams';

                return view('partials.admintablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
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
                if($row->status == 'selesai'){
                    return '<span class="badge badge-dark">Dikembalikan '. $row->date_return_formatted. '</span>';
                } else {
                    return '<span class="badge badge-'.Pinjam::STATUS_BACKGROUND[$row->status].'">'.Pinjam::STATUS_SELECT[$row->status].'</span>';
                }
            });
            $table->editColumn('driver_status', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->driver_status ? 'checked' : null) . '>';
            });
            $table->editColumn('key_status', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->key_status ? 'checked' : null) . '>';
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
}
