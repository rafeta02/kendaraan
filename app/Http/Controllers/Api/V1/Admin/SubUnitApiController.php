<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubUnitRequest;
use App\Http\Requests\UpdateSubUnitRequest;
use App\Http\Resources\Admin\SubUnitResource;
use App\Models\SubUnit;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubUnitApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sub_unit_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SubUnitResource(SubUnit::with(['unit'])->get());
    }

    public function store(StoreSubUnitRequest $request)
    {
        $subUnit = SubUnit::create($request->all());

        return (new SubUnitResource($subUnit))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SubUnit $subUnit)
    {
        abort_if(Gate::denies('sub_unit_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SubUnitResource($subUnit->load(['unit']));
    }

    public function update(UpdateSubUnitRequest $request, SubUnit $subUnit)
    {
        $subUnit->update($request->all());

        return (new SubUnitResource($subUnit))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SubUnit $subUnit)
    {
        abort_if(Gate::denies('sub_unit_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subUnit->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
