<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    use HasFactory;

    protected $fillable = [
        'materia_prima_id',
        'quantidade',
        'tipo', // entrada ou saída
        'status',
    ];

    public function materiaPrima()
    {
        return $this->belongsTo(MateriaPrima::class);
    }
}
