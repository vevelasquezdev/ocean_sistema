<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class InCategoriaController extends Controller
{
    public function getInCategoria(){
        $data = DB::table('categoria_ingresos')->latest('id_ingre_cat')->get();
        
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){                    
                return "<button title='Editar' onclick='getDataInCategoria(".$row->id_ingre_cat.")' class='btn btn-primary btn-sm' data-toggle='modal' 
                            data-target='#DldModalIngresoCategoria'><span class='fal fa-pencil'></span> Editar
                        </button>";
            })                   
            ->rawColumns(['action'])              
            ->make(true);
    }

    public function index()
    {
        //
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'desc_ingre_cat' =>'required|regex:/^[\pL\s\-]+$/u|min:5',            
        ]);

        if($request->id_ingre_cat!=''){
            $update = DB::table('categoria_ingresos')->where('id_ingre_cat', $request->id_ingre_cat)->update([
                'desc_ingre_cat' => $request->desc_ingre_cat,
            ]);
            
            if($update){
                return response()->json(['msg'=>'Actualizacion terminada...'], 200);
            }else{
                return response()->json(['msg'=>'Error de base de datos'], 500);
            }
        }else{
            $insert = DB::table('categoria_ingresos')->insert([
                'desc_ingre_cat'    => $request->desc_ingre_cat,
                'fch_ingre_cat'     => date('d-m-Y H:i:s')
            ]);
          
            if($insert){
                return response()->json(['msg'=>'Se agregó nueva categoria de ingreso...'], 200);
            }else{
                return response()->json(['msg'=>'Error de base de datos'], 500);
            }
        }
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $datos = DB::table('categoria_ingresos')->where('id_ingre_cat', $id)->get();
        
        if($datos){
            return response()->json($datos[0]);
        }else{
            return response()->json(['msg'=>'Error al obtener datos'], 500);
        }
    }

    
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
}
