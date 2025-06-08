<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
   
    public function index(Request $request) {
        
        if ($request->ajax()) {
            $data = User::latest('id')->where('active',1);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){                    
                    return "
                    <button onclick='getdatauser(".$row->id.")' class='btn btn-primary btn-sm' data-toggle='modal' 
                        data-target='.default-example-modal-right'>Editar
                    </button>|
                    <button onclick='delete_user(".$row->id.")' class='btn btn-danger btn-sm'>Eliminar</button>                                         
                    ";                     
                })                
                ->addColumn('profile_photo_path', function($row){
                    return '  
                    <div class="profile-image-md rounded-circle" style="background-image:url('.$row->profile_photo_url.'); background-size: cover; margin-left:8px">                    
                    </div>';                     
                })
                ->rawColumns(['action', 'profile_photo_path'])              
                ->make(true);
        }
        
        return view('admin.usuario');
    }

    public function get_data_user(Request $request) {
        
        $datos = User::find($request['id']);
        if($datos){
            return response()->json($datos);
        }else{
            return response()->json(['msg'=>'Error'], 500);
        }
        
    }


    public function store(Request $request, User $user){
        

        if($request->id!=''){ ///Actualizar usuario
            
            $request->validate([
                'name' => 'required|min:3',        
                'surname' => 'required|min:3',
                'email' => 'required|email|max:255|unique:users,email,'.$request->id,
                'rol' => 'required',
            ]);
            if($request['password']!=''){
                $id_user = DB::table('users')->where('id',$request->id)->update([
                    'name'      => $request['name'],
                    'surname'   => $request['surname'],             
                    'email'     => $request['email'],
                    'rol'       => $request['rol'],
                    'password'  => Hash::make($request['password']),
                ]);
            }else{
                $id_user = DB::table('users')->where('id',$request->id)->update([
                    'name'      => $request['name'],
                    'surname'   => $request['surname'],             
                    'email'     => $request['email'],
                    'rol'       => $request['rol'],                  
                ]);
            }
           

            if($id_user){
                return response()->json(['msg'=>'Actualizacion realizada...','id_user'=>$id_user], 200);
            }else{
                return response()->json(['msg'=>'Error en base de datos...'], 500);
            }

        }else{/////CREAR NUEVO USUARIO
            
            $request->validate([
                'name' => 'required|min:3',        
                'surname' => 'required|min:3',
                'email' => 'required|email|max:255|unique:users',
                'rol' => 'required',
            ]);
          
            $id_user = DB::table('users')->insertGetId([
                'name'      => $request['name'],
                'surname'   => $request['surname'],             
                'email'     => $request['email'],
                'rol'       => $request['rol'],
                'password'  => Hash::make($request['password']),
                'active'    => 1
            ]);
                      
            if($id_user){
                return response()->json(['msg'=>'Usuario agregado...','id_user'=>$id_user], 200);
            }else{
                return response()->json(['msg'=>'Error en base de datos...'], 500);
            }
            
        }
    
    }

    
    public function edit(Request $request, $id){

        try{
            $datos = User::find($id);
        }catch(\Exception $exception){
            return view('errors.404');
        }
        
        if($datos){
            return response()->json($datos);
        }else{
            return response()->json(['msg'=>'Error al obtener datos'], 500);
        }
    }

       
    public function destroy($id){

        $user = User::find($id);
        $user->active = 0;
        
        if($user->save()){
            return response()->json([ 'msg' => 'Registro eliminado con éxito!']);
        }else{
            return response()->json(['msg'=>'Error al eliminar registro'], 500);
        }
       
    }


    public function exportExcelUsers(){
        return Excel::download(new UsersExport, 'lista de usuarios.xlsx');
    }

    public function importExcelUsers(Request $request){
        $file = $request->file('file');
        Excel::import(new UsersImport, $file);
        return back()->with('message', 'importacion de usuarios completada...');
    }
}

