<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if column doesn't exist before adding
        if (!Schema::hasColumn('beritas', 'is_highlighted')) {
            Schema::table('beritas', function (Blueprint $table) {
                $table->boolean('is_highlighted')->default(false)->after('is_featured');
                $table->index('is_highlighted');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('beritas', 'is_highlighted')) {
            Schema::table('beritas', function (Blueprint $table) {
                $table->dropColumn('is_highlighted');
            });
        }
    }
};