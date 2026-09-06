<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'employee_status')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('employee_status')->default('Pending')->after('password');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'employee_status')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('employee_status');
            });
        }
    }
};
