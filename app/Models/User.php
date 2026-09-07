<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'username',
    'nama_lengkap',
    'email',
    'password',
    'nomor_hp',
    'foto_profil',
    'role',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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

    /**
     * Compatibility untuk kode lama yang masih memanggil $user->name.
     */
    public function getNameAttribute(): string
    {
        return (string) (
            $this->attributes['nama_lengkap']
            ?? $this->attributes['username']
            ?? ''
        );
    }

    /**
     * Hubungkan akun login dengan profil karyawan menggunakan email.
     */
    public function karyawan()
    {
        return $this->hasOne(Karyawan::class, 'email', 'email');
    }
}
