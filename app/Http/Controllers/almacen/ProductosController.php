<?php

namespace App\Http\Controllers\almacen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class ProductosController extends Controller
{
    public function ccc(){
        
        $fecha=Carbon::createFromFormat("d-m-Y", date('d-m-Y'), config('app.timezone'));
        return date('d-m-Y').'---'.$fecha.'----'.Carbon::now();
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('almacen.productos')                    
                    ->orderBy('id')                
                    ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return "<button title='Editar producto' onclick='getdata(".$row->id.")' class='btn btn-primary btn-sm' data-toggle='modal' 
                                data-target='#DldModalProductos'><span class='fal fa-pencil'></span>
                            </button>"; 
                            // return "<button title='Editar producto' onclick='getdata(".$row->id.")' class='btn btn-primary btn-sm' data-toggle='modal' 
                            //     data-target='#DldModalProductos'><span class='fal fa-pencil'></span>
                            // </button>&nbsp;|                            
                            // <button title='Eliminar producto' onclick='del(".$row->id.")' class='btn btn-sm btn-danger'>
                            //     <span class='fa fa-window-close'></span>
                            // </button>";          
                })                              
                ->rawColumns(['action'])              
                ->make(true);
        }
        return view('almacen.productos');
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        if($request->id!=''){ ///Actualizar
            
            request()->validate([
                //'des_pro'       => 'required|unique:pgsql.almacen.productos,des_pro,'.$request->id,
                'des_pro'       => 'required',
                'unidad'        => 'required',
                'lugar'         => 'required',
            ],[
                'des_pro.required' => 'Descripción de producto es obligatorio.',   
                'des_pro.unique' => 'Producto ya existe.',                       
            ]);
            
            $sql = DB::table('almacen.productos')->where('id',$request->id)->update([                
                'des_pro'   => $request['des_pro'],               
                'unidad'    => $request['unidad'],          
                'existencia'=> 0,
                'lugar'     => $request['lugar'],            
            ]);
            
            if($sql){
                return response()->json(['msg'=>'Actualizacion terminada...'], 200);
            }else{
                return response()->json(['msg'=>'Error...'], 500);
            }
        

        }else{/////CREAR NUEVO 
            
            request()->validate([
                    //'des_pro'    => 'required|unique:pgsql.almacen.productos',
                    'des_pro'    => 'required',
                    'unidad'     => 'required',            
                    'existencia' => 'required',
                    'lugar'      => 'required',
                ],[
                    'des_pro.required' => 'Descripción de producto es obligatorio.',
                ]);
                        
                $sql = DB::table('almacen.productos')->insertGetId([                
                    'des_pro'   => $request['des_pro'],               
                    'unidad'    => $request['unidad'],          
                    'existencia'=> 0,
                    'lugar'     => $request['lugar'],   
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
        $datos = DB::table('almacen.productos')->where('id',$id)->get();
      
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
        $elim = DB::table('almacen.productos')->where('id',$id)->delete();
      
        if($elim){
            return response()->json(['msg' => 'Registro eliminado...!'],200);
        }else{
            return response()->json(['msg'=>'Error al eliminar Registro...!'], 500);
        }
    }


    public function recuento_barra(){
        $sql=DB::select("update almacen.productos 
                            set existencia = (select (b0_stock+b1_stock+b2_stock+b3_stock+b4_stock) from almacen.vw_consolidado_barra where almacen.productos.id = almacen.vw_consolidado_barra.id_prod)
                        where lugar='BARRA'");
        if($sql){
            return response()->json(['msg' => 'Existencia totales de Barra actualizadas...!'],200);
        }else{
            return response()->json(['msg' => 'Error al realizar operacion de recuento...!'], 500);
        }
    }

    public function recuento_cocina(){
        $sql=DB::select("update almacen.productos 
                            set existencia = (select (c0_stock+c1_stock+c2_stock) from almacen.vw_consolidado_cocina where almacen.productos.id = almacen.vw_consolidado_cocina.id_prod)
                        where lugar='COCINA'");
        if($sql){
            return response()->json(['msg' => 'Existencia totales de Cocina actualizadas...!'],200);
        }else{
            return response()->json(['msg' => 'Error al realizar operacion de recuento...!'], 500);
        }
    }

    public function recargar_inventarios(){
        
        $inventarios = array('barra_4','principal_barra','barra_1','barra_2','barra_3','principal_cocina','cocina_1','cocina_2');
        $fecha = date("Y-m-d",strtotime(date('Y-m-d')));
        $c_pri_barra= DB::table('almacen.principal_barra')->whereDate('fecha', $fecha)->count('id');        
        $c_barra_1= DB::table('almacen.barra_1')->whereDate('fecha', $fecha)->count('id');
        $c_barra_2= DB::table('almacen.barra_2')->whereDate('fecha', $fecha)->count('id');
        $c_barra_3= DB::table('almacen.barra_3')->whereDate('fecha', $fecha)->count('id');
        $c_barra_4= DB::table('almacen.barra_4')->whereDate('fecha', $fecha)->count('id');

        $c_pri_cocina= DB::table('almacen.principal_cocina')->whereDate('fecha', $fecha)->count('id');
        $c_cocina_1= DB::table('almacen.cocina_1')->whereDate('fecha', $fecha)->count('id');
        $c_cocina_2= DB::table('almacen.cocina_2')->whereDate('fecha', $fecha)->count('id');

        try{

            if($c_pri_barra==0 || $c_pri_barra=='0'){
                // echo 'si prioncipal<br>';
                DB::select("insert into almacen.principal_barra (id_prod,unidad,inicial,entradas,salidas,stock,fecha) select id_prod,unidad,stock,0,0,stock,now() from almacen.principal_barra where fecha::date = current_date-1 order by id;");
            }
            if($c_barra_1==0 || $c_barra_1=='0'){
                // echo 'si barra_1<br>';
                DB::select("insert into almacen.barra_1 (id_prod,unidad,inicial,entradas,salidas,stock,fecha) select id_prod,unidad,stock,0,0,stock,now() from almacen.barra_1 where fecha::date = current_date-1 order by id;");
            }
            if($c_barra_2==0 || $c_barra_2=='0'){
                // echo 'si c_barra_2<br>';
                DB::select("insert into almacen.barra_2 (id_prod,unidad,inicial,entradas,salidas,stock,fecha) select id_prod,unidad,stock,0,0,stock,now() from almacen.barra_2 where fecha::date = current_date-1 order by id;");
            }
            
            if($c_barra_3==0 || $c_barra_3=='0'){
                // echo 'si c_barra_3<br>';
                DB::select("insert into almacen.barra_3 (id_prod,unidad,inicial,entradas,salidas,stock,fecha) select id_prod,unidad,stock,0,0,stock,now() from almacen.barra_3 where fecha::date = current_date-1 order by id;");
            }
                    
            if($c_barra_4==0 || $c_barra_4=='0'){
                // echo 'si c_barra_4<br>';
                DB::select("insert into almacen.barra_4 (id_prod,unidad,inicial,entradas,salidas,stock,fecha) select id_prod,unidad,stock,0,0,stock,now() from almacen.barra_4 where fecha::date = current_date-1 order by id");
            }
    
            if($c_pri_cocina==0 || $c_pri_cocina=='0'){
                // echo 'si c_pri_cocina<br>';
                DB::select("insert into almacen.principal_cocina (id_prod,unidad,inicial,entradas,salidas,stock,fecha) select id_prod,unidad,stock,0,0,stock,now() from almacen.principal_cocina where fecha::date = current_date-1 order by id");
            }
    
            if($c_cocina_1==0 || $c_cocina_1=='0'){
                //echo 'si c_cocina_1<br>';
                DB::select("insert into almacen.cocina_1 (id_prod,unidad,inicial,entradas,salidas,stock,fecha) select id_prod,unidad,stock,0,0,stock,now() from almacen.cocina_1 where fecha::date = current_date-1 order by id");
            }
    
            if($c_cocina_2==0 || $c_cocina_2=='0'){
                //echo 'si c_cocina_2<br>';
                DB::select("insert into almacen.cocina_2 (id_prod,unidad,inicial,entradas,salidas,stock,fecha) select id_prod,unidad,stock,0,0,stock,now() from almacen.cocina_2 where fecha::date = current_date-1 order by id");
            }
    
            //echo $c_pri_barra.'-'.$c_barra_1.'-'.$c_barra_2.'-'.$c_barra_3.'-'.$c_barra_4.'-fech:'.$fecha;
            
            return response()->json(['msg' => 'Inventarios actualizados...!'],200);

        } catch (Exception $e) {
            return response()->json(['msg' => 'Error al actualizar...!'],500);
        }
    }


    public function find_producto(Request $request){
        if($request['origen']=='PRINCIPAL_COCINA'){
            $Consulta = DB::table('almacen.vw_principal_cocina')
                        ->where('des_pro','like','%'.strtoupper($request['query']).'%')
                        ->whereDate('fecha_eje', date('Y-m-d'))
                        ->get();
        }elseif($request['origen']=='COCINA_1'){
            $Consulta = DB::table('almacen.vw_cocina_uno')
                        ->where('des_pro','like','%'.strtoupper($request['query']).'%')
                        ->whereDate('fecha_eje', date('Y-m-d'))
                        ->get();

        }elseif($request['origen']=='COCINA_2'){
            $Consulta = DB::table('almacen.vw_cocina_dos')
                        ->where('des_pro','like','%'.strtoupper($request['query']).'%')
                        ->whereDate('fecha_eje', date('Y-m-d'))
                        ->get();

        }elseif($request['origen']=='PRINCIPAL_BARRA'){
            $Consulta = DB::table('almacen.vw_principal_barra')
                        ->where('des_pro','like','%'.strtoupper($request['query']).'%')
                        ->whereDate('fecha_eje', date('Y-m-d'))
                        ->get();
        }elseif($request['origen']=='BARRA_1'){
            $Consulta = DB::table('almacen.vw_barra_uno')
                        ->where('des_pro','like','%'.strtoupper($request['query']).'%')
                        ->whereDate('fecha_eje', date('Y-m-d'))
                        ->get();
        }elseif($request['origen']=='BARRA_2'){
            $Consulta = DB::table('almacen.vw_barra_dos')
                        ->where('des_pro','like','%'.strtoupper($request['query']).'%')
                        ->whereDate('fecha_eje', date('Y-m-d'))
                        ->get();
        }elseif($request['origen']=='BARRA_3'){
            $Consulta = DB::table('almacen.vw_barra_tres')
                        ->where('des_pro','like','%'.strtoupper($request['query']).'%')
                        ->whereDate('fecha_eje', date('Y-m-d'))
                        ->get();
        }elseif($request['origen']=='BARRA_4'){
            $Consulta = DB::table('almacen.vw_barra_cuatro')
                        ->where('des_pro','like','%'.strtoupper($request['query']).'%')
                        ->whereDate('fecha_eje', date('Y-m-d'))
                        ->get();
        }else{
            $Consulta = DB::table('almacen.productos')->where('des_pro','like','%'.strtoupper($request['query']).'%')->get();
        }        
        
        $todo = array();
        foreach ($Consulta as $Datos) {
            $Lista = new \stdClass();
            $Lista->id = $Datos->id_prod;
            $Lista->label = trim($Datos->des_pro).' -- Stock: '.$Datos->stock;
            $Lista->descripcion = trim($Datos->des_pro);
            $Lista->unidad = $Datos->unidad;
            $Lista->lugar = $Datos->lugar;
            $Lista->stock = $Datos->stock;
            array_push($todo, $Lista);
        }
        return response()->json($todo);
    }

    

    public function find_producto_entradas($query){
        $Consulta = DB::table('almacen.productos')->where('des_pro','like','%'.strtoupper($query).'%')->get();
        
        $todo = array();
        foreach ($Consulta as $Datos) {
            $Lista = new \stdClass();
            $Lista->id = $Datos->id;
            $Lista->label = trim($Datos->des_pro).' -- '.trim($Datos->unidad).' - '.$Datos->lugar;
            $Lista->descripcion = trim($Datos->des_pro);
            $Lista->unidad = $Datos->unidad;
            $Lista->lugar = $Datos->lugar;
            array_push($todo, $Lista);
        }
        return response()->json($todo);
    }
}
