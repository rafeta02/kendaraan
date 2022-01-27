<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Satpam extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'satpams';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'nip',
        'nama',
        'no_wa',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = ['link_wa'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getLinkWaAttribute()
    {
        return 'https://wa.me/'.$this->attributes['no_wa'].'?text=Titip%20kunci%20lurd';
    }
}
