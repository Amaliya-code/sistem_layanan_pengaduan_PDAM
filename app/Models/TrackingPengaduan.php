<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrackingPengaduan extends Model
{
    use HasFactory;

   protected $table = 'tracking_pengaduan';

protected $fillable = [
    'id_pengaduan',
    'id_petugas',
    'status',
    'keterangan',
    'tanggal_update'
];

    protected $casts = [
        'tanggal_update' => 'datetime',
    ];

    // ✅ Relationships
    public function pengaduan(): BelongsTo
    {
        return $this->belongsTo(Pengaduan::class, 'id_pengaduan', 'id_pengaduan');
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }
}
?>
