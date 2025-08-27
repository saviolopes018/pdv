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
        Schema::create('venda', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produto_id');
            $table->foreignId('venda_pagamento_id');
            $table->integer('quantidade');
            $table->string('valorUnidade');
            $table->string('valorTotal');
            $table->date('dataVenda');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venda');
    }
};
