<?php

namespace App\Models\admin;

use Database\Factories\CartaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carta extends Model
{
    
    use HasFactory;
    
    protected $fillable = [
        'tip_pro',
        'des_pro',       
        'pre_pro',
        'cocina'
    ];
    public $timestamps = false;
    protected $table = 'public.carta';
    protected $primaryKey='id';

    protected static function newFactory()
    {
        return CartaFactory::new();
    }

}


