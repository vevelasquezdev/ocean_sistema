<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PedidosController extends Controller
{
    
    public function index()
    {
        //
    }

    
    public function create()
    {
        //
    }

    public function get_ittems_table(Request $request){
        
        // echo $request['id_pedido'];

        $data = DB::table('vw_detalle')
            ->where('id_mesa','=', $request['id_mesa'])
            ->where('id_user','=',$request['id_user'])
            ->where('id','=',$request['id_pedido'])
            ->orderBy('id_detalle')
            ->get();
      
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){                    
                return "
                <a onclick='del_ittem(".$row->id_detalle.")' href='javascript:void(0);' title='Eliminar' class='btn btn-danger btn-sm btn-icon waves-effect waves-themed'>
                    <i class='fal fa-trash'></i>
                </a>";                     
            })
            ->addColumn('pre_pro', function($row){                
                return number_format((float) $row->pre_pro, 2, '.', '');
            })
            ->addColumn('pre_tot', function($row){
                return number_format((float) $row->pre_tot, 2, '.', '');
            })          
            ->addColumn('est_detalle', function($row){
                return "<span class='badge badge-warning badge-pill'>".$row->est_detalle."</span>";
            })
            ->rawColumns(['action','est_detalle','pre_pro','pre_tot'])              
            ->make(true);
      
    }

    public function store(Request $request)
    {
        
        $id_pedido = DB::table('pedidos')->insertGetId([
            'id_mesa' => $request['id_mesa'],
            'id_user' => $request['id_user'],
            'fecha' => date('Y-m-d H:i:s')
        ]);

        $selects = DB::table('pedido_detalle_temp')
                ->select('cant','estado','id_pro')
                ->where('id_pedidos','=',$request['id_pedido_temp'])                
                ->get();

        $dataSet = [];
        foreach ($selects as $select) {
            $dataSet[] = [
                'cant'      => $select->cant,
                'create_at' => date('Y-m-d H:i:s'),
                'estado'    => $select->estado,
                'id_pro'    => $select->id_pro,
                'id_pedido' => $id_pedido,
            ];
        }

        $row_insert = DB::table('pedido_detalle')->insert($dataSet);

        $up_mesa = DB::table('mesas')
            ->where('id', $request['id_mesa'])
            ->update([                
                'estado'=> 1,
                'id_pedido'=> $id_pedido
            ]);
        
        if($row_insert && $up_mesa){
            return response()->json(['msg'=>'Pedido creado...','id_pedido' =>$id_pedido], 200);
        }else{
            return response()->json(['msg'=>'Error de base de datos...'], 500);
        }
    }

   
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
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
