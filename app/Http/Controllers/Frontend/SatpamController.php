<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySatpamRequest;
use App\Http\Requests\StoreSatpamRequest;
use App\Http\Requests\UpdateSatpamRequest;
use App\Models\Satpam;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SatpamController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('satpam_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $satpams = Satpam::all();

        return view('frontend.satpams.index', compact('satpams'));
    }

    public function create()
    {
        abort_if(Gate::denies('satpam_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.satpams.create');
    }

    public function store(StoreSatpamRequest $request)
    {
        $satpam = Satpam::create($request->all());

        return redirect()->route('frontend.satpams.index');
    }

    public function edit(Satpam $satpam)
    {
        abort_if(Gate::denies('satpam_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.satpams.edit', compact('satpam'));
    }

    public function update(UpdateSatpamRequest $request, Satpam $satpam)
    {
        $satpam->update($request->all());

        return redirect()->route('frontend.satpams.index');
    }

    public function show(Satpam $satpam)
    {
        abort_if(Gate::denies('satpam_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.satpams.show', compact('satpam'));
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
