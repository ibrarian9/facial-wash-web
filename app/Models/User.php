<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'age',
        'status',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    const STATUS_PELAJAR = 'Pelajar';
    const STATUS_MAHASISWA = 'Mahasiswa';
    const STATUS_PEKERJA = 'Pekerja';
    const STATUS_LAINNYA = 'Lainnya';

    /**
     * 2. Helper Statis: Ambil Daftar Status
     * Berguna untuk validasi 'in:...' di Controller atau looping <option> di View
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_PELAJAR,
            self::STATUS_MAHASISWA,
            self::STATUS_PEKERJA,
            self::STATUS_LAINNYA,
        ];
    }

    public function isAdmin()
    {
        return $this->role === 1;
    }

    public function isUser()
    {
        return $this->role === 2;
    }
}
