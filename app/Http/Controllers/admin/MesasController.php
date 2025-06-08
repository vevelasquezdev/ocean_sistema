<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Mesas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class MesasController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('vw_mesas')->orderBy('id');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){                    
                    // return "
                    // <button onclick='getdata(".$row->id.")' class='btn btn-primary btn-sm' data-toggle='modal' 
                    //     data-target='.default-example-modal-right'>Editar
                    // </button>&nbsp;|
                    // <button onclick='del(".$row->id.")' class='btn btn-danger btn-sm'>Eliminar</button>                                         
                    // ";                     
                })
                ->addColumn('desc_estado', function($row){
                    if($row->desc_estado == 'LIBRE'){
                        return "<span class='badge badge-success badge-pill'>".$row->desc_estado."</span>";
                    }else{
                        return "<span class='badge badge-danger badge-pill'>".$row->desc_estado."</span>";
                    }                    
                })
                ->rawColumns(['action','desc_estado'])              
                ->make(true);
        }
        
        return view('admin.mesas');
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        if($request->id!=''){ ///Actualizar
            
            request()->validate([
                'zona' => 'required',        
                'posicion' => 'required',                
            ]);

            $sql = Mesas::find($request->id)->update($request->all());
            if($sql){
                return response()->json(['msg'=>'Actualizacion terminada...'], 200);
            }else{
                return response()->json(['msg'=>'Error...'], 500);
            }
        

        }else{/////CREAR NUEVO 
            
            request()->validate([
                'zona' => 'required',        
                'posicion' => 'required',                
            ]);           
                      
            Mesas::create($request->all());
            return response()->json(['msg'=>'Nuevo producto agregado...'], 200);
        }
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        try{
            $datos = Mesas::find($id);
        }catch(\Exception $exception){
            return view('errors.404');
        }
        
        if($datos){
            return response()->json($datos);
        }else{
            return response()->json(['msg'=>'Error al obtener datos'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
