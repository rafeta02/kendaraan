<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use App\Traits\MultiTenantModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Pinjam extends Model implements HasMedia
{
    use SoftDeletes;
    use MultiTenantModelTrait;
    use Auditable;
    use HasFactory;
    use HasMediaTrait;

    public const STATUS_SELECT = [
        'diajukan' => 'Diajukan',
        'diproses' => 'Diproses',
        // 'diterima' => 'Diterima',
        'dipinjam' => 'Dipinjam',
        'selesai'  => 'Selesai',
        'ditolak'  => 'Ditolak',
    ];

    public const STATUS_BACKGROUND = [
        'diajukan' => 'primary',
        'diproses' => 'warning',
        // 'diterima' => 'secondary',
        'dipinjam' => 'danger',
        'selesai'  => 'dark',
        'ditolak'  => 'dark',
    ];

    public $table = 'pinjams';

    protected $appends = [
        'surat_permohonan',
    ];

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
        'driver_id',
        'key_status',
        'satpam_id',
        'created_at',
        'is_done',
        'updated_at',
        'deleted_at',
        'created_by_id',
    ];

    public static function boot()
    {
        parent::boot();
        Pinjam::observe(new \App\Observers\PinjamActionObserver());
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
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

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function satpam()
    {
        return $this->belongsTo(Satpam::class, 'satpam_id');
    }

    public function getSuratPermohonanAttribute()
    {
        return $this->getMedia('surat_permohonan')->last();
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getWaktuPeminjamanAttribute()
    {
        $date_start = Carbon::parse($this->attributes['date_start'])->format('d F Y');
        $date_end = Carbon::parse($this->attributes['date_end'])->format('d F Y');
        return $date_start. ' - '. $date_end;
    }

    public function getDateReturnFormattedAttribute()
    {
        if ($this->attributes['date_return'] == null) {
            return null;
        }

        return Carbon::parse($this->attributes['date_return'])->format('d F Y');
    }

    public function gettanggalPengajuanAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d F Y');
    }
}
