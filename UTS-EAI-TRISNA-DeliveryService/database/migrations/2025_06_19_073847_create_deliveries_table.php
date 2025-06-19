<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->unique(); // ID dari order service
            $table->string('nama_pelanggan');
            $table->text('alamat_pengiriman');
            $table->string('kurir'); // Contoh: JNE, J&T, Sicepat
            $table->string('status_pengiriman')->default('Pending'); // Pending, Dikirim, Tiba, Batal
            $table->string('nomor_resi')->nullable(); // Nomor resi dari kurir
            $table->date('estimasi_tiba')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
