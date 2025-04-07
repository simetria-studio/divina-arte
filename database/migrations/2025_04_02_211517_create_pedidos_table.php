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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->integer('cliente_id')->nullable();
            $table->integer('item_id')->nullable();
            $table->integer('quantidade')->nullable();
            $table->date('data_entrega')->nullable();
            $table->decimal('custo_total', 8, 2)->nullable();
            $table->decimal('valor_total', 8, 2)->nullable();
            $table->decimal('lucro', 8, 2)->nullable();
            $table->decimal('lucro_percentual', 8, 2)->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
