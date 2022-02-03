<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Unit;

class UnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = [
            [
                'nama'           => 'Kantor Pusat',
                'slug'           => Str::slug('Kantor Pusat', '-'),
            ],
            [
                'nama'           => 'Fakultas Ilmu Budaya',
                'slug'           => Str::slug('Fakultas Ilmu Budaya', '-'),
            ],
            [
                'nama'           => 'Fakultas KIP',
                'slug'           => Str::slug('Fakultas KIP', '-'),
            ],
            [
                'nama'           => 'Fakultas Hukum',
                'slug'           => Str::slug('Fakultas Hukum', '-'),
            ],
            [
                'nama'           => 'Fakultas Ekonomi dan Bisnis',
                'slug'           => Str::slug('Fakultas Ekonomi dan Bisnis', '-'),
            ],
            [
                'nama'           => 'Fakultas Pertanian',
                'slug'           => Str::slug('Fakultas Pertanian', '-'),
            ],
            [
                'nama'           => 'Fakultas Kedokteran',
                'slug'           => Str::slug('Fakultas Kedokteran', '-'),
            ],
            [
                'nama'           => 'Fakultas Teknik',
                'slug'           => Str::slug('Fakultas MIPA', '-'),
            ],
            [
                'nama'           => 'Fakultas Seni Rupa dan Desain',
                'slug'           => Str::slug('Fakultas Seni Rupa dan Desain', '-'),
            ],
            [
                'nama'           => 'Sekolah Pascasarjana',
                'slug'           => Str::slug('Sekolah Pascasarjana', '-'),
            ],
            [
                'nama'           => 'Rumah Sakit',
                'slug'           => Str::slug('Rumah Sakit', '-'),
            ],
            [
                'nama'           => 'Fakultas Keolahragaan',
                'slug'           => Str::slug('Fakultas Keolahragaan', '-'),
            ],
            [
                'nama'           => 'Sekolah Vokasi',
                'slug'           => Str::slug('Sekolah Vokasi', '-'),
            ]
        ];

        Unit::insert($units);
    }
}
