<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Satpam;

class SatpamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $satpams = [
            [
                'nip'   => '12345678910',
                'nama'  => 'Agus',
                'no_wa' => '6285743277998',
            ],
            [
                'nip'   => '12345678910',
                'nama'  => 'Pipit',
                'no_wa' => '628156950541',
            ],
            [
                'nip'   => '12345678910',
                'nama'  => 'Bahar',
                'no_wa' => '6285877627775',
            ],
        ];

        Satpam::insert($satpams);
    }
}
