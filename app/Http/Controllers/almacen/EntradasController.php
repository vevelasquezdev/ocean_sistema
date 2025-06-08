<?php

namespace App\Http\Controllers\almacen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class EntradasController extends Controller
{
   
    public function index(Request $request){        
        return view('almacen.entradas');
    }

    public function get_tabla_alm_entradas(Request $request){
        $data = DB::table('almacen.vw_entradas')
                    ->whereDate('fecha_eje', date('Y-m-d',strtotime($request['fch'])))                  
                    ->orderByDesc('id')                
                    ->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            if($row->origen=='COMPRA' and $row->fecha_eje==date('Y-m-d')){
                return "<button title='Eliminar entrada' onclick='del(".$row->id.")' class='btn btn-sm btn-danger'>
                            <span class='fa fa-window-close'></span>
                        </button>";
            //         return "<button title='Editar entrada' onclick='getdata(".$row->id.")' class='btn btn-primary btn-sm' data-toggle='modal' 
            //             data-target='#DldModalEntradas'><span class='fal fa-pencil'></span>
            //         </button>&nbsp;|                            
            //         <button title='Eliminar entrada' onclick='del(".$row->id.")' class='btn btn-sm btn-danger'>
            //             <span class='fa fa-window-close'></span>
            //         </button>";
            // }
            }       
        })
        ->addColumn('fecha', function($row){                    
            return (new \DateTime($row->fecha))->format("j F Y - G:ia") . PHP_EOL;                                    
        })               
        ->rawColumns(['action','fecha'])              
        ->make(true);
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        if($request->id!=''){ ///Actualizar
            
            request()->validate([
                'id_prod'   => 'required',   
                'cant'      => 'required|integer|min:1',
                'unidad'    => 'required',            
                'destino'   => 'required',
                'origen'    => 'required',
                'fecha'     => 'required',
            ],[
                'id_prod.required' => 'El producto es obligatorio.',
                'cant.required' => 'Cantidad es obligatorio.', 
                'cant.min' => 'Cantidad debe ser mayor a 0',
            ]);
            
            $sql = DB::table('almacen.entradas')->where('id',$request->id)->update([                
                'id_prod'   => $request['id_prod'],
                'cant'      => $request['cant'],
                'unidad'    => $request['unidad'],          
                'destino'   => $request['destino'],
                'origen'    => $request['origen'],
                'fecha'     => date('Y-m-d H:i',strtotime($request['fecha'])),
            ]);
            
            if($sql){
                return response()->json(['msg'=>'Actualizacion terminada...'], 200);
            }else{
                return response()->json(['msg'=>'Error...'], 500);
            }
        

        }else{/////CREAR NUEVO 
            
            request()->validate([
                'id_prod'   => 'required',   
                'cant'      => 'required|integer|min:1',
                'unidad'    => 'required',            
                'destino'   => 'required',
                'origen'    => 'required',
                'fecha'     => 'required',
            ],[
                'id_prod.required' => 'El producto es obligatorio.',
                'cant.required' => 'Cantidad es obligatorio.',  
                'cant.min' => 'Cantidad debe ser mayor a 0',                            
            ]);
                      
            $sql = DB::table('almacen.entradas')->insertGetId([                
                'id_prod'   => $request['id_prod'],
                'cant'      => $request['cant'],
                'unidad'    => $request['unidad'],           
                'destino'   => $request['destino'],
                'origen'    => $request['origen'],
                'fecha'     => date('Y-m-d H:i',strtotime($request['fecha'])),
            ]);
            
            //$sql=DB::select("insert into almacen.entradas (id_prod, unidad, cant, destino, origen, fecha) values (".$request['id_prod'].",'".$request['unidad']."',".$request['cant'].",'".$request['destino']."','".$request['origen']."','".date('Y-m-d H:i',strtotime($request['fecha']))."');");
            
            if($sql){
                return response()->json(['msg'=>'Nuevo registro ingresado...'], 200);
            }else{
                return response()->json(['msg'=>'Error interno'], 500);
            }
        }
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $datos = DB::table('almacen.vw_entradas')->where('id',$id)->get();
      
        if($datos){
            return response()->json($datos,200);
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
        $elim = DB::table('almacen.entradas')->where('id',$id)->delete();
        if($elim){
            return response()->json([ 'msg' => 'Registro eliminado...!'],200);
        }else{
            return response()->json(['msg'=>'Error al eliminar Registro...!'], 500);
        }

        //$dest = DB::table('almacen.entradas')->where('id',$id)->get();
        
        // if($dest[0]->destino=='PRINCIPAL_BARRA'){
        //     $salidas = DB::table('almacen.vw_principal_barra')->where('id_prod',$dest[0]->id_prod)
        //                     ->whereDate('fecha_eje', date('Y-m-d'))
        //                     ->get();
            
        //     if($salidas[0]->salidas==0){
        //         $elim = DB::table('almacen.entradas')->where('id',$id)->delete();
        //         return response()->json([ 'msg' => 'Registro eliminado...!'],200);
        //     }else{
        //         return response()->json(['msg'=>'La entrada no puede eliminarse porque presenta salidas registradas hacia otras barras.'], 500);
        //     }

        // }elseif($dest[0]->destino=='PRINCIPAL_COCINA'){
        //     $salidas = DB::table('almacen.vw_principal_cocina')->where('id_prod',$dest[0]->id_prod)
        //                     ->whereDate('fecha_eje', date('Y-m-d'))
        //                     ->get();

        //     if($salidas[0]->salidas==0){
        //         $elim = DB::table('almacen.entradas')->where('id',$id)->delete();
        //         return response()->json([ 'msg' => 'Registro eliminado...!'],200);
        //     }else{
        //         return response()->json(['msg'=>'La entrada no puede eliminarse porque presenta salidas registradas hacia otras cocinas.'], 500);
        //     }
        // }
        
    }
}
