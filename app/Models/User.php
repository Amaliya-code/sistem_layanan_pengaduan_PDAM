<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\User
 *
 * @method bool isAdmin()
 * @method bool isPetugas()
 * @method bool isPelanggan()
 */
class User extends Authenticatable
{
    protected $table = 'users';

    protected $primaryKey = 'id_user'; // ⭐ PENTING

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'whatsapp',
        'status_verifikasi',
        'foto_ktp'
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /*
    |----------------------------------------------------
    | 🔥 INI FIX PENTING (AUTH IDENTIFIER)
    |----------------------------------------------------
    */
    public function getAuthIdentifierName()
    {
        return 'id_user';
    }

    /*
    |----------------------------------------------------
    | RELATION
    |----------------------------------------------------
    */
    public function pelanggan(): HasOne
    {
        return $this->hasOne(Pelanggan::class, 'id_user', 'id_user');
    }

    public function petugas(): HasOne
    {
        return $this->hasOne(Petugas::class, 'id_user', 'id_user');
    }

    /*
    |----------------------------------------------------
    | ROLE HELPERS
    |----------------------------------------------------
    */
    public function isAdmin(): bool
    {
        return strtolower($this->role) === 'admin';
    }

    public function isPetugas(): bool
    {
        return strtolower($this->role) === 'petugas';
    }

    public function isPelanggan(): bool
    {
        return strtolower($this->role) === 'pelanggan';
    }
}
