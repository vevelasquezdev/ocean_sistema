<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{    
    use HasFactory;
    protected $fillable = [
        'ruc',
        'raz_soc',
        'created_at',
        'dir',
    ];
    public $timestamps = false;
    protected $table = 'public.clientes';
    protected $primaryKey='id';
}
