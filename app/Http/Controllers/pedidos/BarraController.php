<?php

namespace App\Http\Controllers\pedidos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BarraController extends Controller
{
    
    public function index()
    {
        return view('pedidos.barra');
    }

    public function get_barra_1(Request $request){
        

        if($request['barra']==0){
            $data = DB::table('vw_detalle_temp')
                ->where('cocina','=', 'BARRA')               
                ->where('est_detalle','=', 'EN ESPERA')
                ->where('orden','=', 'SI')
                ->whereDate('fechahora_detalle', date('Y-m-d',strtotime($request['fch'])))
                ->orderBy('id_detalle')                
                ->get();
        }elseif($request['barra']==1){
            $data = DB::table('vw_detalle_temp')
                ->where('cocina','=', 'BARRA')                                            
                ->where('est_detalle','=', 'EN ESPERA')
                ->where('orden','=', 'SI')
                ->whereDate('fechahora_detalle', date('Y-m-d',strtotime($request['fch'])))
                ->whereNotBetween('id_mesa', [101, 200])                                                   
                ->orderBy('id_detalle')                
                ->get();
        }elseif($request['barra']==2){
            $data = DB::table('vw_detalle_temp')
                ->where('cocina','=', 'BARRA')                                            
                ->where('est_detalle','=', 'EN ESPERA')
                ->where('orden','=', 'SI')
                ->whereDate('fechahora_detalle', date('Y-m-d',strtotime($request['fch'])))
                ->whereBetween('id_mesa', [101, 150])                                                  
                ->orderBy('id_detalle')                
                ->get();
        }elseif($request['barra']==3){
            $data = DB::table('vw_detalle_temp')
                ->where('cocina','=', 'BARRA')                                            
                ->where('est_detalle','=', 'EN ESPERA')
                ->where('orden','=', 'SI')
                ->whereDate('fechahora_detalle', date('Y-m-d',strtotime($request['fch'])))
                ->whereBetween('id_mesa', [151, 200])                                                   
                ->orderBy('id_detalle')                
                ->get();
        }elseif($request['barra']==4){
            $data = DB::table('vw_detalle_temp')
                ->where('cocina','=', 'BARRA')                                            
                ->where('est_detalle','=', 'EN ESPERA')
                ->where('orden','=', 'SI')
                ->whereDate('fechahora_detalle', date('Y-m-d',strtotime($request['fch'])))
                ->whereBetween('id_mesa', [501, 600])                                                  
                ->orderBy('id_detalle')                
                ->get();
        }
            
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                if(Auth::user()->rol!='MOZO'){
                    return "<button onclick='cambiar_est_barra(".$row->id_detalle.")' type='button' class='btn btn-sm btn-danger waves-effect waves-themed' title='Enviar a preparados'>
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

    public function get_barra_1_2(Request $request){
        
        if($request['barra']==0){
            $data = DB::table('vw_detalle_temp')
                ->where('cocina','=', 'BARRA')
                ->where('est_detalle','=', 'LISTO')
                ->where('orden','=', 'SI')
                ->whereDate('fechahora_detalle', date('Y-m-d',strtotime($request['fch'])))                              
                ->orderByDesc('id_detalle')                
                ->get();
        }elseif($request['barra']==1){
            $data = DB::table('vw_detalle_temp')
                ->where('cocina','=', 'BARRA')
                ->where('est_detalle','=', 'LISTO')
                ->where('orden','=', 'SI')
                ->whereDate('fechahora_detalle', date('Y-m-d',strtotime($request['fch']))) 
                ->whereNotBetween('id_mesa', [101, 200])                             
                ->orderByDesc('id_detalle')                
                ->get();
        }elseif($request['barra']==2){
            $data = DB::table('vw_detalle_temp')
                ->where('cocina','=', 'BARRA')
                ->where('est_detalle','=', 'LISTO')
                ->where('orden','=', 'SI')
                ->whereDate('fechahora_detalle', date('Y-m-d',strtotime($request['fch']))) 
                ->whereBetween('id_mesa', [101, 150])                             
                ->orderByDesc('id_detalle')                
                ->get();
        }elseif($request['barra']==3){
            $data = DB::table('vw_detalle_temp')
                ->where('cocina','=', 'BARRA')
                ->where('est_detalle','=', 'LISTO')
                ->where('orden','=', 'SI')
                ->whereDate('fechahora_detalle', date('Y-m-d',strtotime($request['fch']))) 
                ->whereBetween('id_mesa', [151, 200])                             
                ->orderByDesc('id_detalle')                
                ->get();
        }elseif($request['barra']==4){
            $data = DB::table('vw_detalle_temp')
                ->where('cocina','=', 'BARRA')
                ->where('est_detalle','=', 'LISTO')
                ->where('orden','=', 'SI')
                ->whereDate('fechahora_detalle', date('Y-m-d',strtotime($request['fch']))) 
                ->whereBetween('id_mesa', [501, 600])                             
                ->orderByDesc('id_detalle')                
                ->get();
        }
            
        return DataTables::of($data)
            ->addIndexColumn()                        
            ->addColumn('est_detalle', function($row){
                return "<span class='badge badge-success badge-pill'>".$row->est_detalle."</span>";
            })
            ->addColumn('fechahora_detalle', function($row){
                return (new \DateTime($row->fechahora_detalle))->format("G:ia") . PHP_EOL;
            })
            ->rawColumns(['est_detalle','fechahora_detalle'])              
            ->make(true);
    }


    public function agrupar_barra_1(Request $request){

        if($request['barra']==0){
            $data = DB::select("select '-' as id_detalle, '-'as usuario,'-'as id_mesa,sum(cant) as cant,des_pro,'-' as fechahora_detalle,'-' as est_detalle,'-' as comentario, '-' as action ,id_carta  from vw_detalle_temp where cocina = 'BARRA' and est_detalle = 'EN ESPERA' and fechahora_detalle::date = '".date('Y-m-d',strtotime($request['fch']))."' group by id_carta,des_pro");
        }elseif($request['barra']==1){
            $data = DB::select("select '-' as id_detalle, '-'as usuario,'-'as id_mesa,sum(cant) as cant,des_pro,'-' as fechahora_detalle,'-' as est_detalle,'-' as comentario, '-' as action ,id_carta  from vw_detalle_temp where cocina = 'BARRA' and est_detalle = 'EN ESPERA' and fechahora_detalle::date = '".date('Y-m-d',strtotime($request['fch']))."' and id_mesa not between 101 and 200 group by id_carta,des_pro;");
        }elseif($request['barra']==2){
            $data = DB::select("select '-' as id_detalle, '-'as usuario,'-'as id_mesa,sum(cant) as cant,des_pro,'-' as fechahora_detalle,'-' as est_detalle,'-' as comentario, '-' as action ,id_carta  from vw_detalle_temp where cocina = 'BARRA' and est_detalle = 'EN ESPERA' and fechahora_detalle::date = '".date('Y-m-d',strtotime($request['fch']))."' and id_mesa between 101 and 150 group by id_carta,des_pro;");
        }elseif($request['barra']==3){
            $data = DB::select("select '-' as id_detalle, '-'as usuario,'-'as id_mesa,sum(cant) as cant,des_pro,'-' as fechahora_detalle,'-' as est_detalle,'-' as comentario, '-' as action ,id_carta  from vw_detalle_temp where cocina = 'BARRA' and est_detalle = 'EN ESPERA' and fechahora_detalle::date = '".date('Y-m-d',strtotime($request['fch']))."' and id_mesa between 151 and 200 group by id_carta,des_pro;");
        }elseif($request['barra']==4){
            $data = DB::select("select '-' as id_detalle, '-'as usuario,'-'as id_mesa,sum(cant) as cant,des_pro,'-' as fechahora_detalle,'-' as est_detalle,'-' as comentario, '-' as action ,id_carta  from vw_detalle_temp where cocina = 'BARRA' and est_detalle = 'EN ESPERA' and fechahora_detalle::date = '".date('Y-m-d',strtotime($request['fch']))."' and id_mesa between 201 and 300 group by id_carta,des_pro;");
        }
        
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
        $mesa=$mesass[0]->id_mesa;
        
        $producto = DB::table('almacen.productos')->where('des_pro',$mesass[0]->des_pro)->where('lugar','BARRA')->get();

        if(isset($producto[0]->id)){
            if(($mesa>=1 && $mesa<=100) || ($mesa>=201 && $mesa<=400)){            

                $sql = DB::table('almacen.salidas')->insert([                
                    'id_prod'   => $producto[0]->id,
                    'cant'      => $mesass[0]->cant,
                    'unidad'    => 'Unid.',           
                    'destino'   => 'CONSUMO',
                    'origen'    => 'BARRA_1',
                    'fecha'     => date('Y-m-d H:i'),
                    'mesa'      => $mesa,
                    'id_detalle'=> $mesass[0]->id_detalle
                ]);
                
                return response()->json(['msg'=>'Salida de Producto<br>Origen: Barra_1<br>Cantidad: '.$mesass[0]->cant.'<br>Producto: '.$mesass[0]->des_pro], 200);
                               
            }elseif($mesa>=101 && $mesa<=150){
                $sql = DB::table('almacen.salidas')->insert([                
                    'id_prod'   => $producto[0]->id,
                    'cant'      => $mesass[0]->cant,
                    'unidad'    => 'Unid.',           
                    'destino'   => 'CONSUMO',
                    'origen'    => 'BARRA_2',
                    'fecha'     => date('Y-m-d H:i'),
                    'mesa'      => $mesa,
                    'id_detalle'=> $mesass[0]->id_detalle
                ]);
                
                return response()->json(['msg'=>'Salida de Producto<br>Origen: Barra_2<br>Cantidad: '.$mesass[0]->cant.'<br>Producto: '.$mesass[0]->des_pro], 200);
                  
            }elseif($mesa>=151 && $mesa<=200){
                $sql = DB::table('almacen.salidas')->insert([                
                    'id_prod'   => $producto[0]->id,
                    'cant'      => $mesass[0]->cant,
                    'unidad'    => 'Unid.',           
                    'destino'   => 'CONSUMO',
                    'origen'    => 'BARRA_3',
                    'fecha'     => date('Y-m-d H:i'),
                    'mesa'      => $mesa,
                    'id_detalle'=> $mesass[0]->id_detalle
                ]);
                
                return response()->json(['msg'=>'Salida de Producto<br>Origen: Barra_3<br>Cantidad: '.$mesass[0]->cant.'<br>Producto: '.$mesass[0]->des_pro], 200);
                  
            }
            // elseif($mesa>=201 && $mesa<=300){
            //     $sql = DB::table('almacen.salidas')->insert([                
            //         'id_prod'   => $producto[0]->id,
            //         'cant'      => $mesass[0]->cant,
            //         'unidad'    => 'Unid.',           
            //         'destino'   => 'CONSUMO',
            //         'origen'    => 'BARRA_1',
            //         'fecha'     => date('Y-m-d H:i'),
            //         'mesa'      => $mesa,
            //         'id_detalle'=> $mesass[0]->id_detalle
            //     ]);
                
            //     return response()->json(['msg'=>'Salida de Producto<br>Origen: Barra_4<br>Cantidad: '.$mesass[0]->cant.'<br>Producto: '.$mesass[0]->des_pro], 200);
                  
            // }
        }else{
            if($datos && $hora){
                return response()->json(['msg'=>'Proceso finalizado correctamente.'], 200);
            }else{
                return response()->json(['msg'=>'Error al obtener datos.'], 500);
            }
        }
      
        

        // $b1=array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,301,302,303,304,305,306,307,308,309,310,311,312,313,314,315,316,317,318,319,320,321,322,323,324,325,326,327,328,329,330,331,332,333,334,335,336,337,338,339,340,341,342,343,344,345,346,347,348,349,350,351,352,353,354,355,356,357,358,359,360,361,362,363,364,365,366,367,368,369,370,371,372,373,374,375,376,377,378,379,380,381,382,383,384,385,386,387,388,389,390,391,392,393,394,395,396,397,398,399,400);
        // $b2=array(101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150);
        // $b3=array(151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,166,167,168,169,170,171,172,173,174,175,176,177,178,179,180,181,182,183,184,185,186,187,188,189,190,191,192,193,194,195,196,197,198,199,200);
        // $b4=array(201,202,203,204,205,206,207,208,209,210,211,212,213,214,215,216,217,218,219,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,239,240,241,242,243,244,245,246,247,248,249,250,251,252,253,254,255,256,257,258,259,260,261,262,263,264,265,266,267,268,269,270,271,272,273,274,275,276,277,278,279,280,281,282,283,284,285,286,287,288,289,290,291,292,293,294,295,296,297,298,299,300);
       
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
