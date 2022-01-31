<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 18,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 19,
                'title' => 'unit_create',
            ],
            [
                'id'    => 20,
                'title' => 'unit_edit',
            ],
            [
                'id'    => 21,
                'title' => 'unit_show',
            ],
            [
                'id'    => 22,
                'title' => 'unit_delete',
            ],
            [
                'id'    => 23,
                'title' => 'unit_access',
            ],
            [
                'id'    => 24,
                'title' => 'sub_unit_create',
            ],
            [
                'id'    => 25,
                'title' => 'sub_unit_edit',
            ],
            [
                'id'    => 26,
                'title' => 'sub_unit_show',
            ],
            [
                'id'    => 27,
                'title' => 'sub_unit_delete',
            ],
            [
                'id'    => 28,
                'title' => 'sub_unit_access',
            ],
            [
                'id'    => 29,
                'title' => 'master_access',
            ],
            [
                'id'    => 30,
                'title' => 'satpam_create',
            ],
            [
                'id'    => 31,
                'title' => 'satpam_edit',
            ],
            [
                'id'    => 32,
                'title' => 'satpam_show',
            ],
            [
                'id'    => 33,
                'title' => 'satpam_delete',
            ],
            [
                'id'    => 34,
                'title' => 'satpam_access',
            ],
            [
                'id'    => 35,
                'title' => 'driver_create',
            ],
            [
                'id'    => 36,
                'title' => 'driver_edit',
            ],
            [
                'id'    => 37,
                'title' => 'driver_show',
            ],
            [
                'id'    => 38,
                'title' => 'driver_delete',
            ],
            [
                'id'    => 39,
                'title' => 'driver_access',
            ],
            [
                'id'    => 40,
                'title' => 'kendaraan_create',
            ],
            [
                'id'    => 41,
                'title' => 'kendaraan_edit',
            ],
            [
                'id'    => 42,
                'title' => 'kendaraan_show',
            ],
            [
                'id'    => 43,
                'title' => 'kendaraan_delete',
            ],
            [
                'id'    => 44,
                'title' => 'kendaraan_access',
            ],
            [
                'id'    => 45,
                'title' => 'log_access',
            ],
            [
                'id'    => 46,
                'title' => 'log_peminjaman_create',
            ],
            [
                'id'    => 47,
                'title' => 'log_peminjaman_edit',
            ],
            [
                'id'    => 48,
                'title' => 'log_peminjaman_show',
            ],
            [
                'id'    => 49,
                'title' => 'log_peminjaman_delete',
            ],
            [
                'id'    => 50,
                'title' => 'log_peminjaman_access',
            ],
            [
                'id'    => 51,
                'title' => 'user_alert_create',
            ],
            [
                'id'    => 52,
                'title' => 'user_alert_show',
            ],
            [
                'id'    => 53,
                'title' => 'user_alert_delete',
            ],
            [
                'id'    => 54,
                'title' => 'user_alert_access',
            ],
            [
                'id'    => 55,
                'title' => 'pinjam_create',
            ],
            [
                'id'    => 56,
                'title' => 'pinjam_edit',
            ],
            [
                'id'    => 57,
                'title' => 'pinjam_show',
            ],
            [
                'id'    => 58,
                'title' => 'pinjam_delete',
            ],
            [
                'id'    => 59,
                'title' => 'pinjam_access',
            ],
            [
                'id'    => 60,
                'title' => 'profile_password_edit',
            ],
        ];

        $mypermissions = [
            [
                'title' => 'process_access',
            ],
            [
                'title' => 'process_accept',
            ],
            [
                'title' => 'process_driver',
            ],
            [
                'title' => 'process_satpam',
            ],
            [
                'title' => 'process_dipinjam',
            ],
            [
                'title' => 'process_selesai',
            ],
        ];

        Permission::insert($permissions);
        Permission::insert($mypermissions);
    }
}
