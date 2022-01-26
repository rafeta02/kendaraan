<?php

return [
    'userManagement' => [
        'title'          => 'User management',
        'title_singular' => 'User management',
    ],
    'permission' => [
        'title'          => 'Permissions',
        'title_singular' => 'Permission',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'title'             => 'Title',
            'title_helper'      => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'role' => [
        'title'          => 'Roles',
        'title_singular' => 'Role',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'title'              => 'Title',
            'title_helper'       => ' ',
            'permissions'        => 'Permissions',
            'permissions_helper' => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
        ],
    ],
    'user' => [
        'title'          => 'Users',
        'title_singular' => 'User',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => ' ',
            'name'                     => 'Name',
            'name_helper'              => ' ',
            'email'                    => 'Email',
            'email_helper'             => ' ',
            'email_verified_at'        => 'Email verified at',
            'email_verified_at_helper' => ' ',
            'password'                 => 'Password',
            'password_helper'          => ' ',
            'roles'                    => 'Roles',
            'roles_helper'             => ' ',
            'remember_token'           => 'Remember Token',
            'remember_token_helper'    => ' ',
            'created_at'               => 'Created at',
            'created_at_helper'        => ' ',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => ' ',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => ' ',
            'id_simpeg'                => 'ID Simpeg',
            'id_simpeg_helper'         => ' ',
            'nip'                      => 'NIP/NIK',
            'nip_helper'               => ' ',
            'no_identitas'             => 'No Identitas',
            'no_identitas_helper'      => ' ',
            'nama'                     => 'Nama',
            'nama_helper'              => ' ',
            'username'                 => 'Username',
            'username_helper'          => ' ',
            'alamat'                   => 'Alamat',
            'alamat_helper'            => ' ',
            'no_hp'                    => 'No Handphone',
            'no_hp_helper'             => ' ',
            'foto_url'                 => 'Foto',
            'foto_url_helper'          => ' ',
            'jwt_token'                => 'Jwt Token',
            'jwt_token_helper'         => ' ',
            'unit'                     => 'Unit',
            'unit_helper'              => ' ',
        ],
    ],
    'auditLog' => [
        'title'          => 'Audit Logs',
        'title_singular' => 'Audit Log',
        'fields'         => [
            'id'                  => 'ID',
            'id_helper'           => ' ',
            'description'         => 'Description',
            'description_helper'  => ' ',
            'subject_id'          => 'Subject ID',
            'subject_id_helper'   => ' ',
            'subject_type'        => 'Subject Type',
            'subject_type_helper' => ' ',
            'user_id'             => 'User ID',
            'user_id_helper'      => ' ',
            'properties'          => 'Properties',
            'properties_helper'   => ' ',
            'host'                => 'Host',
            'host_helper'         => ' ',
            'created_at'          => 'Created at',
            'created_at_helper'   => ' ',
            'updated_at'          => 'Updated at',
            'updated_at_helper'   => ' ',
        ],
    ],
    'unit' => [
        'title'          => 'Unit',
        'title_singular' => 'Unit',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'nama'              => 'Nama',
            'nama_helper'       => ' ',
            'slug'              => 'Slug',
            'slug_helper'       => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'subUnit' => [
        'title'          => 'Sub Unit',
        'title_singular' => 'Sub Unit',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'unit'              => 'Unit',
            'unit_helper'       => ' ',
            'nama'              => 'Nama',
            'nama_helper'       => ' ',
            'slug'              => 'Slug',
            'slug_helper'       => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'master' => [
        'title'          => 'Master',
        'title_singular' => 'Master',
    ],
    'satpam' => [
        'title'          => 'Satpam',
        'title_singular' => 'Satpam',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'nip'               => 'NIP/NIK',
            'nip_helper'        => ' ',
            'nama'              => 'Nama',
            'nama_helper'       => ' ',
            'no_wa'             => 'No Whatshapp',
            'no_wa_helper'      => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'driver' => [
        'title'          => 'Driver',
        'title_singular' => 'Driver',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'nip'               => 'NIP/NIK',
            'nip_helper'        => ' ',
            'nama'              => 'Nama',
            'nama_helper'       => ' ',
            'no_wa'             => 'No Whatshapp',
            'no_wa_helper'      => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'kendaraan' => [
        'title'          => 'Kendaraan',
        'title_singular' => 'Kendaraan',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'plat_no'            => 'No Kendaraan',
            'plat_no_helper'     => ' ',
            'merk'               => 'Seri dan Merk',
            'merk_helper'        => ' ',
            'jenis'              => 'Jenis',
            'jenis_helper'       => ' ',
            'kondisi'            => 'Kondisi',
            'kondisi_helper'     => ' ',
            'operasional'        => 'Jenis Operasional',
            'operasional_helper' => ' ',
            'driver'             => 'Driver',
            'driver_helper'      => ' ',
            'unit_kerja'         => 'Unit Kerja',
            'unit_kerja_helper'  => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
            'is_used'            => 'Digunakan',
            'is_used_helper'     => ' ',
        ],
    ],
    'log' => [
        'title'          => 'Log',
        'title_singular' => 'Log',
    ],
    'logPeminjaman' => [
        'title'          => 'Log Peminjaman',
        'title_singular' => 'Log Peminjaman',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'kendaraan'         => 'Kendaraan',
            'kendaraan_helper'  => ' ',
            'peminjam'          => 'Peminjam',
            'peminjam_helper'   => ' ',
            'jenis'             => 'Jenis',
            'jenis_helper'      => ' ',
            'log'               => 'Log',
            'log_helper'        => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
            'peminjaman'        => 'Peminjaman',
            'peminjaman_helper' => ' ',
        ],
    ],
    'userAlert' => [
        'title'          => 'User Alerts',
        'title_singular' => 'User Alert',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'alert_text'        => 'Alert Text',
            'alert_text_helper' => ' ',
            'alert_link'        => 'Alert Link',
            'alert_link_helper' => ' ',
            'user'              => 'Users',
            'user_helper'       => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
        ],
    ],
    'pinjam' => [
        'title'          => 'Peminjaman',
        'title_singular' => 'Peminjaman',
        'fields'         => [
            'id'                   => 'ID',
            'id_helper'            => ' ',
            'kendaraan'            => 'Kendaraan',
            'kendaraan_helper'     => ' ',
            'waktu_peminjaman'     => 'Waktu Peminjaman',
            'date_start'           => 'Tanggal Mulai',
            'date_start_helper'    => ' ',
            'date_end'             => 'Tanggal Selesai',
            'date_end_helper'      => ' ',
            'date_borrow'          => 'Date Borrow',
            'date_borrow_helper'   => ' ',
            'date_return'          => 'Date Return',
            'date_return_helper'   => ' ',
            'reason'               => 'Keperluan',
            'reason_helper'        => ' ',
            'status'               => 'Status',
            'status_helper'        => ' ',
            'status_text'          => 'Status Text',
            'status_text_helper'   => ' ',
            'borrowed_by'          => 'Borrowed By',
            'borrowed_by_helper'   => ' ',
            'processed_by'         => 'Processed By',
            'processed_by_helper'  => ' ',
            'driver_status'        => 'Status Sopir',
            'driver_status_helper' => ' ',
            'key_status'           => 'Status Kunci',
            'key_status_helper'    => ' ',
            'created_at'           => 'Created at',
            'created_at_helper'    => ' ',
            'updated_at'           => 'Updated at',
            'updated_at_helper'    => ' ',
            'deleted_at'           => 'Deleted at',
            'deleted_at_helper'    => ' ',
            'created_by'           => 'Created By',
            'created_by_helper'    => ' ',
            'driver'               => 'Driver',
            'driver_helper'        => ' ',
            'satpam'               => 'Satpam',
            'satpam_helper'        => ' ',
        ],
    ],
];
