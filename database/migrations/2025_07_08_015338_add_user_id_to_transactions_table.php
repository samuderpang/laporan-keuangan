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
        Schema::table('transactions', function (Blueprint $table) {
        // Pindahkan ke dalam sini
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('transactions', function (Blueprint $table) {
        // Perintah untuk menghapus foreign key saat rollback
        $table->dropForeign(['user_id']);
        $table->dropColumn('user_id');
    });
    }
};
