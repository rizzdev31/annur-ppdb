<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            // Tambah jenjang pendidikan
            $table->enum('jenjang', ['SD', 'SMP', 'SMA'])->after('asal_sekolah')->default('SD');
            
            // Tambah field untuk upload dokumen (opsional)
            $table->string('ijazah')->nullable()->after('bukti_pembayaran');
            $table->string('surat_keterangan_lulus')->nullable()->after('ijazah');
            $table->string('akta_kelahiran')->nullable()->after('surat_keterangan_lulus');
            $table->string('kartu_keluarga')->nullable()->after('akta_kelahiran');
            
            // Field untuk tracking user
            $table->boolean('is_credentials_sent')->default(false)->after('status');
            $table->timestamp('credentials_sent_at')->nullable()->after('is_credentials_sent');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropColumn([
                'jenjang',
                'ijazah',
                'surat_keterangan_lulus',
                'akta_kelahiran',
                'kartu_keluarga',
                'is_credentials_sent',
                'credentials_sent_at'
            ]);
        });
    }
};