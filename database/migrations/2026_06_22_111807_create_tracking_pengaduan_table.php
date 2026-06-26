<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('tracking_pengaduan', function (Blueprint $table) {
    $table->id('id_tracking');

    $table->unsignedBigInteger('id_pengaduan');
    $table->unsignedBigInteger('id_petugas')->nullable();

    $table->foreign('id_pengaduan')
        ->references('id_pengaduan')
        ->on('pengaduans')
        ->onDelete('cascade');

    $table->foreign('id_petugas')
        ->references('id_petugas')
        ->on('petugas')
        ->nullOnDelete();

    $table->string('status');
    $table->text('keterangan');
    $table->timestamp('tanggal_update');

    $table->timestamps();

    $table->index('id_pengaduan');
    $table->index('id_petugas');
});
    }

    public function down(): void
    {
        Schema::dropIfExists('tracking_pengaduan');
    }
};
