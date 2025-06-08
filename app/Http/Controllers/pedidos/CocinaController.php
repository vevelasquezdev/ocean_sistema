<?php

namespace App\Http\Controllers\pedidos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CocinaController extends Controller
{
    
    public function index(Request $request)
    { 
        return view('pedidos.cocina');
    }

    public function get_cocina_1(Request $request){
        
        $data = DB::table('vw_detalle_temp')
                ->where('cocina','=', 'COCINA_1')
                ->where('est_detalle','=', 'EN ESPERA')
                ->where('orden','=', 'SI')
                ->whereDate('fechahora_detalle', date('Y-m-d',strtotime($request['fch'])))                             
                ->orderBy('id_detalle')                
                ->get();
            
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){ 
                if(Auth::user()->rol!='MOZO'){
                    return "<button onclick='cambiar_est_preparado_cocina_1(".$row->id_detalle.")' type='button' class='btn btn-sm btn-danger waves-effect waves-themed' title='Enviar a pedidos listos'>
                            <span class='fal fa-arrow-alt-right'></span>
                            Enviar
                        </button>"; 
                }            
            })                     
            ->addColumn('est_detalle', function($row){
                return "<span class='badge badge-warning badge-pill'>".$row->est_detalle."</span>";
            })
            ->addColumn('fechahora_detalle', function($row){
                return (new \DateTime($row->fechahora_detalle))->format("G:ia") . PHP_EOL;
            })
            ->rawColumns(['action','est_detalle','fechahora_detalle'])              
            ->make(true);
    }

    public function get_cocina_1_2(Request $request){
        $data = DB::table('vw_detalle_temp')
                ->where('cocina','=', 'COCINA_1')
                ->where('est_detalle','=', 'LISTO')
                ->where('orden','=', 'SI')
                ->whereDate('fechahora_detalle', date('Y-m-d',strtotime($request['fch'])))                             
                ->orderByDesc('id_detalle')                
                ->get();
            
        return DataTables::of($data)
            ->addIndexColumn()                       
            ->addColumn('est_detalle', function($row){
                return "<span class='badge badge-success badge-pill'>".$row->est_detalle."</span>";
            })             
            ->addColumn('fechahora_detalle', function($row){
                return (new \DateTime($row->fechahora_detalle))->format("d-m-Y G:ia") . PHP_EOL;
            })
            ->rawColumns(['est_detalle','fechahora_detalle','id_mesa'])              
            ->make(true);
    }

    public function agrupar_cocina_1(Request $request){
        $data = DB::select("select '-' as id_detalle, '-'as usuario,'-'as id_mesa,sum(cant) as cant,des_pro,'-' as fechahora_detalle,'-' as est_detalle,'-' as comentario, '-' as action ,id_carta  from vw_detalle_temp where cocina = 'COCINA_1' and est_detalle = 'EN ESPERA' and fechahora_detalle::date = '".date('Y-m-d',strtotime($request['fch']))."' group by id_carta,des_pro");
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }



    public function get_cocina_2(Request $request){
        $data = DB::table('vw_detalle_temp')
                ->where('cocina','=', 'COCINA_2')
                ->where('est_detalle','=', 'EN ESPERA')
                ->where('orden','=', 'SI')
                ->whereDate('fechahora_detalle', date('Y-m-d',strtotime($request['fch'])))                             
                ->orderBy('id_detalle')                
                ->get();
            
        return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){   
                    if(Auth::user()->rol!='MOZO'){
                        return "<button onclick='cambiar_est_preparado_cocina_2(".$row->id_detalle.")' type='button' class='btn btn-sm btn-danger waves-effect waves-themed' title='Enviar a pedidos listos'>
                                    <span class='fal fa-arrow-alt-right'></span>
                                    Enviar
                                </button>";
                    }             
                })                         
                ->addColumn('est_detalle', function($row){
                    return "<span class='badge badge-warning badge-pill'>".$row->est_detalle."</span>";
                })
                ->addColumn('fechahora_detalle', function($row){
                    return (new \DateTime($row->fechahora_detalle))->format("G:ia") . PHP_EOL;
                })
                ->rawColumns(['action','est_detalle','fechahora_detalle'])              
                ->make(true);
    }

    public function get_cocina_2_2(Request $request){
        $data = DB::table('vw_detalle_temp')
                ->where('cocina','=', 'COCINA_2')
                ->where('est_detalle','=', 'LISTO')
                ->where('orden','=', 'SI')
                ->whereDate('fechahora_detalle', date('Y-m-d',strtotime($request['fch'])))                             
                ->orderBy('id_detalle')                
                ->get();
            
        return DataTables::of($data)
                ->addIndexColumn()                       
                ->addColumn('est_detalle', function($row){
                    return "<span class='badge badge-success badge-pill'>".$row->est_detalle."</span>";
                })               
                ->addColumn('fechahora_detalle', function($row){
                    return (new \DateTime($row->fechahora_detalle))->format("G:ia") . PHP_EOL;
                })
                ->rawColumns(['est_detalle','fechahora_detalle','id_mesa'])              
                ->make(true);
    }

    public function agrupar_cocina_2(Request $request){
        $data = DB::select("select '-' as id_detalle, '-'as usuario,'-'as id_mesa,sum(cant) as cant,des_pro,'-' as fechahora_detalle,'-' as est_detalle,'-' as comentario, '-' as action ,id_carta  from vw_detalle_temp where cocina = 'COCINA_2' and est_detalle = 'EN ESPERA' and fechahora_detalle::date = '".date('Y-m-d',strtotime($request['fch']))."' group by id_carta,des_pro");
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }


    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        //
    }

   
    public function show($id)
    {
        //
    }

    
    public function edit($id_detalle)
    {
        $hora=DB::table('pedido_detalle_temp')->where('id', $id_detalle)->get();

        $horaInicio = new \DateTime($hora[0]->create_at);
        $horaTermino = new \DateTime(date('Y-m-d H:i:s'));
        
        $interval = $horaInicio->diff($horaTermino);
        
        $datos = DB::table('pedido_detalle_temp')->where('id', $id_detalle)
                    ->update([
                        'estado'=> 1,
                        'tiempo'=> $interval->format('%Hh:%imin')
                    ]);

        $mesass=DB::table('vw_detalle_temp')->where('id_detalle',$id_detalle)->get();
        $cocina=$mesass[0]->cocina;
        
        $producto = DB::table('almacen.productos')->where('des_pro',$mesass[0]->des_pro)->where('lugar','COCINA')->get();
        
        if(isset($producto[0]->id)){
            if($cocina=='COCINA_1'){
                $sql = DB::table('almacen.salidas')->insert([                
                    'id_prod'   => $producto[0]->id,
                    'cant'      => $mesass[0]->cant,
                    'unidad'    => 'Unid.',           
                    'destino'   => 'CONSUMO',
                    'origen'    => 'COCINA_1',
                    'fecha'     => date('Y-m-d H:i'),
                    'mesa'      => $mesass[0]->id_mesa,
                    'id_detalle'=> $mesass[0]->id_detalle
                ]);                
                return response()->json(['msg'=>'Salida de Producto<br>Origen: Cocina_1<br>Cantidad: '.$mesass[0]->cant.'<br>Producto: '.$mesass[0]->des_pro], 200);
            }elseif($cocina=='COCINA_2'){
                $sql = DB::table('almacen.salidas')->insert([                
                    'id_prod'   => $producto[0]->id,
                    'cant'      => $mesass[0]->cant,
                    'unidad'    => 'Unid.',           
                    'destino'   => 'CONSUMO',
                    'origen'    => 'COCINA_2',
                    'fecha'     => date('Y-m-d H:i'),
                    'mesa'      => $mesass[0]->id_mesa,
                    'id_detalle'=> $mesass[0]->id_detalle
                ]);                
                return response()->json(['msg'=>'Salida de Producto<br>Origen: Cocina_2<br>Cantidad: '.$mesass[0]->cant.'<br>Producto: '.$mesass[0]->des_pro], 200);
            }
        }else{
            if($datos && $hora){
                return response()->json(['msg'=>'Proceso finalizado correctamente.'], 200);
            }else{
                return response()->json(['msg'=>'Error al obtener datos.'], 500);
            }
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
