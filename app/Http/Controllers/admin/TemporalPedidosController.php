<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Else_;

class TemporalPedidosController extends Controller
{
    
    public function index(Request $request)
    {
       
    }

    
    public function create(Request $request)
    {
        if($request['tipo']=='DESCUENTO'){
            $id_carta_dcsto = DB::table('carta')->where('des_pro','DESCUENTO')->get();
            $dscto=$request['descuento'];
            if($dscto>0){
                $dscto=$dscto*-1;
            }
           
            $sql = DB::table('pedido_detalle_temp')->insert([
                'cant'          => $request['cant'],
                'create_at'     => date('Y-m-d H:i:s'),                
                'id_pro'        => $id_carta_dcsto[0]->id,
                'id_pedidos'    => $request['id_pedido_temp'],
                'orden'         => "NO",
                'precio_his'    => $dscto
            ]);
        }elseif($request['tipo']=='MISELANEO'){
            $id_carta_dcsto = DB::table('carta')->where('des_pro','MISELANEO')->get();
            $miselaneo=$request['miselaneo'];
            $sql = DB::table('pedido_detalle_temp')->insert([
                'cant'          => $request['cant'],
                'create_at'     => date('Y-m-d H:i:s'),                
                'id_pro'        => $id_carta_dcsto[0]->id,
                'id_pedidos'    => $request['id_pedido_temp'],
                'orden'         => "NO",
                'precio_his'    => $miselaneo
            ]);
        }else{
            $precio = DB::table('carta')->select('pre_pro')->where('id',$request['id_carta'])->get();
            $sql = DB::table('pedido_detalle_temp')->insert([
                'cant'          => $request['cant'],
                'create_at'     => date('Y-m-d H:i:s'),                
                'id_pro'        => $request['id_carta'],
                'id_pedidos'    => $request['id_pedido_temp'],
                'orden'         => "NO",
                'precio_his'    => $precio[0]->pre_pro
            ]);
        }

        if($sql){
            return response()->json(['msg'=>'Producto agregado...'], 200);
        }else{
            return response()->json(['msg'=>'Error de base de datos'], 500);
        }
       
    }

