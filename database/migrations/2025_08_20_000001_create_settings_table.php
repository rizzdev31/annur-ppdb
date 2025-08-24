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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text'); // text, boolean, number, json
            $table->string('group')->default('general'); // general, ppdb, email, etc
            $table->string('description')->nullable();
            $table->boolean('is_public')->default(false);
            $table->timestamps();
        });

        // Insert default settings
        DB::table('settings')->insert([
            [
                'key' => 'site_name',
                'value' => 'PPDB MUBOSTA',
                'type' => 'text',
                'group' => 'general',
                'description' => 'Nama website',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'site_email', 
                'value' => 'admin@ppdb.com',
                'type' => 'email',
                'group' => 'general',
                'description' => 'Email website',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'site_phone',
                'value' => '(031) 123456',
                'type' => 'text',
                'group' => 'general',
                'description' => 'Nomor telepon',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'site_address',
                'value' => 'Jl. Contoh No. 123, Sidoarjo',
                'type' => 'text',
                'group' => 'general',
                'description' => 'Alamat',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'registration_open',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'ppdb',
                'description' => 'Status pendaftaran PPDB',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'maintenance_mode',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'system',
                'description' => 'Mode maintenance',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'max_upload_size',
                'value' => '2048',
                'type' => 'number',
                'group' => 'upload',
                'description' => 'Maksimal ukuran upload (KB)',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'allowed_file_types',
                'value' => 'jpg,jpeg,png,pdf',
                'type' => 'text',
                'group' => 'upload',
                'description' => 'Tipe file yang diizinkan',
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
        Schema::dropIfExists('settings');
    }
};