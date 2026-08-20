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
    ];
}