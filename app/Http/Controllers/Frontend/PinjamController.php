<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPinjamRequest;
use App\Http\Requests\StorePinjamRequest;
use App\Http\Requests\UpdatePinjamRequest;
use App\Models\Kendaraan;
use App\Models\Pinjam;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PinjamController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('pinjam_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pinjams = Pinjam::with(['kendaraan', 'borrowed_by', 'processed_by', 'driver', 'satpam', 'created_by'])->get();

        return view('frontend.pinjams.index', compact('pinjams'));
    }

    public function create()
    {
        abort_if(Gate::denies('pinjam_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kendaraans = Kendaraan::pluck('plat_no', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.pinjams.create', compact('kendaraans'));
    }

    public function store(StorePinjamRequest $request)
    {
        $pinjam = Pinjam::create($request->all());

        return redirect()->route('frontend.pinjams.index');
    }

    public function edit(Pinjam $pinjam)
    {
        abort_if(Gate::denies('pinjam_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
        abort_if(Gate::denies('pinjam_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pinjam->load('kendaraan', 'borrowed_by', 'processed_by', 'driver', 'satpam', 'created_by');

        return view('frontend.pinjams.show', compact('pinjam'));
    }

    public function destroy(Pinjam $pinjam)
    {
        abort_if(Gate::denies('pinjam_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pinjam->delete();

        return back();
    }

    public function massDestroy(MassDestroyPinjamRequest $request)
    {
        Pinjam::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
