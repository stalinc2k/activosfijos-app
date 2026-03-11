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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('model')->nullable();
            $table->text('serial_number')->nullable();
            $table->float('cost')->nullable();
            $table->enum('status',['enabled','disabled','low'])->default('enabled');
            $table->foreignId('trademark_id')->nullable()->constrained()->cascadeOnUpdate();
            $table->foreignId('type_id')->nullable()->constrained()->cascadeOnUpdate();
            $table->foreignId('category_id')->nullable()->constrained()->cascadeOnUpdate();
            
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
