<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedido_id',
        'produto_id',
        'quantidade',
        'custo_unitario',
        'desconto',
        'valor_total',
        'status',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public function getFormattedCustoUnitarioAttribute()
    {
        return 'R$ ' . number_format($this->custo_unitario, 2, ',', '.');
    }

    public function getFormattedDescontoAttribute()
    {
        return 'R$ ' . number_format($this->desconto, 2, ',', '.');
    }

    public function getFormattedValorTotalAttribute()
    {
        return 'R$ ' . number_format($this->valor_total, 2, ',', '.');
    }
}
