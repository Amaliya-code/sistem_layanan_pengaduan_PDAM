<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add verification status to users table
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('status_verifikasi')->default(false)->after('role');
            $table->string('foto_ktp')->nullable()->after('status_verifikasi');
        });

        // Add UTP photo to pelanggan table
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->string('foto_utp')->nullable()->after('no_telepon');
        });
    }

    public function down(): void
    {
        // Remove columns from users table
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['status_verifikasi', 'foto_ktp']);
        });

        // Remove column from pelanggan table
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->dropColumn('foto_utp');
        });
    }
};
