<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPengaduan extends Model
{
    use HasFactory;

    protected $table = 'laporan_pengaduan';
    protected $primaryKey = 'id_laporan';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'periode',
        'total_pengaduan',
        'menunggu',
        'diproses',
        'selesai',
        'ditolak',
        'dibuat_pada'
    ];

    protected $casts = [
        'dibuat_pada' => 'datetime',
    ];
}
?>
