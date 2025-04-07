<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('produto_materia_prima', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produto_id')->constrained()->onDelete('cascade');
            $table->foreignId('materia_prima_id')->constrained()->onDelete('cascade');
            $table->integer('quantidade')->default(1);
            $table->timestamps();

            // Garante que um produto não terá a mesma matéria prima mais de uma vez
            $table->unique(['produto_id', 'materia_prima_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('produto_materia_prima');
    }
}; 