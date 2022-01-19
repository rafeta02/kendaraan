<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;

class SubUnitController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('sub_unit_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SubUnit::with(['unit'])->select(sprintf('%s.*', (new SubUnit())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'sub_unit_show';
                $editGate = 'sub_unit_edit';
                $deleteGate = 'sub_unit_delete';
                $crudRoutePart = 'sub-units';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->addColumn('unit_nama', function ($row) {
                return $row->unit ? $row->unit->nama : '';
            });

            $table->editColumn('nama', function ($row) {
                return $row->nama ? $row->nama : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'unit']);

            return $table->make(true);
        }

        return view('admin.subUnits.index');
    }

    public function create()
    {
        abort_if(Gate::denies('sub_unit_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $units = Unit::pluck('nama', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.subUnits.create', compact('units'));
    }

    public function store(StoreSubUnitRequest $request)
    {
        $subUnit = SubUnit::create($request->all());

        return redirect()->route('admin.sub-units.index');
    }

    public function edit(SubUnit $subUnit)
    {
        abort_if(Gate::denies('sub_unit_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $units = Unit::pluck('nama', 'id')->prepend(trans('global.pleaseSelect'), '');

        $subUnit->load('unit');

        return view('admin.subUnits.edit', compact('subUnit', 'units'));
    }

    public function update(UpdateSubUnitRequest $request, SubUnit $subUnit)
    {
        $subUnit->update($request->all());

        return redirect()->route('admin.sub-units.index');
    }

    public function show(SubUnit $subUnit)
    {
        abort_if(Gate::denies('sub_unit_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subUnit->load('unit', 'unitKerjaKendaraans');

        return view('admin.subUnits.show', compact('subUnit'));
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
