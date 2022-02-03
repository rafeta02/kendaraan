<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyLogPeminjamanRequest;
use App\Http\Requests\StoreLogPeminjamanRequest;
use App\Http\Requests\UpdateLogPeminjamanRequest;
use App\Models\Kendaraan;
use App\Models\LogPeminjaman;
use App\Models\Pinjam;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class LogPeminjamanController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('log_peminjaman_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = LogPeminjaman::with(['peminjaman', 'kendaraan', 'peminjam'])->select(sprintf('%s.*', (new LogPeminjaman())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'log_peminjaman_show';
                $editGate = 'log_peminjaman_edit';
                $deleteGate = 'log_peminjaman_delete';
                $crudRoutePart = 'log-peminjamen';

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
            $table->addColumn('peminjaman_reason', function ($row) {
                return $row->peminjaman ? $row->peminjaman->reason : '';
            });
            $table->addColumn('kendaraan_no_nama', function ($row) {
                return $row->kendaraan ? $row->kendaraan->no_nama : '';
            });

            $table->editColumn('peminjaman.id', function ($row) {
                return $row->peminjaman ? ('ID: <h5>'. $row->peminjaman->id .'</h5>Created at:<br> <b>'.$row->created_at.'</b>') : '';
            });

            $table->editColumn('peminjaman.date_start', function ($row) {
                return $row->peminjaman ? (is_string($row->peminjaman) ? $row->peminjaman : $row->peminjaman->date_start) : '';
            });
            $table->editColumn('peminjaman.date_end', function ($row) {
                return $row->peminjaman ? (is_string($row->peminjaman) ? $row->peminjaman : $row->peminjaman->date_end) : '';
            });
            $table->addColumn('kendaraan_plat_no', function ($row) {
                return $row->kendaraan ? $row->kendaraan->plat_no : '';
            });

            $table->editColumn('kendaraan.merk', function ($row) {
                return $row->kendaraan ? (is_string($row->kendaraan) ? $row->kendaraan : $row->kendaraan->merk) : '';
            });
            $table->addColumn('peminjam_name', function ($row) {
                return $row->peminjam ? $row->peminjam->name : '';
            });

            $table->editColumn('jenis', function ($row) {
                return $row->jenis ? LogPeminjaman::JENIS_SELECT[$row->jenis] : '';
            });

            $table->editColumn('log', function ($row) {
                return $row->log ? $row->log : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'peminjaman', 'kendaraan', 'peminjam', 'peminjaman.id']);

            return $table->make(true);
        }

        return view('admin.logPeminjamen.index');
    }

    public function create()
    {
        abort_if(Gate::denies('log_peminjaman_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peminjamen = Pinjam::pluck('reason', 'id')->prepend(trans('global.pleaseSelect'), '');

        $kendaraans = Kendaraan::pluck('plat_no', 'id')->prepend(trans('global.pleaseSelect'), '');

        $peminjams = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.logPeminjamen.create', compact('kendaraans', 'peminjamen', 'peminjams'));
    }

    public function store(StoreLogPeminjamanRequest $request)
    {
        $logPeminjaman = LogPeminjaman::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $logPeminjaman->id]);
        }

        return redirect()->route('admin.log-peminjamen.index');
    }

    public function edit(LogPeminjaman $logPeminjaman)
    {
        abort_if(Gate::denies('log_peminjaman_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peminjamen = Pinjam::pluck('reason', 'id')->prepend(trans('global.pleaseSelect'), '');

        $kendaraans = Kendaraan::pluck('plat_no', 'id')->prepend(trans('global.pleaseSelect'), '');

        $peminjams = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $logPeminjaman->load('peminjaman', 'kendaraan', 'peminjam');

        return view('admin.logPeminjamen.edit', compact('kendaraans', 'logPeminjaman', 'peminjamen', 'peminjams'));
    }

    public function update(UpdateLogPeminjamanRequest $request, LogPeminjaman $logPeminjaman)
    {
        $logPeminjaman->update($request->all());

        return redirect()->route('admin.log-peminjamen.index');
    }

    public function show(LogPeminjaman $logPeminjaman)
    {
        abort_if(Gate::denies('log_peminjaman_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $logPeminjaman->load('peminjaman', 'kendaraan', 'peminjam');

        return view('admin.logPeminjamen.show', compact('logPeminjaman'));
    }

    public function destroy(LogPeminjaman $logPeminjaman)
    {
        abort_if(Gate::denies('log_peminjaman_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $logPeminjaman->delete();

        return back();
    }

    public function massDestroy(MassDestroyLogPeminjamanRequest $request)
    {
        LogPeminjaman::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('log_peminjaman_create') && Gate::denies('log_peminjaman_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new LogPeminjaman();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
