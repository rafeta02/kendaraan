<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class LogPeminjaman extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use HasFactory;

    public const JENIS_SELECT = [
        'diajukan' => 'Diajukan',
        'diproses' => 'Diproses',
        // 'diterima' => 'Diterima',
        'dipinjam' => 'Dipinjam',
        'selesai'  => 'Selesai',
        'ditolak'  => 'Ditolak',
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

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

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
