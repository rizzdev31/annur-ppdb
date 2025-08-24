<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update existing NULL values to empty string
        DB::table('pendaftarans')
            ->whereNull('bukti_pembayaran')
            ->update(['bukti_pembayaran' => '']);
            
        Schema::table('pendaftarans', function (Blueprint $table) {
            // Make bukti_pembayaran nullable
            $table->string('bukti_pembayaran')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->string('bukti_pembayaran')->nullable(false)->change();
        });
    }
};