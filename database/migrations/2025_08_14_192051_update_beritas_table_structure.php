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
        Schema::table('beritas', function (Blueprint $table) {
            // Rename columns if they exist
            if (Schema::hasColumn('beritas', 'konten')) {
                $table->renameColumn('konten', 'content');
            }
            if (Schema::hasColumn('beritas', 'foto')) {
                $table->renameColumn('foto', 'image');
            }
            if (Schema::hasColumn('beritas', 'penulis')) {
                $table->renameColumn('penulis', 'author');
            }
            
            // Add new columns if they don't exist
            if (!Schema::hasColumn('beritas', 'excerpt')) {
                $table->string('excerpt', 255)->nullable()->after('slug');
            }
            if (!Schema::hasColumn('beritas', 'status')) {
                $table->enum('status', ['draft', 'published'])->default('draft')->after('content');
            }
            if (!Schema::hasColumn('beritas', 'kategori')) {
                $table->string('kategori', 50)->nullable()->after('status');
            }
            if (!Schema::hasColumn('beritas', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('kategori');
            }
            if (!Schema::hasColumn('beritas', 'image_alt')) {
                $table->string('image_alt')->nullable()->after('image');
            }
            if (!Schema::hasColumn('beritas', 'meta_description')) {
                $table->string('meta_description', 160)->nullable();
            }
            if (!Schema::hasColumn('beritas', 'keywords')) {
                $table->string('keywords')->nullable();
            }
            if (!Schema::hasColumn('beritas', 'views')) {
                $table->unsignedInteger('views')->default(0);
            }
            
            // Drop is_published if exists (replaced by status)
            if (Schema::hasColumn('beritas', 'is_published')) {
                $table->dropColumn('is_published');
            }
            
            // Add indexes for better performance
            $table->index('status');
            $table->index('kategori');
            $table->index('published_at');
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            // Rename back
            if (Schema::hasColumn('beritas', 'content')) {
                $table->renameColumn('content', 'konten');
            }
            if (Schema::hasColumn('beritas', 'image')) {
                $table->renameColumn('image', 'foto');
            }
            if (Schema::hasColumn('beritas', 'author')) {
                $table->renameColumn('author', 'penulis');
            }
            
            // Drop new columns
            $table->dropColumn(['excerpt', 'status', 'kategori', 'is_featured', 'image_alt', 'meta_description', 'keywords', 'views']);
            
            // Add back is_published
            $table->boolean('is_published')->default(false);
            
            // Drop indexes
            $table->dropIndex(['status']);
            $table->dropIndex(['kategori']);
            $table->dropIndex(['published_at']);
            $table->dropIndex(['is_featured']);
        });
    }
};