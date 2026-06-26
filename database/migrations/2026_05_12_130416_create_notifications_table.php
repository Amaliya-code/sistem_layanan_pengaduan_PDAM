<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('notifikasi')) {
            Schema::create('notifikasi', function (Blueprint $table) {
                $table->id('id_notifikasi');
                $table->foreignId('id_pengaduan')
                    ->constrained('pengaduans', 'id_pengaduan')
                    ->onDelete('cascade');
                $table->string('penerima', 100);
                $table->enum('jenis_notifikasi', ['email', 'whatsapp']);
                $table->text('pesan');
                $table->timestamp('tanggal_kirim');
                $table->timestamps();

                $table->index('id_pengaduan');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
?>
