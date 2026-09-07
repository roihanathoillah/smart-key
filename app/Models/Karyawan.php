<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawans';

    protected $fillable = [
        'id_card',
        'nama_lengkap',
        'nik',
        'jabatan',
        'devisi',
        'foto',
        'status',
        'tanggal_lahir',
        'jenis_kelamin',
        'email',
        'alamat',
        'ods_id',
    ];

    /**
     * Hubungkan profil karyawan dengan akun login menggunakan email.
     */
    public function user()
    {
        return $this->hasOne(User::class, 'email', 'email');
    }
}
