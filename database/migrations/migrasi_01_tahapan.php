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
        Schema::create('tahapan_pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->string('icon'); // icon class for font awesome or svg
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert default tahapan pendaftaran
        DB::table('tahapan_pendaftarans')->insert([
            [
                'icon' => 'fa-whatsapp',
                'nama' => 'Hubungi Admin',
                'deskripsi' => 'Hubungi admin melalui WhatsApp untuk mendapatkan token pendaftaran. Token ini diperlukan untuk mengakses formulir pendaftaran online.',
                'urutan' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'icon' => 'fa-edit',
                'nama' => 'Isi Formulir Pendaftaran',
                'deskripsi' => 'Masukkan token yang telah diberikan dan lengkapi formulir pendaftaran online dengan data yang valid dan akurat.',
                'urutan' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'icon' => 'fa-download',
                'nama' => 'Unduh Data Login',
                'deskripsi' => 'Setelah berhasil mendaftar, unduh atau catat informasi login (NISN dan password) yang akan digunakan untuk mengakses dashboard santri.',
                'urutan' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'icon' => 'fa-sign-in-alt',
                'nama' => 'Login Dashboard',
                'deskripsi' => 'Login ke dashboard santri menggunakan NISN dan password untuk memantau status pendaftaran, melengkapi data, dan mengupload dokumen yang diperlukan.',
                'urutan' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahapan_pendaftarans');
    }
};