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
        Schema::create('venda_pagamento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venda_id');
            $table->integer('forma_pagamento_id_primaria');
            $table->string('valor_venda_primaria');
            $table->integer('pagamentoDividido')->nullable();
            $table->integer('forma_pagamento_id_secundaria')->nullable();
            $table->string('valor_venda_secundaria')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venda_pagamento');
    }
};
