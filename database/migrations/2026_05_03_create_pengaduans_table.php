<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id('id_pengaduan');
            $table->unsignedBigInteger('id_pelanggan');
            $table->string('nomor_pengaduan')->unique();
            $table->string('jenis_pengaduan', 100);
            $table->string('judul_pengaduan', 150);
            $table->text('deskripsi');
            $table->string('lokasi')->nullable();
            $table->string('foto_bukti')->nullable();
            $table->enum('status', ['menunggu', 'diproses', 'selesai', 'ditolak'])->default('menunggu');
            $table->timestamp('tanggal_pengaduan');
            $table->timestamps();

            $table->foreign('id_pelanggan')
                ->references('id_pelanggan')
                ->on('pelanggan')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};
