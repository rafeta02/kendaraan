<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ trans('panel.site_title') }}</title>

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('softland/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('softland/vendor/bootstrap/css/bootstrap.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('softland/vendor/bootstrap-icons/bootstrap-icons.css') }}"
        rel="stylesheet">
    <link href="{{ asset('softland/vendor/boxicons/css/boxicons.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('softland/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('softland/css/style.css') }}" rel="stylesheet">
    @yield('styles')
</head>

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top d-flex align-items-center">
        <div class="container d-flex justify-content-between align-items-center">

            <div class="logo">
                <h1><a href="/">{{ trans('panel.site_title') }}</a></h1>
                <!-- Uncomment below if you prefer to use an image logo -->
                {{-- <a href="index.html"><img src="{{ asset('softland/img/logo.png') }}"
                alt="" class="img-fluid"></a> --}}
            </div>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="{{ (request()->is('/')) ? 'active' : '' }}"
                            href="{{ route('landing') }}">Home</a></li>
                    {{-- <li><a class="{{ (request()->is('features')) ? 'active' : '' }}"
                            href="{{ route('features') }}">Features</a></li> --}}
                    @guest
                        <li><a href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @else
                        <li class="dropdown"><a href="#"><span> {{ Auth::user()->name }}</span> <i
                                    class="bi bi-chevron-down"></i></a>
                            <ul>
                                <li><a href="{{ route('frontend.home') }}">Dashboard</a></li>
                                @can('admin_page')
                                    <li><a href="{{ route('admin.home') }}">Administrator</a></li>
                                @endcan
                                <li><a
                                        href="{{ route('frontend.profile.index') }}">{{ __('My profile') }}</a>
                                </li>
                                <li><a href="{{ route('frontend.kendaraans.index') }}">
                                        {{ trans('cruds.kendaraan.title') }}
                                    </a></li>
                                <li><a href="{{ route('frontend.pinjams.index') }}">
                                        {{ trans('cruds.pinjam.title') }}
                                    </a></li>
                                <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}</a>
                                    <form id="logout-form" action="{{ route('logout') }}"
                                        method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->

    @yield('content')

    <!-- ======= Footer ======= -->
    <footer class="footer" role="contentinfo">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h3>Tentang {{ trans('panel.site_title') }}</h3>
                    <p>{{ trans('panel.site_title') }} Di lingkungan Riset dan Inovasi Universitas
                        Sebelas Maret adalah sebuah Portal Informasi yang digunakan untuk melakukan peminjaman kendaraan
                        di area Riset dan Inovasi Universitas Sebelas Maret</p>
                </div>
                <div class="col-md-7 ms-auto">
                    <div class="row site-section pt-0">
                        <div class="col-md-4 mb-4 mb-md-0">
                            <h3>Layanan Sistem</h3>
                            <ul class="list-unstyled">
                                <li><a target="_blank" rel="noopener" href="https://ocw.uns.ac.id">Open Course Ware
                                        UNS</a></li>
                                <li><a target="_blank" href="https://spada.uns.ac.id">SPADA UNS</a></li>
                                <li><a target="_blank" rel="noopener" href="https://siakad.uns.ac.id">SIAKAD UNS</a>
                                </li>
                                <li><a target="_blank" rel="noopener" href="https://simpeg.uns.ac.id">SIMPEG UNS</a>
                                </li>
                                <li><a target="_blank" rel="noopener" href="https://sipsmart.uns.ac.id">Prestasi
                                        Mahasiswa UNS</a></li>
                                <li><a target="_blank" rel="noopener" href="https://eprints.uns.ac.id/">Institutional
                                        Repository UNS</a></li>
                                <li><a target="_blank" rel="noopener" href="https://digilib.uns.ac.id">Digital Library
                                        UNS</a></li>
                                <li><a target="_blank" rel="noopener" href="https://jurnal.uns.ac.id">E-Journal UNS</a>
                                </li>
                                <li><a target="_blank" rel="noopener" href="https://profil.uns.ac.id/">Email UNS</a>
                                </li>
                                <li><a target="_blank" rel="noopener" href="https://jadwal.uns.ac.id/">Generate Jadwal
                                        UNS</a></li>
                                <li><a target="_blank" rel="noopener" href="https://iris1103.uns.ac.id/">Riset dan
                                        Inovasi UNS</a></li>
                                <li><a target="_blank" rel="noopener" href="https://civitas.uns.ac.id">Blog UNS</a></li>
                                <li><a target="_blank" rel="noopener"
                                        href="https://remunerasi.uns.ac.id/web/">Remunerasi
                                        UNS</a></li>
                                <li><a target="_blank" rel="noopener" href="https://perencanaan.uns.ac.id/">Perencanaan
                                        Terpadu UNS</a></li>
                                <li><a target="_blank" href="https://sikd.uns.ac.id">Kearsipan Dinamis UNS</a></li>
                                <li><a target="_blank" href="https://sibea.mawa.uns.ac.id/">Pelayanan Beasiswa UNS</a>
                                </li>
                                <li><a target="_blank" href="https://sia.uns.ac.id/pajak/">SIA Pendapatan &#038; Pajak
                                        UNS</a></li>
                                <li><a target="_blank" href="https://sia.uns.ac.id/sipp/">SIA SIPP UNS</a></li>
                                <li><a target="_blank" href="https://sister.uns.ac.id/">Sumberdaya Terintegrasi UNS</a>
                                </li>
                                <li><a target="_blank" href="https://b2b.uns.ac.id/">Dokumentasi Kerja Sama UNS</a></li>
                            </ul>
                        </div>
                        <div class="col-md-4 mb-4 mb-md-0">
                            <h3>Portal Informasi</h3>
                            <ul class="list-unstyled">
                                <li><a href="https://uns.ac.id">Laman UNS</a></li>
                                <li>
                                    <a target="_blank" rel="noopener" href="https://spmb.uns.ac.id">Penerimaan
                                        Mahasiswa
                                        Baru UNS</a>
                                </li>
                                <li><a href="https://akademik.uns.ac.id">Akademik UNS</a></li>
                                <li><a href="https://kepeg.auk.uns.ac.id/">Kepegawaian UNS</a></li>
                                <li><a href="https://mawa.uns.ac.id/">Kemahasiswaan UNS</a></li>
                                <li>
                                    <a target="_blank" rel="noopener" href="https://koran.uns.ac.id">UNS on News</a>
                                </li>
                                <li>
                                    <a target="_blank" rel="noopener" href="https://newsroom.uns.ac.id">UNS
                                        Event</a>
                                </li>
                                <li><a target="_blank" rel="noopener" href="https://photostock.uns.ac.id/">Galeri
                                        UNS</a></li>
                                <li><a target="_blank" rel="noopener" href="https://rs.uns.ac.id">Rumah Sakit
                                        UNS</a>
                                </li>
                                <li>
                                    <a href="https://uns.ac.id/id/ukm/">Kiprah Mahasiswa UNS</a>
                                </li>
                                <li><a target="_blank" rel="noopener" href="https://karyaku.uns.ac.id">Karya Ilmiah
                                        Pendidik UNS</a></li>
                                <li><a href="https://greencampus.uns.ac.id">UNS Green Campus</a></li>
                                <li>
                                    <a target="_blank" rel="noopener"
                                        href="https://uns.ac.id/id/category/uns-research/">Produk &#038;
                                        Penelitian</a>
                                </li>
                                <li>
                                    <a target="_blank" rel="noopener"
                                        href="https://uns.ac.id/id/category/uns-berkarya/">Sivitas UNS
                                        Berkarya</a>
                                </li>
                                <li><a href="https://rb.uns.ac.id/">Reformasi Birokrasi UNS</a></li>
                                <li><a target="_blank" rel="noopener" href="https://video.uns.ac.id">Video UNS</a>
                                </li>
                                <li><a href="https://uns.ac.id/id/pidato/">Sambutan Rektor UNS</a></li>
                                <li><a href="https://alumni.uns.ac.id">Alumni UNS</a></li>
                                <li><a href="https://jawametrik.uns.ac.id/">Kearifan Lokal UNS</a></li>
                                <li>
                                    <a target="_blank" rel="noopener" href="https://cdc.uns.ac.id">Lowongan Kerja
                                        dan
                                        Karir</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4 mb-4 mb-md-0">
                            <h3>Social Media</h3>
                            <ul class="list-unstyled">
                                <li>
                                    <a href="https://risnov.uns.ac.id/"><span class="bi bi-globe"></span> Web</a>
                                </li>
                                <li>
                                    <a href="#"><span class="bi bi-twitter"></span> Twitter</a>
                                </li>
                                <li>
                                    <a href="#"><span class="bi bi-facebook"></span> Facebook</a>
                                </li>
                                <li>
                                    <a href="https://www.instagram.com/risnov11maret/"><span
                                            class="bi bi-instagram"></span> Instagram</a>
                                </li>
                                <li>
                                    <a href="#"><span class="bi bi-linkedin"></span> Linkedin</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center text-center">
                <div class="col-md-7">
                    <p class="copyright">&copy; Copyright Risnov. All Rights Reserved</p>
                    <div class="credits">
                        <!--
            All the links in the footer should remain intact.
            You can delete the links only if you purchased the pro version.
            Licensing information: https://bootstrapmade.com/license/
            Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=SoftLand
          -->
                        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                    </div>
                </div>
            </div>

        </div>
    </footer>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('softland/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('softland/vendor/bootstrap/js/bootstrap.bundle.min.js') }}">
    </script>
    <script src="{{ asset('softland/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('softland/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('softland/js/main.js') }}"></script>
    @yield('scripts')
</body>

</html>
