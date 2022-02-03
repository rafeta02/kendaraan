@extends('layouts.frontend')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6">
                            <div class="card-box bg-blue">
                                <div class="inner">
                                    <h3> {{ $mobil }} </h3>
                                    <p>Jumlah Mobil</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-car" aria-hidden="true"></i>
                                </div>
                                <a href="{{ route('frontend.kendaraans.index', ['jenis' => 'mobil']) }}" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6">
                            <div class="card-box bg-green">
                                <div class="inner">
                                    <h3> {{ $motor }} </h3>
                                    <p>Jumlah Motor</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-motorcycle" aria-hidden="true"></i>
                                </div>
                                <a href="{{ route('frontend.kendaraans.index', ['jenis' => 'motor']) }}" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="card-box bg-orange">
                                <div class="inner">
                                    <h3> {{ $available }} </h3>
                                    <p> Kendaraan Tersedia </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-truck" aria-hidden="true"></i>
                                </div>
                                <a href="{{ route('frontend.kendaraans.index', ['used' => 'nope']) }}" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="card-box bg-red">
                                <div class="inner">
                                    <h3> {{ $dipinjam }} </h3>
                                    <p> Kendaraan Dipinjam </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-bus"></i>
                                </div>
                                <a href="{{ route('frontend.kendaraans.index', ['used' => 'used']) }}" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
