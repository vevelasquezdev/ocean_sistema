<?php

namespace App\Http\Controllers\caja;

use App\Http\Controllers\Controller;
use App\Models\caja\AperturaCierre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class AperturaCierreController extends Controller
{
   
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('vw_apertura_cierre')                    
                    ->orderByDesc('id_ape_cierre')                
                    ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    if($row->est_ape_cierre=="ABIERTO"){
                        return "<button onclick='OpenModal_cierre_caja(".$row->id_ape_cierre.");' type='button' class='btn btn-danger'>Cerrar Caja</button>"; 
                    }                   
                })                       
                ->addColumn('est_ape_cierre', function($row){
                    if($row->est_ape_cierre=="ABIERTO"){
                        return "<span class='badge badge-success badge-pill'>".$row->est_ape_cierre."</span>";
                    }else{
                        return "<span class='badge badge-danger badge-pill'>".$row->est_ape_cierre."</span>";
                    }                    
                })
                ->addColumn('fch_apertura', function($row){
                    if($row->fch_apertura){
                        return (new \DateTime($row->fch_apertura))->format("j F Y - G:ia") . PHP_EOL;
                    }                   
                })
                ->addColumn('fch_cierre', function($row){
                    if($row->fch_cierre){
                        return (new \DateTime($row->fch_cierre))->format("j F Y - G:ia") . PHP_EOL;
                    }
                })
                ->rawColumns(['action','est_ape_cierre','fch_apertura','fch_cierre'])              
                ->make(true);
        }
        return view('caja.apertura_cierre');
    }

  
    public function create(Request $request)
    {
        
    }

   
    public function store(Request $request)
    {
       

            $find_apertura = DB::table('vw_apertura_cierre')
                                ->where('fecha_eje','=', date('Y-m-d'))                                                
                                ->count();           

            if($find_apertura==1){
                return response()->json([
                    'msg'=>'1',//Apertura de caja denegada.<br>* Intentelo mañana.
                ], 200);

            }else{               
                
                $id_ape_cierre = DB::table('apertura_cierre')->insertGetId([
                    "est_ape_cierre"    => "ABIERTO",
                    "fch_apertura"      => date("Y-m-d H:i:s"),
                    "monto_inicial"     => $request['monto_inicial'] ?? 0,
                    "usuario_apertura"  => Auth::user()->id,
                    "fecha"             => date("Y-m-d H:i:s"),
                ]);
                
                if($id_ape_cierre){

                    $monto = DB::table('vw_apertura_cierre')->where('id_ape_cierre',$id_ape_cierre)->get();

                    $ingreso_apertura_caja = DB::table('movimientos')->insert([ //monto incial apertura de caja
                        'fch_emi'        => date('Y-m-d H:i:s'),
                        'caja'           => 1,
                        'razon_social'   => 'CAJA',
                        'descripcion'    => 'APERTURA DE CAJA',
                        'estado'         => 0,                
                        'monto'          => $monto[0]->monto_inicial,
                        'id_usuario'     => Auth::user()->id,                                   
                        'id_forma_pago'  => 1,
                        'efectivo'       => $monto[0]->monto_inicial
                    ]);                    
                    
                    return response()->json(['msg'=>'Apertura de Caja finalizó correctamente...'], 200);
                }else{
                    return response()->json(['msg'=>'Apertura de Caja falló...'], 500);
                }
            }
        
    }

  
    public function show($id)//get monto total para cierre de caja
    {
        $datos = DB::table("vw_apertura_cierre")->where('id_ape_cierre',$id)->get();
        
        $tot_ingresos = DB::table("vw_movimientos")->where('fecha_eje','=',$datos[0]->fecha_eje)->where('estado_id','=',0)->get()->sum("monto");
        
        
        $total = number_format((float)($tot_ingresos), 2, '.', '');
        if($total){
            return response()->json(['total'=> $total], 200);
        }else{
            return response()->json(['msg'=>'Cierre de Caja falló...'], 500);
        }
    }

    
    public function edit($id_ape_cierre, Request $request)// cierre de caja
    {
       
        $datos = AperturaCierre::where('id',$id_ape_cierre)->update([
            "est_ape_cierre"    => "CERRADO",
            "fch_cierre"      => date("Y-m-d H:i:s"),
            "monto_total"     => $request['monto_total'] ?? 0,
            "usuario_cierre"  => Auth::user()->id,
        ]);        
        
        if($datos){
            $vw_ape_cierre = DB::table("vw_apertura_cierre")->where('id_ape_cierre',$id_ape_cierre)->get();
            DB::select("update movimientos set estado=1 where fch_emi::date='".$vw_ape_cierre[0]->fecha_eje."'");
            
            

            return response()->json(['msg'=>'Cierre de Caja finalizó correctamente...'], 200);
        }else{
            return response()->json(['msg'=>'Cierre de Caja falló...'], 500);
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
