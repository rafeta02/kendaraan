<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Driver;


class DriverTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $drivers = [
            [
                'nip'   => '1995051320200801',
                'nama'  => 'Khavid Wasi Triyoga, S.Kom.',
                'no_wa' => '081226604736',
            ],
            [
                'nip'   => '12345678910',
                'nama'  => 'Haikal',
                'no_wa' => '081339441330',
            ],
        ];

        Driver::insert($drivers);
    }
}
