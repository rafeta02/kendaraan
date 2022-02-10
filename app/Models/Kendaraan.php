<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Kendaraan extends Model implements HasMedia
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;
    use HasMediaTrait;

    public const JENIS_SELECT = [
        'mobil' => 'Mobil',
        'motor' => 'Motor',
    ];

    public const KONDISI_SELECT = [
        'layak'       => 'Layak Pakai',
        'tidak_layak' => 'Tidak Layak Pakai',
    ];

    public const OPERASIONAL_SELECT = [
        'unit'     => 'Operasional Unit',
        'pimpinan' => 'Operasional Pimpinan',
    ];

    public $table = 'kendaraans';

    protected $appends = [
        'foto',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'plat_no',
        'merk',
        'jenis',
        'kondisi',
        'operasional',
        'unit_kerja_id',
        'is_used',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function kendaraanPinjams()
    {
        return $this->hasMany(Pinjam::class, 'kendaraan_id', 'id');
    }

    public function drivers()
    {
        return $this->belongsToMany(Driver::class);
    }

    public function unit_kerja()
    {
        return $this->belongsTo(SubUnit::class, 'unit_kerja_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getNoPolAttribute()
    {
        preg_match_all("/[A-Z]+|\d+/", $this->attributes['plat_no'], $matches);
        return implode('-', $matches[0]);
    }

    public function getNamaAttribute()
    {
        return Str::title($this->attributes['jenis']).' - '.Str::title($this->attributes['merk']);
    }

    public function getNoNamaAttribute()
    {
        preg_match_all("/[A-Z]+|\d+/", $this->attributes['plat_no'], $matches);
        $no_po = implode('-', $matches[0]);
        return $no_po. ' - '. Str::title($this->attributes['jenis']).' - '.Str::title($this->attributes['merk']);
    }

    public function peminjaman()
    {
        // return $this->hasOne(Pinjam::class, 'kendaraan_id', 'id')->where('is_done', 0);
        return $this->hasMany(Pinjam::class, 'kendaraan_id', 'id')->where('is_done', 0);
    }

    public function getFotoAttribute()
    {
        $files = $this->getMedia('foto');
        $files->each(function ($item) {
            $item->url = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview = $item->getUrl('preview');
        });

        return $files;
    }
}
