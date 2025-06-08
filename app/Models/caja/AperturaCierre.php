<?php

namespace App\Models\caja;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AperturaCierre extends Model
{
    use HasFactory;

    protected $fillable = [
        'est_ape_cierre',
        'fch_apertura',       
        'fch_cierre',
        'monto_inicial',
        'monto_total',
        'usuario_apertura',
        'usuario_cierre',
        'fecha'
    ];
    public $timestamps = false;
    protected $table = 'public.apertura_cierre';
    protected $primaryKey='id';
}