    public function get_ittems_table_temp(Request $request){
            
        $data = DB::table('vw_detalle_temp')
            ->where('id_mesa','=', $request['id_mesa'])            
            ->where('id','=',$request['id_pedido_temp'])
            ->orderBy('id_detalle')
            ->get();
      
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                if(Auth::user()->rol=="ENCARGADO" || Auth::user()->rol=="ADMINISTRADOR"){
                    return "<a onclick='del_ittem(".$row->id_detalle.")' href='javascript:void(0);' title='Eliminar' class='btn btn-danger btn-sm btn-icon waves-effect waves-themed'>
                                <i class='fal fa-trash'></i>
                            </a>";
                }else{
                    if($row->orden=="NO"){
                        return "<a onclick='del_ittem(".$row->id_detalle.")' href='javascript:void(0);' title='Eliminar' class='btn btn-danger btn-sm btn-icon waves-effect waves-themed'>
                                <i class='fal fa-trash'></i>
                            </a>";
                    }else{
                        
                    }
                }                    
            })
            ->addColumn('comentario', function($row){
                if($row->comentario){
                    return $this->limitar_cadena($row->comentario, 30, "...");
                }else{
                    return "<a onclick='add_comentario(".$row->id_detalle.")' href='javascript:void(0);' title='Agregar comentario' class='btn btn-info btn-sm btn-icon waves-effect waves-themed'>
                                <i class='fa fa-comment' aria-hidden='true'></i>
                            </a>";
                }                
            })
            ->addColumn('pre_pro', function($row){                
                return number_format((float) $row->pre_pro, 2, '.', '');
            })
            ->addColumn('pre_tot', function($row){
                return number_format((float) $row->pre_tot, 2, '.', '');
            })                      
            ->addColumn('est_detalle', function($row){
                if($row->est_detalle=="LISTO"){
                    return "<span class='badge badge-success badge-pill'>".$row->est_detalle."</span>";
                }else{
                    return "<span class='badge badge-warning badge-pill'>".$row->est_detalle."</span>";
                }                
            })            
            ->rawColumns(['action','est_detalle','comentario','pre_pro','pre_tot'])              
            ->make(true);
      
    }
   
    public function store(Request $request)
    {        
        /////CREAR NUEVO pedido y ocupar mesa                  
        $id_pedido_temp = DB::table('pedidos_tem')->insertGetId([
            'fecha'   => date('Y-m-d H:i:s'),
            'id_mesa' => $request['id_mesa'],
            'id_user' => $request['id_user'],
        ]);

        $up_mesa = DB::table('mesas')
        ->where('id', $request['id_mesa'])
        ->update([
            'estado'=> 1
        ]);

        if($id_pedido_temp && $up_mesa){
            return response()->json([
                'msg'=>'Ocupando mesa...',
                'id_pedido_temp' =>$id_pedido_temp
            ], 200);
        }else{
            return response()->json(['msg'=>'Error de base de datos...'], 500);
        }  
        
    }

    
    public function show($id_pedido_temp, Request $request)// liberar mesa y eliminar datos de tablas temporales
    {
        DB::table('pedido_detalle_temp')// eliminar orden en NO, en pedido
            ->where('id_pedidos', $id_pedido_temp)
            ->where('orden', '=','NO')           
            ->delete();
        
        DB::table('pedidos_tem')->where('id', $id_pedido_temp)->delete();
        
        $up_mesa = DB::table('mesas')
            ->where('id', $request['id_mesa'])
            ->update([
                'estado'=> 0
            ]);
        if($up_mesa){
            return response()->json(['msg'=>'Mesa libre...'], 200);
        }else{
            return response()->json(['msg'=>'Error de base de datos...'], 500);
        }
    }

    
    public function edit($id_pedido_temp, Request $request)
    {
        $check_no = DB::table('pedido_detalle_temp')
            ->where('id_pedidos', $id_pedido_temp)
            ->where('orden', '=','NO')
            ->where('elim', '=', 0)
            ->count();

        if($check_no>0){
            $up_ped_det_temp = DB::table('pedido_detalle_temp')
                ->where('id_pedidos', $id_pedido_temp)
                ->where('orden', '=','NO')
                ->update([
                    'create_at' => date('Y-m-d H:i:s'),
                    'orden' => 'SI',
                ]);

            $chek_id_user_mesa = DB::table('mesas')
                ->where('id', $request['id_mesa'])
                ->get();

            if($chek_id_user_mesa[0]->id_user){// si existe un usuario en la mesa no lo actualiza
                $up_mesa = DB::table('mesas')
                    ->where('id', $request['id_mesa'])
                    ->update([ 'estado'=> 1,'id_pedido'=> $id_pedido_temp]);
            }else{
                $up_mesa = DB::table('mesas')
                    ->where('id', $request['id_mesa'])
                    ->update(['estado'=> 1, 'id_pedido'=> $id_pedido_temp,'id_user'=> $request['id_user'] ]);
            }  
           
            
            if($up_mesa && $up_ped_det_temp){
                return response()->json(['msg'=>'Se envió comanda...','id_pedido_temp' =>$id_pedido_temp], 200);
            }else{
                return response()->json(['msg'=>'Error de base de datos...'], 200);
            }
        }else{
            return response()->json(['msg'=>0], 200);
        }
        
    }

    public function update(Request $request, $id_pedido_temp)
    { 
        $del = DB::table('pedido_detalle_temp')// eliminar orden en NO, en pedido
            ->where('id_pedidos', $id_pedido_temp)
            ->where('orden', '=','NO')
            ->delete();        
    }

    
    public function destroy($id, Request $request)
    {     
        if($request['tipo']=='ELIMINAR'){
            $eliminar_detalle = DB::table('pedido_detalle_temp')->where('id', $id)->delete();
        }else{
            $detalle_pedido=DB::table('vw_detalle_temp')->where('id_detalle','=',$id)->get();

            $data[]=[
                'id_mozo'   => $detalle_pedido[0]->id_user,
                'id_mesa'   => $detalle_pedido[0]->id_mesa,
                'cant'      => $detalle_pedido[0]->cant,
                'des_pro'   => $detalle_pedido[0]->des_pro,
                'pre_pro'   => $detalle_pedido[0]->pre_pro,
                'pre_tot'   => $detalle_pedido[0]->pre_tot,
                'fch_elim'  => date('Y-m-d H:i:s'),
                'razon'     => strtoupper($request['des_elim']),
                'id_user'   => Auth::user()->id,
            ];
         
            $eliminar_detalle = DB::table('eliminados')->insert($data);
            $eliminar_detalle = DB::table('pedido_detalle_temp')->where('id', $id)->delete();    
            
            if($detalle_pedido[0]->est_detalle=='LISTO'){
                DB::table('almacen.salidas')->where('id_detalle', $id)->delete();
            }
            
        }
        
        
        if($eliminar_detalle){

            return response()->json(['msg'=>'Eliminado...'], 200);
        }else{
            return response()->json(['msg'=>'Error de base de datos...'], 500);
        }
        
    }


    public function check_orden($id_detalle_temp){        
        $check_no = DB::table('pedido_detalle_temp')
            ->where('id', $id_detalle_temp)            
            ->get();        
        return response()->json(['msg'=>$check_no[0]->orden], 200);
    }

     
    public function add_coment(Request $request){
        $ad_coment = DB::table('pedido_detalle_temp')
            ->where('id', $request['id_detalle_temp'])
            ->update([
                'comentario' => strtoupper($request['comentario']),               
            ]);

        if($ad_coment){
            return response()->json(['msg'=>'Comentario agregado'], 200);
        }else{
            return response()->json(['msg'=>'Error de base de datos...'], 500);
        }
    }

    function limitar_cadena($cadena, $limite, $sufijo){
        // Si la longitud es mayor que el límite...
        if(strlen($cadena) > $limite){
            // Entonces corta la cadena y ponle el sufijo
            return substr($cadena, 0, $limite) . $sufijo;
        }
        // Si no, entonces devuelve la cadena normal
        return $cadena;
    }
}
