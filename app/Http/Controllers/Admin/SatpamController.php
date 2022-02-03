<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySatpamRequest;
use App\Http\Requests\StoreSatpamRequest;
use App\Http\Requests\UpdateSatpamRequest;
use App\Models\Satpam;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SatpamController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('satpam_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Satpam::query()->select(sprintf('%s.*', (new Satpam())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'satpam_show';
                $editGate = 'satpam_edit';
                $deleteGate = 'satpam_delete';
                $crudRoutePart = 'satpams';

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
            $table->editColumn('nip', function ($row) {
                return $row->nip ? $row->nip : '';
            });
            $table->editColumn('nama', function ($row) {
                return $row->nama ? $row->nama : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.satpams.index');
    }

    public function create()
    {
        abort_if(Gate::denies('satpam_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.satpams.create');
    }

    public function store(StoreSatpamRequest $request)
    {
        $satpam = Satpam::create($request->all());

        return redirect()->route('admin.satpams.index');
    }

    public function edit(Satpam $satpam)
    {
        abort_if(Gate::denies('satpam_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.satpams.edit', compact('satpam'));
    }

    public function update(UpdateSatpamRequest $request, Satpam $satpam)
    {
        $satpam->update($request->all());

        return redirect()->route('admin.satpams.index');
    }

    public function show(Satpam $satpam)
    {
        abort_if(Gate::denies('satpam_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.satpams.show', compact('satpam'));
    }

    public function destroy(Satpam $satpam)
    {
        abort_if(Gate::denies('satpam_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $satpam->delete();

        return back();
    }

    public function massDestroy(MassDestroySatpamRequest $request)
    {
        Satpam::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
