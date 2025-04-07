<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lancamento extends Model
{
    protected $fillable = ['descricao', 'cliente_id', 'pedido_id', 'tipo', 'data', 'status', 'valor', 'status_pagamento'];
}
