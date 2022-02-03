<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreLogPeminjamanRequest;
use App\Http\Requests\UpdateLogPeminjamanRequest;
use App\Http\Resources\Admin\LogPeminjamanResource;
use App\Models\LogPeminjaman;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogPeminjamanApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('log_peminjaman_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LogPeminjamanResource(LogPeminjaman::with(['peminjaman', 'kendaraan', 'peminjam'])->get());
    }

    public function store(StoreLogPeminjamanRequest $request)
    {
        $logPeminjaman = LogPeminjaman::create($request->all());

        return (new LogPeminjamanResource($logPeminjaman))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(LogPeminjaman $logPeminjaman)
    {
        abort_if(Gate::denies('log_peminjaman_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LogPeminjamanResource($logPeminjaman->load(['peminjaman', 'kendaraan', 'peminjam']));
    }

    public function update(UpdateLogPeminjamanRequest $request, LogPeminjaman $logPeminjaman)
    {
        $logPeminjaman->update($request->all());

        return (new LogPeminjamanResource($logPeminjaman))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(LogPeminjaman $logPeminjaman)
    {
        abort_if(Gate::denies('log_peminjaman_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $logPeminjaman->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
