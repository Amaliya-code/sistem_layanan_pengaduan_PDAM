<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('petugas')) {
            Schema::create('petugas', function (Blueprint $table) {
    $table->id('id_petugas');

    $table->unsignedBigInteger('id_user');

    $table->foreign('id_user')
        ->references('id_user')
        ->on('users')
        ->onDelete('cascade');

    $table->string('nama_petugas');
    $table->string('jabatan')->nullable();
    $table->string('no_telepon')->nullable();

    $table->timestamps();

    $table->index('id_user');
});
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('petugas');
    }
};

