<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class EgCategoriaController extends Controller
{
    public function getEgCategoria(){
        $data = DB::table('categoria_egresos')->latest('id_egre_cat')->get();
        
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){                    
                return "<button title='Editar' onclick='getDataEgresoCategoria(".$row->id_egre_cat.")' class='btn btn-primary btn-sm' data-toggle='modal' 
                            data-target='#DldModalEgresoCategoria'><span class='fal fa-pencil'></span>&nbsp; Editar
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
            'desc_egre_cat' =>'required|regex:/^[\pL\s\-]+$/u|min:5',            
        ]);

        if($request->id_egre_cat!=''){
            $update = DB::table('categoria_egresos')->where('id_egre_cat', $request->id_egre_cat)->update([
                'desc_egre_cat' => $request->desc_egre_cat,
            ]);
            
                     
            if($update){
                return response()->json(['msg'=>'Actualizacion terminada...'], 200);
            }else{
                return response()->json(['msg'=>'Error de base de datos'], 500);
            }
        }else{
            $insert = DB::table('categoria_egresos')->insert([
                'desc_egre_cat'    => $request->desc_egre_cat,
                'fch_egre_cat'     => date('d-m-Y H:i:s')
            ]);
            //$insert = EgresoCategorias::create($request->all());
            if($insert){
                return response()->json(['msg'=>'Se agregó nueva categoria de egreso...'], 200);
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
        $datos = DB::table('categoria_egresos')->where('id_egre_cat', $id)->get();
       
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
