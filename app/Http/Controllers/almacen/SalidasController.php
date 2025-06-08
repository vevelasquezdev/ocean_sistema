<?php

namespace App\Http\Controllers\almacen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class SalidasController extends Controller
{
    
    public function index(Request $request)
    {       
        return view('almacen.salidas');
    }

    public function get_tabla_alm_salidas(Request $request){
        $data = DB::table('almacen.vw_salidas')
                    ->whereDate('fecha_eje', date('Y-m-d',strtotime($request['fch'])))                    
                    ->orderByDesc('id')                
                    ->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                
                    if($row->fecha_eje==date('Y-m-d') && $row->mesa==''){
                        return "<button title='Eliminar salida' onclick='del(".$row->id.")' class='btn btn-sm btn-danger'>
                                    <span class='fa fa-window-close'></span>
                                </button>";
                    }
                    
                    // return "<button title='Editar salida' onclick='getdata(".$row->id.")' class='btn btn-primary btn-sm' data-toggle='modal' 
                    //             data-target='#DldModalSalidas'><span class='fal fa-pencil'></span>
                    //         </button>&nbsp;|                            
                    //         <button title='Eliminar salida' onclick='del(".$row->id.")' class='btn btn-sm btn-danger'>
                    //             <span class='fa fa-window-close'></span>
                    //         </button>";         
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
                'stock'     => 'required',
            ],[
                'id_prod.required' => 'El producto es obligatorio.',
                'cant.required' => 'Cantidad es obligatorio.', 
                'cant.min' => 'Cantidad debe ser mayor a 0',             
            ]);
            
            $sql = DB::table('almacen.salidas')->where('id',$request->id)->update([                
                'id_prod'   => $request['id_prod'],
                'cant'      => $request['cant'],
                'unidad'    => $request['unidad'],          
                'destino'   => $request['destino'],
                'origen'    => $request['origen'],
                'fecha'     => date('Y-m-d H:i',strtotime($request['fecha'])),
                'comentario'    => $request['comentario'],
            ]);
            
            if($sql){
                return response()->json(['msg'=>'Actualizacion terminada...'], 200);
            }else{
                return response()->json(['msg'=>'Error...'], 500);
            }
        

        }else{/////CREAR NUEVO 
            
            request()->validate([
                'id_prod'   => 'required',   
                'cant'      => 'required|integer|min:1|lte:stock',
                'unidad'    => 'required',
                'destino'   => 'required',
                'origen'    => 'required',
                'fecha'     => 'required',
                'stock'     => 'required|integer|min:1'                
            ],[
                'id_prod.required' => 'El producto es obligatorio.',
                'cant.required' => 'Cantidad es obligatorio.', 
                'cant.min' => 'Cantidad debe ser mayor a 0', 
                'cant.lte' => 'La cantidad debe ser menor o igual al stock.',          
            ]);
                      
            $sql = DB::table('almacen.salidas')->insertGetId([                
                'id_prod'   => $request['id_prod'],
                'cant'      => $request['cant'],
                'unidad'    => $request['unidad'],           
                'destino'   => $request['destino'],
                'origen'    => $request['origen'],
                'fecha'     => date('Y-m-d H:i',strtotime($request['fecha'])),
                'comentario'    => $request['comentario'],
            ]);
            
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
        $datos = DB::table('almacen.vw_salidas')->where('id',$id)->get();
      
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
        $elim = DB::table('almacen.salidas')->where('id',$id)->delete();
      
        if($elim){
            return response()->json([ 'msg' => 'Registro eliminado...!'],200);
        }else{
            return response()->json(['msg'=>'Error al eliminar Registro...!'], 500);
        }
    }
}
