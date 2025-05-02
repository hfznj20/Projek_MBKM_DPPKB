<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('_t_p_k', function (Blueprint $table) {
            $table->string('role')->default('user'); // default role adalah user
        });
    }

    public function down(): void
    {
        Schema::table('_t_p_k', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};