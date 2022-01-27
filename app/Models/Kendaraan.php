<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Kendaraan extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

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
        return $this->hasOne(Pinjam::class, 'kendaraan_id', 'id')->whereNull('date_return');
    }
}
