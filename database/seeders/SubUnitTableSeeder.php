<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use File;
use App\Models\Unit;
use App\Models\SubUnit;
use Illuminate\Support\Str;

class SubUnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/subunit.json");
        $subunits = json_decode($json);

        $unit = Unit::where('nama', 'Kantor Pusat')->first();

        foreach ($subunits as $key => $value) {
            SubUnit::create([
                'unit_id' => $unit->id,
                'nama' => $value->name,
                'slug' => Str::slug($value->name, '-'),
            ]);
        }
    }
}
