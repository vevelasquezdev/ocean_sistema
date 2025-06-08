<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    
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
        request()->validate([
            'ruc' => 'min:11|max:11|unique:clientes',
        ],[            
            'ruc.unique' => 'Ruc ya existe...',            
        ]);

              
        $id_cli = Cliente::insertGetId($request->except(['id','_token','id_pedido_temp']) + ['created_at' => date('Y-m-d H:i:s')]);

        $up_pedido_temp_id_cli = DB::table('pedidos_tem')
            ->where('id', $request['id_pedido_temp'])
            ->update([
                'id_clie'=> $id_cli
            ]);
        
        if($id_cli && $up_pedido_temp_id_cli){
            return response()->json([
                'msg'=>'Cliente agregado...',
                'id_cli'=>$id_cli
            ], 200);
        }else{
            return response()->json(['msg'=>'Error de base de datos'], 500);
        }

        
    }

    
    public function show($id)
    {
        $get_cliente = DB::table('pedidos_tem')->where('id', $id)->get();

        $user = DB::table('users')->where('id', $get_cliente[0]->id_user)->get();

        if($user[0]->id)
        {
            if($get_cliente[0]->id_clie){

                $cliente = DB::table('clientes')->where('id', $get_cliente[0]->id_clie)->get();
    
                return response()->json([
                    'id_cli'    =>$cliente[0]->id,
                    'ruc'       =>$cliente[0]->ruc,
                    'raz_soc'   =>$cliente[0]->raz_soc,
                    'dir'       =>$cliente[0]->dir,
                    'name'      =>$user[0]->name,
                    'surname'   =>$user[0]->surname,
                    'fecha'     =>$get_cliente[0]->fecha       
                ], 200);
            }else{
                return response()->json([
                    'name'      =>$user[0]->name,
                    'surname'   =>$user[0]->surname,
                    'fecha'     =>$get_cliente[0]->fecha                                
                ], 200);
            }

        }

        


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
