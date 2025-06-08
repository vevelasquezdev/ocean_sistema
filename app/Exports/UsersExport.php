<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class UsersExport implements FromCollection, WithHeadings
{
    
    public function collection()
    {
        return User::select('id', 'name', 'surname', 'email')->orderBy('id','ASC')->get();
        
        /* $export = User::all();
        $export->makeHidden(['profile_photo_path','created_at', 'updated_at']);
        return $export; */
    }
    public function headings(): array
    {
        return [
            'ID',
            'NOMBRES',
            'APELLIDOS',
            'EMAIL',
            'FOTO LINK'
        ];
    }
}
