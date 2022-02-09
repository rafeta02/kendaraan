<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPinjamRequest;
use App\Http\Requests\StorePinjamRequest;
use App\Http\Requests\UpdatePinjamRequest;
use App\Models\Kendaraan;
use App\Models\Pinjam;
use App\Models\LogPeminjaman;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DB;
use Carbon\Carbon;
use Alert;

class PinjamController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('front_pinjam'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pinjams = Pinjam::with(['kendaraan', 'borrowed_by', 'processed_by', 'driver', 'satpam', 'created_by'])->get();

        return view('frontend.pinjams.index', compact('pinjams'));
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('front_pinjam'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kendaraans = Kendaraan::all()->pluck('no_nama', 'id');

        if ($request->kendaraan) {
            session()->flashInput(['kendaraan_id' => $request->kendaraan]);
        }

        return view('frontend.pinjams.create', compact('kendaraans'));
    }

    public function store(StorePinjamRequest $request)
    {
        $kendaraan = Kendaraan::find($request->kendaraan_id);

        $request->request->add(['status' => 'diajukan']);
        $request->request->add(['status_text' => 'Diajukan oleh "' . auth()->user()->name .'" peminjaman kendaraan "'.$kendaraan->no_nama .'"']);
        $request->request->add(['borrowed_by_id' => auth()->user()->id]);

        $sukses = DB::transaction(function() use ($request) {
            $pinjam = Pinjam::create($request->all());

            $log = LogPeminjaman::create([
                'peminjaman_id' => $pinjam->id,
                'kendaraan_id' => $pinjam->kendaraan_id,
                'peminjam_id' => $pinjam->borrowed_by_id,
                'jenis' => 'diajukan',
                'log' => 'Peminjaman kendaraan '. $pinjam->kendaraan->no_nama. ' Diajukan oleh "'. $pinjam->borrowed_by->name.'" Untuk tanggal '. $pinjam->WaktuPeminjaman . ' Dengan keperluan "' . $pinjam->reason .'"',
            ]);

            return $log['log'];
        });
        $this->kirimWablas('6289669709492', $sukses);

        return redirect()->route('frontend.pinjams.index');
    }

    public function edit(Pinjam $pinjam)
    {
        abort_if(Gate::denies('front_pinjam'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kendaraans = Kendaraan::pluck('plat_no', 'id')->prepend(trans('global.pleaseSelect'), '');

        $pinjam->load('kendaraan', 'borrowed_by', 'processed_by', 'driver', 'satpam', 'created_by');

        return view('frontend.pinjams.edit', compact('kendaraans', 'pinjam'));
    }

    public function update(UpdatePinjamRequest $request, Pinjam $pinjam)
    {
        $pinjam->update($request->all());

        return redirect()->route('frontend.pinjams.index');
    }

    public function show(Pinjam $pinjam)
    {
        abort_if(Gate::denies('front_pinjam'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pinjam->load('kendaraan', 'borrowed_by', 'processed_by', 'driver', 'satpam', 'created_by');

        return view('frontend.pinjams.show', compact('pinjam'));
    }

    public function destroy(Pinjam $pinjam)
    {
        abort_if(Gate::denies('front_pinjam'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pinjam->delete();

        return back();
    }

    public function massDestroy(MassDestroyPinjamRequest $request)
    {
        Pinjam::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function selesai(Request $request)
    {
        try {
            DB::transaction(function() use ($request) {
                $data = Pinjam::find($request->id);
                $data->status = 'selesai';
                $data->is_done = 1;
                $data->date_return = Carbon::now()->format('Y-m-d');
                $data->status_text = 'Peminjaman kendaraan "'.$data->kendaraan->no_nama .'" Telah dikembalikan dan Proses telah diselesaikan oleh "'. auth()->user()->name.", Peminjaman Selesai.";

                $log = LogPeminjaman::create([
                    'peminjaman_id' => $data->id,
                    'kendaraan_id' => $data->kendaraan_id,
                    'peminjam_id' => $data->borrowed_by_id,
                    'jenis' => 'selesai',
                    'log' => 'Peminjaman kendaraan '. $data->kendaraan->no_nama. ' Telah dikembalikan dan Proses telah diselesaikan oleh "'. auth()->user()->name .'" Untuk tanggal '. $data->WaktuPeminjaman . ' Dengan keperluan "' . $data->reason .'", Peminjaman Selesai.',
                ]);

                $kendaraan = Kendaraan::find($data->kendaraan_id);
                $kendaraan->is_used = 0;
                $kendaraan->save();

                $data->save();
            });
            Alert::success('Success', 'Kendaraan telah telah dikembalikan dan peminjaman selesai');
            return redirect()->back();
        } catch (Exception $e) {
            Alert::error('Error', 'Something wrong !');
            return redirect()->back();
        }
    }

    function kirimWablas($phone, $msg)
        {
            $link  =  "https://console.wablas.com/api/send-message";
            $data = [
            'phone' => $phone,
            'message' => $msg,
            ];

            $curl = curl_init();
            $token =  "QW6G6OsQEHhXj3eUv2lXD4xGGpDSWQlnHvlDYc0Mf8TscZJ9vaUNYa7N6pzSYbw8";

            curl_setopt($curl, CURLOPT_HTTPHEADER,
                array(
                    "Authorization: $token",
                )
            );
            curl_setopt($curl, CURLOPT_URL, $link);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $result = curl_exec($curl);
            curl_close($curl);
            return $result;
        }
}
