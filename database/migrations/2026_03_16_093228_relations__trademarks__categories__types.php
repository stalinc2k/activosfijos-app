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
         Schema::table('types', function (Blueprint $table) {
            $table->foreignId('category_id')
                ->nullable()
                ->constrained()->cascadeOnUpdate();
         });

         Schema::table('categories', function (Blueprint $table) {
            $table->foreignId('trademark_id')
                ->nullable()
                ->constrained()->cascadeOnUpdate();
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
