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
                'plat_no'           => 'AD9990 CA',
                'merk'              => 'HONDA SUPRA 125',
                'jenis'             => 'motor',
                'kondisi'           => 'layak',
                'operasional'       => 'unit',
                'unit_kerja_id'     => $unit->id,
            ],
        ];

        Kendaraan::insert($kendaraan);
    }
}
