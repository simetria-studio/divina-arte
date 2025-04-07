<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriaPrima extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'custo_total',
        'custo_unitario',
        'quantidade',
        'rendimento',
        'utilizacao',
        'custo_utilizado',
        'estoque_minimo',
        'estoque_maximo',
        'estoque_atual',
        'status',
    ];

    /**
     * Formata o valor para exibição em Reais
     */
    public function getFormattedCustoTotalAttribute()
    {
        return 'R$ ' . number_format($this->custo_total, 2, ',', '.');
    }

    public function getFormattedCustoUnitarioAttribute()
    {
        return 'R$ ' . number_format($this->custo_unitario, 2, ',', '.');
    }

    public function getFormattedCustoUtilizadoAttribute()
    {
        return 'R$ ' . number_format($this->custo_utilizado, 2, ',', '.');
    }

    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'produto_materia_prima')
                    ->withPivot('quantidade')
                    ->withTimestamps();
    }
}
