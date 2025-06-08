<?php

namespace App\Http\Controllers\pedidos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class EliminadosController extends Controller
{
    
    public function index(Request $request) {
        return view('pedidos.eliminados');
    }

    public function tabla_eliminados(Request $request){
        $data = DB::table('vw_eliminados')->whereDate('fch_elim', date('Y-m-d',strtotime($request['fch'])))->get();
        
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('pre_pro', function($row){                
                return number_format((float) $row->pre_pro, 2, '.', '');
            })
            ->addColumn('pre_tot', function($row){
                return number_format((float) $row->pre_tot, 2, '.', '');
            })
            ->addColumn('fch_elim', function($row){
                if($row->fch_elim){
                    return (new \DateTime($row->fch_elim))->format("j F Y - G:ia") . PHP_EOL;
                }                   
            })
            ->rawColumns(['pre_pro','pre_tot'])              
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
