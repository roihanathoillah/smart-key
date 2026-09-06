<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $columns = [
            'alamat' => fn (Blueprint $table) => $table->string('alamat')->nullable(),
            'tanggal_lahir' => fn (Blueprint $table) => $table->date('tanggal_lahir')->nullable(),
            'jenis_kelamin' => fn (Blueprint $table) => $table->string('jenis_kelamin')->nullable(),
            'nik' => fn (Blueprint $table) => $table->string('nik')->nullable()->unique(),
            'ods' => fn (Blueprint $table) => $table->string('ods')->nullable(),
            'status' => fn (Blueprint $table) => $table->string('status')->nullable(),
            'jabatan' => fn (Blueprint $table) => $table->string('jabatan')->nullable(),
        ];

        foreach ($columns as $name => $definition) {
            if (! Schema::hasColumn('users', $name)) {
                Schema::table('users', $definition);
            }
        }
    }

    public function down(): void
    {
        foreach (['alamat', 'tanggal_lahir', 'jenis_kelamin', 'nik', 'ods', 'status', 'jabatan'] as $column) {
            if (Schema::hasColumn('users', $column)) {
                Schema::table('users', function (Blueprint $table) use ($column) {
                    $table->dropColumn($column);
                });
            }
        }
    }
};
