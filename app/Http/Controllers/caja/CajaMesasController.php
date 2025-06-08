<?php

namespace App\Http\Controllers\caja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CajaMesasController extends Controller
{
    
    public function index()
    {
        $mesas = DB::table('vw_mesas')->orderBy("id")->get();        
        return view('caja.caja-mesas', compact('mesas'));       
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
