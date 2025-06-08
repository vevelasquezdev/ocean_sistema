<?php

namespace App\Imports;


use App\Models\funciones\Llamadas;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LLamadasImport implements ToModel, WithHeadingRow
{
    
    public function model(array $row)
    {
        return new Llamadas([
            'nom_com'  => strtoupper($row['nom_com']),
            'celular'  => str_replace("p:", "", $row['celular']),
            'ciudad'   => $row['ciudad'],
            'email'    => $row['email'],
            'user_id'  => Auth::user()->id,
            'estado'   => 5
        ]);
    }
    
}
