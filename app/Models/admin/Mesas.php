<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesas extends Model
{
    use HasFactory;
    protected $fillable = [
        'estado',
        'zona',
        'id_pedido',
        'id_user',
        'posicion',
    ];
    public $timestamps = false;
    protected $table = 'mesas';
    protected $primaryKey='id';
}
