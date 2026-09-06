<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('checkin_checkouts')) {
            Schema::create('checkin_checkouts', function (Blueprint $table) {
                $table->id();
                $table->string('kode_data')->unique();
                $table->unsignedBigInteger('karyawan_id')->nullable()->index();
                $table->unsignedBigInteger('smart_box_id')->nullable()->index();
                $table->unsignedBigInteger('district_id')->nullable()->index();
                $table->unsignedBigInteger('ods_id')->nullable()->index();
                $table->date('tanggal')->index();
                $table->time('jam_checkin')->nullable();
                $table->time('jam_checkout')->nullable();
                $table->dateTime('waktu_scan')->nullable();
                $table->boolean('id_card_terbaca')->default(false);
                $table->string('lokasi')->nullable();
                $table->string('status')->default('chekin')->index();
                $table->string('approval_status')->default('pending');
                $table->unsignedBigInteger('approved_by')->nullable();
                $table->dateTime('approved_at')->nullable();
                $table->string('akses_hasil')->nullable()->index();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('checkin_checkouts');
    }
};
