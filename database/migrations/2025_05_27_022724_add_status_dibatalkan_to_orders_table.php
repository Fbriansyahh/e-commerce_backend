<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', [
                'Menunggu Pembayaran',
                'Diproses',
                'Dikirim',
                'Diterima',
                'Dibatalkan'
            ])->default('Menunggu Pembayaran')->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Kembalikan ke enum sebelumnya (tanpa 'Dibatalkan')
            $table->enum('status', [
                'Menunggu Pembayaran',
                'Diproses',
                'Dikirim',
                'Diterima'
            ])->default('Menunggu Pembayaran')->change();
        });
    }
};
