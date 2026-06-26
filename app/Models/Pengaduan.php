<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduans';
    protected $primaryKey = 'id_pengaduan';

    protected $fillable = [
        'id_pelanggan',
        'nomor_pengaduan',
        'jenis_pengaduan',
        'judul_pengaduan',
        'deskripsi',
        'lokasi',
        'foto_bukti',
        'status',
        'tanggal_pengaduan',
    ];

    protected $casts = [
        'tanggal_pengaduan' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function getUserAttribute()
    {
        return $this->pelanggan?->user;
    }

    public function trackingPengaduans(): HasMany
    {
        return $this->hasMany(TrackingPengaduan::class, 'id_pengaduan', 'id_pengaduan');
    }

    public function tracking(): HasMany
    {
        return $this->trackingPengaduans();
    }

    public static function generateNomorPengaduan(): string
    {
        $last = self::latest('id_pengaduan')->first();
        $next = $last ? $last->id_pengaduan + 1 : 1;

        return 'PDAM-' . str_pad($next, 6, '0', STR_PAD_LEFT);
    }
}
