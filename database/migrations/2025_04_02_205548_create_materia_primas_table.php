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
        Schema::create('materia_primas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->decimal('custo_total', 8, 2);
            $table->integer('custo_unitario');
            $table->integer('quantidade');
            $table->integer('rendimento');
            $table->double('utilizacao');
            $table->decimal('custo_utilizado', 8, 2);
            $table->integer('estoque_minimo')->nullable();
            $table->integer('estoque_maximo')->nullable();
            $table->integer('estoque_atual')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materia_primas');
    }
};
