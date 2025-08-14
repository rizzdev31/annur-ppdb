<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Update users table untuk admin
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['super_admin', 'admin', 'operator'])->default('operator')->after('email');
            }
            $table->string('phone')->nullable()->after('email');
            $table->string('avatar')->nullable()->after('phone');
            $table->boolean('is_active')->default(true)->after('avatar');
            $table->timestamp('last_login')->nullable()->after('is_active');
            $table->string('last_login_ip')->nullable()->after('last_login');
        });

        // Create activity logs table
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('user_type'); // 'admin' or 'client'
            $table->unsignedBigInteger('user_id');
            $table->string('action');
            $table->text('description');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->json('properties')->nullable();
            $table->timestamps();
            
            $table->index(['user_type', 'user_id']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'avatar', 'is_active', 'last_login', 'last_login_ip']);
        });
        
        Schema::dropIfExists('activity_logs');
    }
};