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
                'nip'   => '12345678910',
                'nama'  => 'Muhamad Haikal Zaki Fadli',
                'no_wa' => '6281339441330',
            ],
            [
                'nip'   => '12345678910',
                'nama'  => 'Latef Aliansyah',
                'no_wa' => '6285951374830',
            ],
            [
                'nip'   => '12345678910',
                'nama'  => 'Randy Indrawirawan',
                'no_wa' => '6281210384788',
            ],
            [
                'nip'   => '12345678910',
                'nama'  => 'Wasito',
                'no_wa' => '6281548664006',
            ],
            [
                'nip'   => '12345678910',
                'nama'  => 'Ristono',
                'no_wa' => '6281567686533',
            ],
            [
                'nip'   => '12345678910',
                'nama'  => 'Margiyanto',
                'no_wa' => '6285878166411',
            ],
            // [
            //     'nip'   => '12345678910',
            //     'nama'  => 'Sumpono',
            //     'no_wa' => '6281393277555',
            // ],
            [
                'nip'   => '12345678910',
                'nama'  => 'Budiyantodrv',
                'no_wa' => '6281329127140',
            ],
            // [
            //     'nip'   => '12345678910',
            //     'nama'  => 'Budi BH',
            //     'no_wa' => '6285747859686',
            // ],
            [
                'nip'   => '12345678910',
                'nama'  => 'Anda',
                'no_wa' => '6282294949474',
            ],
            [
                'nip'   => '12345678910',
                'nama'  => 'Rofiq',
                'no_wa' => '6285229611459',
            ],
            // [
            //     'nip'   => '12345678910',
            //     'nama'  => 'Saiful Pramono',
            //     'no_wa' => '6282243802834',
            // ],
            [
                'nip'   => '12345678910',
                'nama'  => 'Supriyanto',
                'no_wa' => '6285201196745',
            ],
            // [
            //     'nip'   => '12345678910',
            //     'nama'  => 'S.Brita-Driver',
            //     'no_wa' => '6285747491333',
            // ],
            [
                'nip'   => '12345678910',
                'nama'  => 'Ardhika Haby',
                'no_wa' => '6285725526660',
            ],
            [
                'nip'   => '12345678910',
                'nama'  => 'Agus Driver',
                'no_wa' => '6281380462169',
            ],
            // [
            //     'nip'   => '12345678910',
            //     'nama'  => 'Wahyu Driver',
            //     'no_wa' => '6285647527556',
            // ],
        ];

        Driver::insert($drivers);
    }
}
