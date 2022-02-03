<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kendaraan;
use App\Models\SubUnit;


class KendaraanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unit = SubUnit::where('slug', 'bagian-tata-usaha-lppm')->first();
        $dih = SubUnit::where('slug', 'bagian-tata-usaha-lppm')->first();
        $kendaraan = [
            [
                'plat_no'           => 'AD1048XA',
                'merk'              => 'TOYOTA INNOVA',
                'jenis'             => 'mobil',
                'kondisi'           => 'layak',
                'operasional'       => 'unit',
                'unit_kerja_id'     => $unit->id,
            ],
            [
                'plat_no'           => 'AD9504LA',
                'merk'              => 'MITSUBISHI KUDA',
                'jenis'             => 'mobil',
                'kondisi'           => 'tidak_layak',
                'operasional'       => 'unit',
                'unit_kerja_id'     => $unit->id,
            ],
            [
                'plat_no'           => 'AD9990CA',
                'merk'              => 'HONDA SUPRA 125',
                'jenis'             => 'motor',
                'kondisi'           => 'layak',
                'operasional'       => 'unit',
                'unit_kerja_id'     => $unit->id,
            ],
            [
                'plat_no'           => 'AD1148XA',
                'merk'              => 'AVANZA',
                'jenis'             => 'mobil',
                'kondisi'           => 'layak',
                'operasional'       => 'unit',
                'unit_kerja_id'     => SubUnit::where('slug', 'bagian-biro-riset-dan-pengabdian-kepada-masyarakat')->first()->id,
            ],
            [
                'plat_no'           => 'AD1629HX',
                'merk'              => 'HILUX',
                'jenis'             => 'mobil',
                'kondisi'           => 'layak',
                'operasional'       => 'unit',
                'unit_kerja_id'     => SubUnit::where('slug', 'bagian-biro-riset-dan-pengabdian-kepada-masyarakat')->first()->id,
            ],
            [
                'plat_no'           => 'AD1146XA',
                'merk'              => 'AVANZA',
                'jenis'             => 'mobil',
                'kondisi'           => 'layak',
                'operasional'       => 'unit',
                'unit_kerja_id'     => SubUnit::where('slug', 'bagian-direkrorat-inovasi-dan-hilirisasi')->first()->id,
            ],
            [
                'plat_no'           => 'AD9822GA',
                'merk'              => 'TRALL HONDA CRF 150cc',
                'jenis'             => 'motor',
                'kondisi'           => 'layak',
                'operasional'       => 'unit',
                'unit_kerja_id'     => SubUnit::where('slug', 'upt-pendidikan-dan-pelatihan-kehutanan')->first()->id,
            ],
            [
                'plat_no'           => 'AD6144XH',
                'merk'              => 'TRALL HONDA CRF 150cc',
                'jenis'             => 'motor',
                'kondisi'           => 'layak',
                'operasional'       => 'unit',
                'unit_kerja_id'     => SubUnit::where('slug', 'upt-pendidikan-dan-pelatihan-kehutanan')->first()->id,
            ],
        ];

        Kendaraan::insert($kendaraan);
    }
}
