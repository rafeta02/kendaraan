<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreKendaraanRequest;
use App\Http\Requests\UpdateKendaraanRequest;
use App\Http\Resources\Admin\KendaraanResource;
use App\Models\Kendaraan;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KendaraanApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('kendaraan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new KendaraanResource(Kendaraan::with(['drivers', 'unit_kerja'])->get());
    }

    public function store(StoreKendaraanRequest $request)
    {
        $kendaraan = Kendaraan::create($request->all());
        $kendaraan->drivers()->sync($request->input('drivers', []));
        foreach ($request->input('foto', []) as $file) {
            $kendaraan->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('foto');
        }

        return (new KendaraanResource($kendaraan))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Kendaraan $kendaraan)
    {
        abort_if(Gate::denies('kendaraan_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new KendaraanResource($kendaraan->load(['drivers', 'unit_kerja']));
    }

    public function update(UpdateKendaraanRequest $request, Kendaraan $kendaraan)
    {
        $kendaraan->update($request->all());
        $kendaraan->drivers()->sync($request->input('drivers', []));
        if (count($kendaraan->foto) > 0) {
            foreach ($kendaraan->foto as $media) {
                if (!in_array($media->file_name, $request->input('foto', []))) {
                    $media->delete();
                }
            }
        }
        $media = $kendaraan->foto->pluck('file_name')->toArray();
        foreach ($request->input('foto', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $kendaraan->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('foto');
            }
        }

        return (new KendaraanResource($kendaraan))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Kendaraan $kendaraan)
    {
        abort_if(Gate::denies('kendaraan_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kendaraan->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
