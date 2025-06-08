<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Carta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CartaController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('carta')->where('des_pro', 'not like', 'DESCUENTO')->where('des_pro', 'not like', 'MISELANEO')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){                    
                    return "
                    <button onclick='getdata(".$row->id.")' class='btn btn-primary btn-sm' data-toggle='modal' 
                        data-target='.default-example-modal-right'>Editar
                    </button>|
                    <button onclick='del(".$row->id.")' class='btn btn-danger btn-sm'>Eliminar</button>                                         
                    ";                     
                })
                ->addColumn('pre_pro', function($row){
                    return '<h5 class="text-success my-auto" style="font-weight:bold;">S/.&nbsp;'.number_format((float) $row->pre_pro, 2, '.', '').'</h5>';                     
                })
                ->rawColumns(['action','pre_pro'])              
                ->make(true);
        }
        
        return view('admin.carta');
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        if($request->id!=''){ ///Actualizar
            
            request()->validate([
                'tip_pro' => 'required',        
                'des_pro' => 'required',
                'pre_pro' => 'required|numeric|regex:/^[\d]{0,8}(\.[\d]{1,2})?$/',
            ],[
                'tip_pro.required' => 'Campo tipo de producto es obligatoria',
                'des_pro.required' =>'Descripcion es obligatoria',
                'pre_pro.required' =>'Precio del producto es obligatoria',
                'pre_pro.regex' =>'Precio del producto Formato invalido',
            ]);

            // $up_carta = DB::table('carta')
            //     ->where('id', $request['id'])
            //     ->update($request->except('_token'));

            $sql = Carta::find($request->id)->update($request->all());
            if($sql){
                return response()->json(['msg'=>'Actualizacion terminada...'], 200);
            }else{
                return response()->json(['msg'=>'Error...'], 500);
            }
        

        }else{/////CREAR NUEVO 
            
            request()->validate([
                'tip_pro' => 'required',        
                'des_pro' => 'required',
                'pre_pro' => 'required|numeric|regex:/^[\d]{0,8}(\.[\d]{1,2})?$/',
            ],[
                'tip_pro.required' => 'Campo tipo de producto es obligatoria',
                'des_pro.required' =>'Descripcion es obligatoria',
                'pre_pro.required' =>'Precio del producto es obligatoria',
                'pre_pro.regex' =>'Precio del producto Formato invalido',
            ]);
           
                      
            Carta::create($request->all());
            return response()->json(['msg'=>'Nuevo producto agregado...'], 200);
        }
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit(Request $request, $id)
    {
        try{
            $datos = Carta::find($id);
        }catch(\Exception $exception){
            return view('errors.404');
        }
        
        if($datos){
            return response()->json($datos);
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
        $del = Carta::find($id);
        $del->delete();
    }
}
