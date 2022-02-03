<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Kendaraan;
use App\Models\SubUnit;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    public function index()
    {
        abort_if(Gate::denies('front_dashboard'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $mobil = Kendaraan::where('jenis', 'mobil')->count();
        $motor = Kendaraan::where('jenis', 'motor')->count();
        $available = Kendaraan::where('is_used', 0)->count();
        $dipinjam = Kendaraan::where('is_used', 1)->count();
        return view('frontend.home', compact('mobil', 'motor', 'available', 'dipinjam'));
    }
}
