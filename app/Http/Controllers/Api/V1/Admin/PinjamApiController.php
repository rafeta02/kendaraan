<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StorePinjamRequest;
use App\Http\Requests\UpdatePinjamRequest;
use App\Http\Resources\Admin\PinjamResource;
use App\Models\Pinjam;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PinjamApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('pinjam_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PinjamResource(Pinjam::with(['kendaraan', 'borrowed_by', 'processed_by', 'driver', 'satpam', 'created_by'])->get());
    }

    public function store(StorePinjamRequest $request)
    {
        $pinjam = Pinjam::create($request->all());

        if ($request->input('surat_permohonan', false)) {
            $pinjam->addMedia(storage_path('tmp/uploads/' . basename($request->input('surat_permohonan'))))->toMediaCollection('surat_permohonan');
        }

        return (new PinjamResource($pinjam))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Pinjam $pinjam)
    {
        abort_if(Gate::denies('pinjam_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PinjamResource($pinjam->load(['kendaraan', 'borrowed_by', 'processed_by', 'driver', 'satpam', 'created_by']));
    }

    public function update(UpdatePinjamRequest $request, Pinjam $pinjam)
    {
        $pinjam->update($request->all());

        if ($request->input('surat_permohonan', false)) {
            if (!$pinjam->surat_permohonan || $request->input('surat_permohonan') !== $pinjam->surat_permohonan->file_name) {
                if ($pinjam->surat_permohonan) {
                    $pinjam->surat_permohonan->delete();
                }
                $pinjam->addMedia(storage_path('tmp/uploads/' . basename($request->input('surat_permohonan'))))->toMediaCollection('surat_permohonan');
            }
        } elseif ($pinjam->surat_permohonan) {
            $pinjam->surat_permohonan->delete();
        }

        return (new PinjamResource($pinjam))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Pinjam $pinjam)
    {
        abort_if(Gate::denies('pinjam_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pinjam->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
