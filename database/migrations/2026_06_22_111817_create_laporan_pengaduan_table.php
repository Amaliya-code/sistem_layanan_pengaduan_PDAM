<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('laporan_pengaduan')) {
            Schema::create('laporan_pengaduan', function (Blueprint $table) {
                $table->id('id_laporan');
                $table->string('periode', 20);
                $table->integer('total_pengaduan')->default(0);
                $table->integer('menunggu')->default(0);
                $table->integer('diproses')->default(0);
                $table->integer('selesai')->default(0);
                $table->integer('ditolak')->default(0);
                $table->timestamp('dibuat_pada');
                $table->timestamps();

                $table->unique('periode');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_pengaduan');
    }
};
?>
