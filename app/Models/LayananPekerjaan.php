<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LayananPekerjaan extends Model
{
    protected $table = 'layanan_pekerjaans';

    protected $fillable = [
        'checkin_checkout_id',
        'jenis_layanan',
        'deskripsi_pekerjaan',
    ];

    public function checkinCheckout()
    {
        return $this->belongsTo(
            CheckinCheckout::class,
            'checkin_checkout_id'
        );
    }
}