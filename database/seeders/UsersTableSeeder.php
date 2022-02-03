<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Superadmin',
                'email'          => 'superadmin@admin.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'id_simpeg'      => '',
                'nip'            => '',
                'no_identitas'   => '',
                'nama'           => '',
                'username'       => '',
                'no_hp'          => '',
                'jwt_token'      => '',
            ],
            [
                'id'             => 2,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'id_simpeg'      => '',
                'nip'            => '',
                'no_identitas'   => '',
                'nama'           => '',
                'username'       => '',
                'no_hp'          => '',
                'jwt_token'      => '',
            ],
            [
                'id'             => 3,
                'name'           => 'Admin LPPM',
                'email'          => 'lppm@admin.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'id_simpeg'      => '',
                'nip'            => '',
                'no_identitas'   => '',
                'nama'           => '',
                'username'       => '',
                'no_hp'          => '',
                'jwt_token'      => '',
            ],
            [
                'id'             => 4,
                'name'           => 'Admin Rumah Tangga',
                'email'          => 'rt@admin.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'id_simpeg'      => '',
                'nip'            => '',
                'no_identitas'   => '',
                'nama'           => '',
                'username'       => '',
                'no_hp'          => '',
                'jwt_token'      => '',
            ],
            [
                'id'             => 5,
                'name'           => 'User',
                'email'          => 'user@user.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'id_simpeg'      => '',
                'nip'            => '',
                'no_identitas'   => '',
                'nama'           => '',
                'username'       => '',
                'no_hp'          => '',
                'jwt_token'      => '',
            ],
        ];

        User::insert($users);
    }
}
