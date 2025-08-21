<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FormaPagamento;

class FormaPagamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FormaPagamento::factory()->create(['descricao' => 'Dinheiro']);
        FormaPagamento::factory()->create(['descricao' => 'Cartão de Crédito']);
        FormaPagamento::factory()->create(['descricao' => 'Cartão de Débito']);
        FormaPagamento::factory()->create(['descricao' => 'Pix']);
    }
}
