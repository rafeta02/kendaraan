<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPinjamRequest;
use App\Http\Requests\StorePinjamRequest;
use App\Http\Requests\UpdatePinjamRequest;
use App\Models\Kendaraan;
use App\Models\Pinjam;
use App\Models\LogPeminjaman;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DB;

class PinjamController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('front_pinjam'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pinjams = Pinjam::with(['kendaraan', 'borrowed_by', 'processed_by', 'driver', 'satpam', 'created_by'])->get();

        return view('frontend.pinjams.index', compact('pinjams'));
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('front_pinjam'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kendaraans = Kendaraan::all()->pluck('no_nama', 'id');

        if ($request->kendaraan) {
            session()->flashInput(['kendaraan_id' => $request->kendaraan]);
        }

        return view('frontend.pinjams.create', compact('kendaraans'));
    }

    public function store(StorePinjamRequest $request)
    {
        $kendaraan = Kendaraan::find($request->kendaraan_id);

        $request->request->add(['status' => 'diajukan']);
        $request->request->add(['status_text' => 'Diajukan oleh "' . auth()->user()->name .'" peminjaman kendaraan "'.$kendaraan->no_nama .'"']);
        $request->request->add(['borrowed_by_id' => auth()->user()->id]);

        DB::transaction(function() use ($request) {
            $pinjam = Pinjam::create($request->all());

            $log = LogPeminjaman::create([
                'peminjaman_id' => $pinjam->id,
                'kendaraan_id' => $pinjam->kendaraan_id,
                'peminjam_id' => $pinjam->borrowed_by_id,
                'jenis' => 'diajukan',
                'log' => 'Peminjaman kendaraan '. $pinjam->kendaraan->no_nama. ' Diajukan oleh "'. $pinjam->borrowed_by->name.'" Untuk tanggal '. $pinjam->WaktuPeminjaman . ' Dengan keperluan "' . $pinjam->reason .'"',
            ]);
        });
        return redirect()->route('frontend.pinjams.index');
    }

    public function edit(Pinjam $pinjam)
    {
        abort_if(Gate::denies('front_pinjam'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kendaraans = Kendaraan::pluck('plat_no', 'id')->prepend(trans('global.pleaseSelect'), '');

        $pinjam->load('kendaraan', 'borrowed_by', 'processed_by', 'driver', 'satpam', 'created_by');

        return view('frontend.pinjams.edit', compact('kendaraans', 'pinjam'));
    }

    public function update(UpdatePinjamRequest $request, Pinjam $pinjam)
    {
        $pinjam->update($request->all());

        return redirect()->route('frontend.pinjams.index');
    }

    public function show(Pinjam $pinjam)
    {
        abort_if(Gate::denies('front_pinjam'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pinjam->load('kendaraan', 'borrowed_by', 'processed_by', 'driver', 'satpam', 'created_by');

        return view('frontend.pinjams.show', compact('pinjam'));
    }

    public function destroy(Pinjam $pinjam)
    {
        abort_if(Gate::denies('front_pinjam'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pinjam->delete();

        return back();
    }

    public function massDestroy(MassDestroyPinjamRequest $request)
    {
        Pinjam::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
