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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->date('date');
             $table->foreignId('created_by')
                ->nullable()
                ->constrained('users');
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users');
            $table->foreignId('deleted_by')
                ->nullable()
                ->constrained('users');
             $table->foreignId('delivered_to')
                ->nullable()
                ->constrained('employees');
            $table->foreignId('returned_by')
                ->nullable()
                ->constrained('employees');
            $table->enum('type',['Entrada','Entrega','Devolucion','Baja'])->default('Entrada');
            $table->text('Observation')->nullable();
            $table->softDeletes();    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
