<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->string('token');
            $table->string('nisn')->unique();
            $table->string('nama_lengkap');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->integer('anak_ke');
            $table->integer('jumlah_saudara');
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->string('pekerjaan_ayah');
            $table->string('pekerjaan_ibu');
            $table->string('pendidikan_ayah');
            $table->string('pendidikan_ibu');
            $table->string('provinsi');
            $table->string('kota');
            $table->string('kecamatan');
            $table->text('alamat_lengkap');
            $table->string('asal_sekolah');
            $table->string('no_whatsapp');
            $table->string('bukti_pembayaran');
            $table->string('password');
            $table->enum('status', ['pending', 'seleksi', 'diterima', 'ditolak'])->default('pending');
            $table->foreignId('gelombang_id')->constrained()->onDelete('cascade');
            $table->foreignId('tahun_ajaran_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};