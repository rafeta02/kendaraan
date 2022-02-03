<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyDriverRequest;
use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use App\Models\Driver;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DriverController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('driver_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Driver::query()->select(sprintf('%s.*', (new Driver())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'driver_show';
                $editGate = 'driver_edit';
                $deleteGate = 'driver_delete';
                $crudRoutePart = 'drivers';

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

        return view('admin.drivers.index');
    }

    public function create()
    {
        abort_if(Gate::denies('driver_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.drivers.create');
    }

    public function store(StoreDriverRequest $request)
    {
        $driver = Driver::create($request->all());

        return redirect()->route('admin.drivers.index');
    }

    public function edit(Driver $driver)
    {
        abort_if(Gate::denies('driver_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.drivers.edit', compact('driver'));
    }

    public function update(UpdateDriverRequest $request, Driver $driver)
    {
        $driver->update($request->all());

        return redirect()->route('admin.drivers.index');
    }

    public function show(Driver $driver)
    {
        abort_if(Gate::denies('driver_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $driver->load('driverKendaraans');

        return view('admin.drivers.show', compact('driver'));
    }

    public function destroy(Driver $driver)
    {
        abort_if(Gate::denies('driver_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $driver->delete();

        return back();
    }

    public function massDestroy(MassDestroyDriverRequest $request)
    {
        Driver::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
