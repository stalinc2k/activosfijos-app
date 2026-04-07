<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('document_items', function (Blueprint $table) {
            $table->id();

            // Relación con documento
            $table->foreignId('document_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();

            // Relación con producto
            $table->foreignId('product_id')
                ->nullable()
                ->constrained()
                ->restrictOnDelete();
            // Relacion con Marca
            $table->foreignId('trademark_id')
                ->nullable()
                ->constrained()
                ->restrictOnDelete();
            //Serie
            $table->string('serie_number')->nullable();
            // Cantidad del movimiento
            $table->integer('quantity')->default(1);

            // Opcionales pero MUY útiles
            $table->decimal('unit_cost', 10, 2)->nullable();

            $table->timestamps();
            $table->softDeletes();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_items');
    }
};
