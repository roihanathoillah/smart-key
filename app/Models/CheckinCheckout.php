<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CheckinCheckout extends Model
{
    use HasFactory;

    protected $table = 'checkin_checkouts';

    protected $fillable = [
        'karyawan_id',
        'smart_box_id',
        'tanggal',
        'jam_checkin',
        'jam_checkout',
        'waktu_scan',
        'id_card_terbaca',
        'lokasi',
        'status',
        'approval_status',
        'approved_by',
        'approved_at',
        'akses_hasil',
    ];

    public function layananPekerjaans()
    {
        return $this->hasMany(
            LayananPekerjaan::class,
            'checkin_checkout_id'
        );
    }
}