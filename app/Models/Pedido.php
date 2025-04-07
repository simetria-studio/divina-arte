<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'data_entrega',
        'custo_total',
        'valor_total',
        'lucro',
        'lucro_percentual',
        'status',
    ];

    protected $casts = [
        'data_entrega' => 'datetime',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function itens()
    {
        return $this->hasMany(Item::class);
    }

    public function getFormattedCustoTotalAttribute()
    {
        return 'R$ ' . number_format($this->custo_total, 2, ',', '.');
    }

    public function getFormattedValorTotalAttribute()
    {
        return 'R$ ' . number_format($this->valor_total, 2, ',', '.');
    }

    public function getFormattedLucroAttribute()
    {
        return 'R$ ' . number_format($this->lucro, 2, ',', '.');
    }

    public function getFormattedLucroPercentualAttribute()
    {
        return number_format($this->lucro_percentual, 2, ',', '.') . '%';
    }

    public function recalcularTotais()
    {
        $this->custo_total = $this->itens->sum(function($item) {
            return $item->quantidade * $item->custo_unitario;
        });

        $this->valor_total = $this->itens->sum(function($item) {
            return $item->valor_total;
        });

        $this->lucro = $this->valor_total - $this->custo_total;
        
        if ($this->custo_total > 0) {
            $this->lucro_percentual = ($this->lucro / $this->custo_total) * 100;
        } else {
            $this->lucro_percentual = 0;
        }

        $this->save();
    }
}
