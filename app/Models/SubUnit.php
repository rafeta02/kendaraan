<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubUnit extends Model
{
    use SoftDeletes;
    use Auditable;

    public $table = 'sub_units';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'unit_id',
        'nama',
        'slug',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function unitKerjaKendaraans()
    {
        return $this->hasMany(Kendaraan::class, 'unit_kerja_id', 'id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
