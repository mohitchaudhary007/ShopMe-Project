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
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'description')) {
                $table->text('description')->nullable()->after('name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Only drop if we actually added the column
            if (Schema::hasColumn('products', 'description') && 
                !Schema::hasColumn('products', 'short_description')) {
                // Only drop if this column was added by this migration
                // (assuming short_description exists in original schema)
                $table->dropColumn('description');
            }
        });
    }
};
