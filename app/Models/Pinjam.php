<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use App\Traits\MultiTenantModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pinjam extends Model
{
    use SoftDeletes;
    use MultiTenantModelTrait;
    use Auditable;
    use HasFactory;

    public const STATUS_SELECT = [
        'diajukan' => 'Diajukan',
        'diproses' => 'Diproses',
        'dipinjam' => 'Dipinjam',
        'selesai'  => 'Selesai',
    ];

    public $table = 'pinjams';

    protected $dates = [
        'date_start',
        'date_end',
        'date_borrow',
        'date_return',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'kendaraan_id',
        'date_start',
        'date_end',
        'date_borrow',
        'date_return',
        'reason',
        'status',
        'status_text',
        'borrowed_by_id',
        'processed_by_id',
        'driver_status',
        'key_status',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
    ];

    public static function boot()
    {
        parent::boot();
        Pinjam::observe(new \App\Observers\PinjamActionObserver());
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }

    public function getDateStartAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateStartAttribute($value)
    {
        $this->attributes['date_start'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getDateEndAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateEndAttribute($value)
    {
        $this->attributes['date_end'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getDateBorrowAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateBorrowAttribute($value)
    {
        $this->attributes['date_borrow'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getDateReturnAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateReturnAttribute($value)
    {
        $this->attributes['date_return'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function borrowed_by()
    {
        return $this->belongsTo(User::class, 'borrowed_by_id');
    }

    public function processed_by()
    {
        return $this->belongsTo(User::class, 'processed_by_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
