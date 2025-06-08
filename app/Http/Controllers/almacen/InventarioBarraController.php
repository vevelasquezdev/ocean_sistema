<?php

namespace App\Http\Controllers\almacen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class InventarioBarraController extends Controller
{

    public function check_recarga_inventarios(){
        $count_barra= DB::table('almacen.principal_barra')->whereDate('fecha', date('Y-m-d'))->count('id_prod');
        $count_cocina= DB::table('almacen.principal_cocina')->whereDate('fecha', date('Y-m-d'))->count('id_prod');
        if($count_barra==0){
            return response()->json(['msg'=>'0'], 200);
        }elseif($count_cocina==0){
            return response()->json(['msg'=>'0'], 200);
        }else{
            return response()->json(['msg'=>'1'], 200);
        }
    }

    public function vw_principal_barra(){
        return view('almacen.principal_barra');
    }

    public function principal_barra(Request $request){
       
        $data = DB::table('almacen.vw_principal_barra')
        ->whereDate('fecha_eje',date("d-m-Y",strtotime($request['fch'])))                  
                ->orderByDesc('id')                
                ->get();
        //echo date('d-m-Y',strtotime($request['fch']));
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }



    public function vw_barra_uno(){
        return view('almacen.barra_uno');
    }

    public function barra_uno(Request $request){
        // $fecha = date("Y-m-d",strtotime($request['fch']."+ 1 days"));
        // $data = DB::table('almacen.barra_uno')
        //         ->whereDate('fecha_eje', $fecha)                  
        //         ->orderByDesc('id')                
        //         ->get();

        $data = DB::table('almacen.vw_barra_uno')
                ->whereDate('fecha_eje',date("d-m-Y",strtotime($request['fch'])))                  
                ->orderByDesc('id')                
                ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }


    public function vw_barra_dos(){
        return view('almacen.barra_dos');
    }

    public function barra_dos(Request $request){
       
        $data = DB::table('almacen.vw_barra_dos')
                ->whereDate('fecha_eje',date("d-m-Y",strtotime($request['fch'])))                 
                ->orderByDesc('id')                
                ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }



    public function vw_barra_tres(){
        return view('almacen.barra_tres');
    }

    public function barra_tres(Request $request){
       
        $data = DB::table('almacen.vw_barra_tres')
                ->whereDate('fecha_eje',date("d-m-Y",strtotime($request['fch'])))                   
                ->orderByDesc('id')                
                ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }


    public function vw_barra_cuatro(){
        return view('almacen.barra_cuatro');
    }

    public function barra_cuatro(Request $request){
       
        $data = DB::table('almacen.vw_barra_cuatro')
                ->whereDate('fecha_eje',date("d-m-Y",strtotime($request['fch'])))                  
                ->orderByDesc('id')                
                ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }



    /**COCINA */
    public function vw_principal_cocina(){
        return view('almacen.principal_cocina');
    }
    public function principal_cocina(Request $request){
       
        $data = DB::table('almacen.vw_principal_cocina')
                ->whereDate('fecha_eje',date("d-m-Y",strtotime($request['fch'])))                   
                ->orderByDesc('id')                
                ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }


    public function vw_cocina_uno(){
        return view('almacen.cocina_uno');
    }
    public function cocina_uno(Request $request){
       
        $data = DB::table('almacen.vw_cocina_uno')
                ->whereDate('fecha_eje',date("d-m-Y",strtotime($request['fch'])))                  
                ->orderByDesc('id')                
                ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }


    public function vw_cocina_dos(){
        return view('almacen.cocina_dos');
    }
    public function cocina_dos(Request $request){
       
        $data = DB::table('almacen.vw_cocina_dos')
                ->whereDate('fecha_eje',date("d-m-Y",strtotime($request['fch'])))                   
                ->orderByDesc('id')                
                ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
