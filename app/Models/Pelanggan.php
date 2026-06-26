<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';

    protected $fillable = [
        'id_user',
        'nomor_pelanggan',
        'nama_pelanggan',
        'alamat',
        'no_telepon',
        'foto_utp'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function pengaduans(): HasMany
    {
        return $this->hasMany(Pengaduan::class, 'id_pelanggan', 'id_pelanggan');
    }
}

