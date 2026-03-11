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
        Schema::table('departments', function (Blueprint $table) {
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users');
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users');
            $table->foreignId('deleted_by')
                ->nullable()
                ->constrained('users');
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users');
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users');
            $table->foreignId('deleted_by')
                ->nullable()
                ->constrained('users');
            $table->foreignId('department_id')->nullable()->constrained()->cascadeOnUpdate();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users');
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users');
            $table->foreignId('deleted_by')
                ->nullable()
                ->constrained('users');
            $table->foreignId('department_id')->nullable()->constrained()->cascadeOnUpdate();
            $table->foreignId('appointment_id')->nullable()->constrained()->cascadeOnUpdate();
        });

        Schema::table('types', function (Blueprint $table) {
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users');
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users');
            $table->foreignId('deleted_by')
                ->nullable()
                ->constrained('users');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users');
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users');
            $table->foreignId('deleted_by')
                ->nullable()
                ->constrained('users');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users');
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users');
            $table->foreignId('deleted_by')
                ->nullable()
                ->constrained('users');

            $table->foreignId('trademark_id')->nullable()->constrained()->cascadeOnUpdate();
            $table->foreignId('type_id')->nullable()->constrained()->cascadeOnUpdate();
            $table->foreignId('category_id')->nullable()->constrained()->cascadeOnUpdate();
        });

        Schema::table('trademarks', function (Blueprint $table) {
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users');
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users');
            $table->foreignId('deleted_by')
                ->nullable()
                ->constrained('users');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
