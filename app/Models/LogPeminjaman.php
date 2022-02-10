<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogPeminjaman extends Model
{
    use SoftDeletes;

    public const JENIS_SELECT = [
        'diajukan'     => 'Diajukan',
        'diproses'     => 'Diproses',
        'disetujui'    => 'Disetujui',
        'dipinjam'     => 'Dipinjam',
        'ditolak'      => 'Ditolak',
        'dikembalikan' => 'Dikembalikan',
    ];

    public $table = 'log_peminjamen';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'peminjaman_id',
        'kendaraan_id',
        'peminjam_id',
        'jenis',
        'log',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Pinjam::class, 'peminjaman_id');
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }

    public function peminjam()
    {
        return $this->belongsTo(User::class, 'peminjam_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
