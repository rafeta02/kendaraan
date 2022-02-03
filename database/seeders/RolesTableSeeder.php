<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'id'    => 1,
                'title' => 'Superadmin',
            ],
            [
                'id'    => 2,
                'title' => 'Administrator',
            ],
            [
                'id'    => 3,
                'title' => 'Admin LPPM',
            ],
            [
                'id'    => 4,
                'title' => 'Admin Rumah Tangga',
            ],
            [
                'id'    => 5,
                'title' => 'User',
            ],
        ];

        Role::insert($roles);
    }
}
