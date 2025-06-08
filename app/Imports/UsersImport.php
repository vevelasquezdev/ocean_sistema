<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;

class UsersImport implements ToModel
{
   
    public function model(array $row)
    {
        return new User([
            'name'     => $row[0],
            'surname'    => $row[1],
            'email'    => $row[2],
            'rol'    => $row[3],
            'password' => Hash::make($row[4]),
            'active' => $row[5],
         ]);
    }
}
