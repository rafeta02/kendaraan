<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLogPeminjamanRequest;
use App\Http\Requests\StoreLogPeminjamanRequest;
use App\Http\Requests\UpdateLogPeminjamanRequest;
use App\Models\Kendaraan;
use App\Models\LogPeminjaman;
use App\Models\Pinjam;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogPeminjamanController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('log_peminjaman_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $logPeminjamen = LogPeminjaman::with(['peminjaman', 'kendaraan', 'peminjam'])->get();

        return view('frontend.logPeminjamen.index', compact('logPeminjamen'));
    }

    public function create()
    {
        abort_if(Gate::denies('log_peminjaman_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peminjamen = Pinjam::pluck('reason', 'id')->prepend(trans('global.pleaseSelect'), '');

        $kendaraans = Kendaraan::pluck('plat_no', 'id')->prepend(trans('global.pleaseSelect'), '');

        $peminjams = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.logPeminjamen.create', compact('kendaraans', 'peminjamen', 'peminjams'));
    }

    public function store(StoreLogPeminjamanRequest $request)
    {
        $logPeminjaman = LogPeminjaman::create($request->all());

        return redirect()->route('frontend.log-peminjamen.index');
    }

    public function edit(LogPeminjaman $logPeminjaman)
    {
        abort_if(Gate::denies('log_peminjaman_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peminjamen = Pinjam::pluck('reason', 'id')->prepend(trans('global.pleaseSelect'), '');

        $kendaraans = Kendaraan::pluck('plat_no', 'id')->prepend(trans('global.pleaseSelect'), '');

        $peminjams = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $logPeminjaman->load('peminjaman', 'kendaraan', 'peminjam');

        return view('frontend.logPeminjamen.edit', compact('kendaraans', 'logPeminjaman', 'peminjamen', 'peminjams'));
    }

    public function update(UpdateLogPeminjamanRequest $request, LogPeminjaman $logPeminjaman)
    {
        $logPeminjaman->update($request->all());

        return redirect()->route('frontend.log-peminjamen.index');
    }

    public function show(LogPeminjaman $logPeminjaman)
    {
        abort_if(Gate::denies('log_peminjaman_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $logPeminjaman->load('peminjaman', 'kendaraan', 'peminjam');

        return view('frontend.logPeminjamen.show', compact('logPeminjaman'));
    }

    public function destroy(LogPeminjaman $logPeminjaman)
    {
        abort_if(Gate::denies('log_peminjaman_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $logPeminjaman->delete();

        return back();
    }

    public function massDestroy(MassDestroyLogPeminjamanRequest $request)
    {
        LogPeminjaman::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
