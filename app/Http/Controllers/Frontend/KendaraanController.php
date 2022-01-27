<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyKendaraanRequest;
use App\Http\Requests\StoreKendaraanRequest;
use App\Http\Requests\UpdateKendaraanRequest;
use App\Models\Driver;
use App\Models\Kendaraan;
use App\Models\SubUnit;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KendaraanController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('kendaraan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unit_kerjas = SubUnit::pluck('nama', 'id')->prepend(trans('global.pleaseSelect'), '');

        $query = Kendaraan::with(['unit_kerja', 'peminjaman']);
        if ($request->jenis) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->used) {
            $query->where('is_used', ($request->used === 'used' ? 1 : 0));
        }

        if ($request->plat_no) {
            $query->where('plat_no','LIKE','%'.$request->plat_no.'%');
        }

        if ($request->merk) {
            $query->where('merk','LIKE','%'.$request->merk.'%');
        }

        if ($request->unit_kerja_id) {
            $query->where('unit_kerja_id', $request->unit_kerja_id);
        }

        // if ($request->status) {
        //     $query->whereHas('peminjaman', function($query) use ($request)  {
        //         $query->where('status', $request->status);
        //     });
        // }

        $kendaraans = $query->get();

        session()->flashInput($request->input());

        return view('frontend.kendaraans.index', compact('kendaraans', 'unit_kerjas'));
    }

    public function create()
    {
        abort_if(Gate::denies('kendaraan_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $drivers = Driver::pluck('nama', 'id');

        $unit_kerjas = SubUnit::pluck('nama', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.kendaraans.create', compact('drivers', 'unit_kerjas'));
    }

    public function store(StoreKendaraanRequest $request)
    {
        $kendaraan = Kendaraan::create($request->all());
        $kendaraan->drivers()->sync($request->input('drivers', []));

        return redirect()->route('frontend.kendaraans.index');
    }

    public function edit(Kendaraan $kendaraan)
    {
        abort_if(Gate::denies('kendaraan_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $drivers = Driver::pluck('nama', 'id');

        $unit_kerjas = SubUnit::pluck('nama', 'id')->prepend(trans('global.pleaseSelect'), '');

        $kendaraan->load('drivers', 'unit_kerja');

        return view('frontend.kendaraans.edit', compact('drivers', 'kendaraan', 'unit_kerjas'));
    }

    public function update(UpdateKendaraanRequest $request, Kendaraan $kendaraan)
    {
        $kendaraan->update($request->all());
        $kendaraan->drivers()->sync($request->input('drivers', []));

        return redirect()->route('frontend.kendaraans.index');
    }

    public function show(Kendaraan $kendaraan)
    {
        abort_if(Gate::denies('kendaraan_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kendaraan->load('drivers', 'unit_kerja', 'kendaraanPinjams');

        return view('frontend.kendaraans.show', compact('kendaraan'));
    }

    public function destroy(Kendaraan $kendaraan)
    {
        abort_if(Gate::denies('kendaraan_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kendaraan->delete();

        return back();
    }

    public function massDestroy(MassDestroyKendaraanRequest $request)
    {
        Kendaraan::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
