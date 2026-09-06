<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('karyawans')) {
            Schema::create('karyawans', function (Blueprint $table) {
                $table->id();
                $table->string('id_card')->unique();
                $table->string('nama_lengkap');
                $table->string('nik')->nullable()->unique();
                $table->string('jabatan')->nullable();
                $table->string('devisi')->nullable();
                $table->string('foto')->nullable();
                $table->string('status')->default('pending');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
