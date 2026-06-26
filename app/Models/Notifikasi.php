<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasi';
    protected $primaryKey = 'id_notifikasi';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_pengaduan',
        'penerima',
        'jenis_notifikasi',
        'pesan',
        'tanggal_kirim'
    ];

    protected $casts = [
        'tanggal_kirim' => 'datetime',
    ];

    // ✅ Relationships
    public function pengaduan(): BelongsTo
    {
        return $this->belongsTo(Pengaduan::class, 'id_pengaduan', 'id_pengaduan');
    }
}
?>
