<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use PDF;
use Illuminate\Support\Facades\URL;


class HomeMesasController extends Controller
{   
    protected $fpdf;
    public function __construct()
    {
        $this->fpdf = new Fpdf('P','mm',array(80,150));
    }
    
    public function index(Request $request)
    {
        $formapagos = DB::table('forma_pago')->orderBy("id")->get();
        $mesas = DB::table('vw_mesas')->orderBy("id")->get();        
        return view('admin.home-mesas', compact('mesas','formapagos'));
    }

    public function create()
    {
        
    }

   
   
    public function store(Request $request, $query)
    {
       
        $Consulta = DB::table('carta')->where('des_pro','like','%'.strtoupper($query).'%')->where('des_pro', 'not like', 'DESCUENTO')->get();
        
        $todo = array();
        foreach ($Consulta as $Datos) {
            $Lista = new \stdClass();
            $Lista->id = $Datos->id;
            $Lista->label = trim($Datos->des_pro).' -- '.trim($Datos->pre_pro);
            $Lista->descripcion = trim($Datos->des_pro);
            $Lista->precio = $Datos->pre_pro;
            array_push($todo, $Lista);
        }
        return response()->json($todo);
    }

    
    public function show($id_mesa)//check_mesa
    {
        $check_mesa = DB::table('mesas')->where('id', $id_mesa)->get();
        return response()->json(['estado'=>$check_mesa[0]->estado], 200);        
    }

    public function print_ticket($id_pedido_temp){
        $datos = DB::table('vw_ticket')->where('id', $id_pedido_temp)->orderBy('id_detalle')->get();
       
        $this->fpdf->AddPage();        
        $this->fpdf->Image('smartadmin/dist/img/ocean_logo2.png', '23','7','35','34','PNG');
        $this->fpdf->Ln(23);
        $this->fpdf->SetFont('Helvetica','', 8); 
        $this->fpdf->Ln(10);      
        $this->fpdf->Cell(60,4,'Av. Costanera - Playa Las Brisas',0,1,'C');
        $this->fpdf->Cell(60,4,'La Punta Camana',0,1,'C');
        // $this->fpdf->Cell(60,4,'Tel: 975324507',0,1,'C');     

        // DATOS FACTURA        
        $this->fpdf->Ln(1);
        $this->fpdf->Cell(60,4,'Nro. Ticket :  ' .$datos[0]->id,0,1,'');
        $this->fpdf->Cell(60,4,'Fecha Ped.:  ' .date('d-m-Y', strtotime($datos[0]->fecha)),0,1,'');
        $this->fpdf->Cell(60,4,'Fecha Imp.: ' .date('d-m-Y'). '          Hora Imp.:  ' .date('H:i'),0,1,'');
        $this->fpdf->Cell(60,4,'Mesero:  ' .$datos[0]->mozo. '                    Mesa: ' .$datos[0]->id_mesa ,0,1,'');

        // COLUMNAS
        $this->fpdf->SetFont('Helvetica', 'B', 7);
        $this->fpdf->Cell(30, 10, 'Producto', 0);
        $this->fpdf->Cell(8, 10, 'Cant',0,0,'R');
        $this->fpdf->Cell(10, 10, 'Precio',0,0,'R');
        $this->fpdf->Cell(15, 10, 'Total',0,0,'R');
        $this->fpdf->Ln(8);
        $this->fpdf->Cell(60,0,'','T');
        $this->fpdf->Ln(0);
        
        $this->fpdf->SetFont('Helvetica', '', 7);

        $to=0;
        foreach($datos as $data){ 
            $this->fpdf->MultiCell(30,4, $data->des_pro ,0,'L'); 
            $this->fpdf->Cell(35, -5, $data->cant ,0,0,'R');

            $this->fpdf->Cell(10, -5, number_format(round($data->pre_pro,2), 2, ',', ' '),0,0,'R');
            $y= $data->cant * $data->pre_pro;
            $this->fpdf->Cell(15, -5, number_format(round($y,2), 2, ',', ' '),0,0,'R');
            $this->fpdf->Ln(1);

            $to += $y;
        }

		$st = $to / 1.18;
        $igv = $st * 0.18;

        // SUMATORIO DE LOS PRODUCTOS Y EL IVA
        // $this->fpdf->Ln(1);
        $this->fpdf->Cell(60,0,'','T');
        $this->fpdf->Ln(1);    
        $this->fpdf->Cell(25, 10, 'SUBTOTAL', 0);    
        $this->fpdf->Cell(20, 10, '', 0);
        $this->fpdf->Cell(15, 10, number_format(round($st,2), 2, ',', ' ').'  S/',0,0,'R');
        $this->fpdf->Ln(3);    
        $this->fpdf->Cell(25, 10, 'IGV 18%', 0);    
        $this->fpdf->Cell(20, 10, '', 0);
        $this->fpdf->Cell(15, 10, number_format(round($igv,2), 2, ',', ' ').'  S/',0,0,'R');
        $this->fpdf->Ln(3);    
        $this->fpdf->Cell(25, 10, 'TOTAL', 0);    
        $this->fpdf->Cell(20, 10, '', 0);
        $this->fpdf->Cell(15, 10, number_format(round($to,2), 2, ',', ' ').'  S/',0,0,'R');

        // PIE DE PAGINA
        $this->fpdf->Ln(10);
        $this->fpdf->Cell(60,0,'GRACIAS POR SU PREFERENCIA',0,1,'C');
        $this->fpdf->Ln(3);
        $this->fpdf->SetFont('Helvetica', '', 6);
        $this->fpdf->Cell(60,0,' Sistemas para empresas WebSoftAqp 927245347',0,1,'C');
        
        //abrir
        $this->fpdf->Output('ticket_cuenta.pdf','i');

        // //descarga
        // //$pdf->Output('ticket_cuenta.pdf', 'D');

        // //guardar
        // $this->fpdf->Output('ticket_cuenta.pdf', 'F');
        
     
    }

    
    public function edit($id)
    {
    //     $paper_size = array(0,0,80,150);
    //     $dompdf->set_paper($paper_size);
    }

    
    public function update(Request $request, $id)
    {
        //
    }

   
    public function destroy($id, Request $request)// Eliminar Comanda
    {
        $delete = DB::table('pedidos_tem')->where('id',$id)->delete();        
        
        if($delete){
            DB::table('mesas')
                ->where('id', $request['id_mesa'])
                ->update([
                    'estado'=> 0,
                    'id_pedido'=> null,
                    'id_user'=> null
                ]);
            return response()->json(['msg'=>'Comanda eliminada...'], 200);
        }else{
            return response()->json(['msg'=>'Error de base de datos...'], 500);
        }
    }
}
