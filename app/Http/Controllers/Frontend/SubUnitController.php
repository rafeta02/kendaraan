<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySubUnitRequest;
use App\Http\Requests\StoreSubUnitRequest;
use App\Http\Requests\UpdateSubUnitRequest;
use App\Models\SubUnit;
use App\Models\Unit;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubUnitController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('sub_unit_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subUnits = SubUnit::with(['unit'])->get();

        return view('frontend.subUnits.index', compact('subUnits'));
    }

    public function create()
    {
        abort_if(Gate::denies('sub_unit_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $units = Unit::pluck('nama', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.subUnits.create', compact('units'));
    }

    public function store(StoreSubUnitRequest $request)
    {
        $subUnit = SubUnit::create($request->all());

        return redirect()->route('frontend.sub-units.index');
    }

    public function edit(SubUnit $subUnit)
    {
        abort_if(Gate::denies('sub_unit_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $units = Unit::pluck('nama', 'id')->prepend(trans('global.pleaseSelect'), '');

        $subUnit->load('unit');

        return view('frontend.subUnits.edit', compact('subUnit', 'units'));
    }

    public function update(UpdateSubUnitRequest $request, SubUnit $subUnit)
    {
        $subUnit->update($request->all());

        return redirect()->route('frontend.sub-units.index');
    }

    public function show(SubUnit $subUnit)
    {
        abort_if(Gate::denies('sub_unit_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subUnit->load('unit');

        return view('frontend.subUnits.show', compact('subUnit'));
    }

    public function destroy(SubUnit $subUnit)
    {
        abort_if(Gate::denies('sub_unit_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subUnit->delete();

        return back();
    }

    public function massDestroy(MassDestroySubUnitRequest $request)
    {
        SubUnit::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
