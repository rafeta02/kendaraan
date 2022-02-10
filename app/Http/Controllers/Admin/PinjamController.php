<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPinjamRequest;
use App\Http\Requests\StorePinjamRequest;
use App\Http\Requests\UpdatePinjamRequest;
use App\Models\Kendaraan;
use App\Models\Pinjam;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PinjamController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('pinjam_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Pinjam::with(['kendaraan', 'borrowed_by', 'processed_by', 'driver', 'satpam', 'created_by'])->select(sprintf('%s.*', (new Pinjam())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'pinjam_show';
                $editGate = 'pinjam_edit';
                $deleteGate = 'pinjam_delete';
                $crudRoutePart = 'pinjams';

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
            $table->addColumn('kendaraan_plat_no', function ($row) {
                return $row->kendaraan ? $row->kendaraan->plat_no : '';
            });

            $table->editColumn('kendaraan.merk', function ($row) {
                return $row->kendaraan ? (is_string($row->kendaraan) ? $row->kendaraan : $row->kendaraan->merk) : '';
            });
            $table->editColumn('kendaraan.jenis', function ($row) {
                return $row->kendaraan ? (is_string($row->kendaraan) ? $row->kendaraan : $row->kendaraan->jenis) : '';
            });

            $table->editColumn('reason', function ($row) {
                return $row->reason ? $row->reason : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? Pinjam::STATUS_SELECT[$row->status] : '';
            });
            $table->addColumn('borrowed_by_name', function ($row) {
                return $row->borrowed_by ? $row->borrowed_by->name : '';
            });

            $table->editColumn('borrowed_by.email', function ($row) {
                return $row->borrowed_by ? (is_string($row->borrowed_by) ? $row->borrowed_by : $row->borrowed_by->email) : '';
            });
            $table->editColumn('driver_status', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->driver_status ? 'checked' : null) . '>';
            });
            $table->editColumn('key_status', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->key_status ? 'checked' : null) . '>';
            });
            $table->editColumn('surat_permohonan', function ($row) {
                return $row->surat_permohonan ? '<a href="' . $row->surat_permohonan->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'kendaraan', 'borrowed_by', 'driver_status', 'key_status', 'surat_permohonan']);

            return $table->make(true);
        }

        return view('admin.pinjams.index');
    }

    public function create()
    {
        abort_if(Gate::denies('pinjam_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kendaraans = Kendaraan::pluck('plat_no', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.pinjams.create', compact('kendaraans'));
    }

    public function store(StorePinjamRequest $request)
    {
        $pinjam = Pinjam::create($request->all());

        if ($request->input('surat_permohonan', false)) {
            $pinjam->addMedia(storage_path('tmp/uploads/' . basename($request->input('surat_permohonan'))))->toMediaCollection('surat_permohonan');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $pinjam->id]);
        }

        return redirect()->route('admin.pinjams.index');
    }

    public function edit(Pinjam $pinjam)
    {
        abort_if(Gate::denies('pinjam_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kendaraans = Kendaraan::pluck('plat_no', 'id')->prepend(trans('global.pleaseSelect'), '');

        $pinjam->load('kendaraan', 'borrowed_by', 'processed_by', 'driver', 'satpam', 'created_by');

        return view('admin.pinjams.edit', compact('kendaraans', 'pinjam'));
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

        return redirect()->route('admin.pinjams.index');
    }

    public function show(Pinjam $pinjam)
    {
        abort_if(Gate::denies('pinjam_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pinjam->load('kendaraan', 'borrowed_by', 'processed_by', 'driver', 'satpam', 'created_by');

        return view('admin.pinjams.show', compact('pinjam'));
    }

    public function destroy(Pinjam $pinjam)
    {
        abort_if(Gate::denies('pinjam_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pinjam->delete();

        return back();
    }

    public function massDestroy(MassDestroyPinjamRequest $request)
    {
        Pinjam::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('pinjam_create') && Gate::denies('pinjam_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Pinjam();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
