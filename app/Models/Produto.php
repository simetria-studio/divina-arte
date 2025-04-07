<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'preco_custo',
        'preco_venda',
        'margem',
        'horas_trabalho',
        'status',
    ];

    /**
     * Formata o valor para exibição em Reais
     */
    public function getFormattedPrecoCustoAttribute()
    {
        return 'R$ ' . number_format($this->preco_custo, 2, ',', '.');
    }

    public function getFormattedPrecoVendaAttribute()
    {
        return 'R$ ' . number_format($this->preco_venda, 2, ',', '.');
    }

    public function getFormattedMargemAttribute()
    {
        return number_format($this->margem, 2, ',', '.') . '%';
    }

    /**
     * Relacionamento com matérias primas
     */
    public function materiasPrimas()
    {
        return $this->belongsToMany(MateriaPrima::class, 'produto_materia_prima')
                    ->withPivot('quantidade')
                    ->withTimestamps();
    }
}
