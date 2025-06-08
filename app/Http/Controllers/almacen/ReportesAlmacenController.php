<?php

namespace App\Http\Controllers\almacen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class ReportesAlmacenController extends Controller
{
    
    public function vw_totales_barra(){
        return view('almacen.rep_totales_barra');
    }

    public function totales_barra(Request $request){       
        $fecha = date("Y-m-d",strtotime($request['fch']));
        $data = DB::select('SELECT * from almacen.fn_totales_barra(?);', [$fecha]);
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }


    public function vw_totales_cocina(){
        return view('almacen.rep_totales_cocina');
    }

    public function totales_cocina(Request $request){
        //$fecha = date("Y-m-d",strtotime($request['fch']."+ 1 days"));
        $fecha = date("Y-m-d",strtotime($request['fch']));
        $data = DB::select('SELECT * from almacen.fn_totales_cocina(?);', [$fecha]);

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
