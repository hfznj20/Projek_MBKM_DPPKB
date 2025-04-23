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
        Schema::table('settings', function (Blueprint $table) {
            // Menambahkan kolom 'logo' untuk menyimpan path gambar
            $table->string('logo')->nullable(); // Kolom logo bertipe string, nullable karena gambar tidak wajib
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Menghapus kolom 'logo' jika migrasi dibatalkan
            $table->dropColumn('logo');
        });
    }
};
