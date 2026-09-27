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
        $this->fpdf->SetAutoPageBreak(false);
        $this->fpdf->SetLeftMargin(8);
        $this->fpdf->SetRightMargin(8);
        $anchoTotal = 64;
        $anchoProducto = 30;
        $anchoCantidad = 10;
        $anchoPrecio = 12;
        $anchoImporte = 12;

        $this->fpdf->Image('smartadmin/dist/img/ocean_logo2.png', '23', '7', '35', '34', 'PNG');
        $this->fpdf->Ln(23);
        $this->fpdf->SetFont('Helvetica', '', 9);
        $this->fpdf->Ln(10);      
        $this->fpdf->Cell($anchoTotal, 4, 'Av. Costanera - Playa Las Brisas', 0, 1, 'C');
        $this->fpdf->Cell($anchoTotal, 4, 'La Punta Camana', 0, 1, 'C');

        // DATOS FACTURA        
        $this->fpdf->Ln(1);
        $this->fpdf->Cell($anchoTotal, 4, 'Nro. Ticket: ' . $datos[0]->id, 0, 1, 'C');
        $this->fpdf->Cell($anchoTotal, 4, 'Fecha Ped.: ' . date('d-m-Y', strtotime($datos[0]->fecha)), 0, 1, 'C');
        $this->fpdf->Cell($anchoTotal, 4, 'Fecha Imp.: ' . date('d-m-Y') . '  Hora: ' . date('H:i'), 0, 1, 'C');
        $this->fpdf->Cell($anchoTotal, 4, 'Mesero: ' . $datos[0]->mozo . '  Mesa: ' . $datos[0]->id_mesa, 0, 1, 'C');

        $imprimirCabeceraProductos = function () use ($anchoProducto, $anchoCantidad, $anchoPrecio, $anchoImporte, $anchoTotal) {
            $this->fpdf->SetFont('Helvetica', 'B', 9);
            $this->fpdf->Ln(3);
            $this->fpdf->Cell($anchoProducto, 8, 'Producto', 0, 0, 'C');
            $this->fpdf->Cell($anchoCantidad, 8, 'Cant', 0, 0, 'C');
            $this->fpdf->Cell($anchoPrecio, 8, 'Precio', 0, 0, 'C');
            $this->fpdf->Cell($anchoImporte, 8, 'Total', 0, 1, 'C');
            $this->fpdf->Cell($anchoTotal, 0, '', 'T');
            $this->fpdf->Ln(1);
            $this->fpdf->SetFont('Helvetica', '', 8);
        };

        $imprimirPie = function () use ($anchoTotal) {
            $this->fpdf->SetFont('Helvetica', '', 7);
            $this->fpdf->SetY(140);
            $this->fpdf->Cell($anchoTotal, 3, 'GRACIAS POR SU PREFERENCIA', 0, 1, 'C');
            $this->fpdf->SetFont('Helvetica', '', 6);
            $this->fpdf->Cell($anchoTotal, 3, 'Sistemas para empresas WebSoftAqp 927245347', 0, 1, 'C');
        };

        $convertirTextoPdf = function ($texto) {
            return iconv('UTF-8', 'ISO-8859-1//TRANSLIT', (string) $texto);
        };

        $imprimirCabeceraProductos();

        $to=0;
        $productosEnPagina = 0;
        $productosPorPagina = 7;
        foreach($datos as $data){ 
            if ($productosEnPagina >= $productosPorPagina) {
                $imprimirPie();
                $this->fpdf->AddPage();
                $productosEnPagina = 0;
                $productosPorPagina = 11;
                $this->fpdf->SetFont('Helvetica', '', 8);
            }

            $descripcionProducto = trim($convertirTextoPdf($data->des_pro));
            $lineasProducto = [];
            $lineaProducto = '';
            foreach (preg_split('/\s+/', $descripcionProducto, -1, PREG_SPLIT_NO_EMPTY) as $palabraProducto) {
                $lineaPropuesta = $lineaProducto === ''
                    ? $palabraProducto
                    : $lineaProducto . ' ' . $palabraProducto;

                if ($lineaProducto !== '' && $this->fpdf->GetStringWidth($lineaPropuesta) > $anchoProducto - 1) {
                    $lineasProducto[] = $lineaProducto;
                    $lineaProducto = $palabraProducto;
                } else {
                    $lineaProducto = $lineaPropuesta;
                }
            }
            if ($lineaProducto !== '') {
                $lineasProducto[] = $lineaProducto;
            }

            $this->fpdf->Cell($anchoProducto, 4, array_shift($lineasProducto), 0, 0, 'L');
            $this->fpdf->Cell($anchoCantidad, 4, $data->cant, 0, 0, 'C');
            $this->fpdf->Cell($anchoPrecio, 4, number_format(round($data->pre_pro, 2), 2, ',', ' '), 0, 0, 'C');
            $y= $data->cant * $data->pre_pro;
            $this->fpdf->Cell($anchoImporte, 4, number_format(round($y, 2), 2, ',', ' '), 0, 1, 'C');

            foreach ($lineasProducto as $lineaProducto) {
                $this->fpdf->Cell($anchoProducto, 3, $lineaProducto, 0, 1, 'L');
            }

            if (trim((string) ($data->comentario ?? '')) !== '') {
                $this->fpdf->SetFont('Helvetica', '', 7);
                $this->fpdf->Cell($anchoProducto, 3, '"' . trim($convertirTextoPdf($data->comentario)) . '"', 0, 1, 'L');
                $this->fpdf->SetFont('Helvetica', '', 8);
            }

            $this->fpdf->Ln(1);
            $to += $y;
            $productosEnPagina++;
        }

		$st = $to / 1.18;
        $igv = $st * 0.18;

        // SUMATORIO DE LOS PRODUCTOS Y EL IVA
        $espacioResumen = 22;
        $inicioPie = 140;
        if ($this->fpdf->GetY() + $espacioResumen > $inicioPie) {
            $imprimirPie();
            $this->fpdf->AddPage();
        }

        $this->fpdf->Cell($anchoTotal, 0, '', 'T');
        $this->fpdf->Ln(3);
        $this->fpdf->SetFont('Helvetica', 'B', 9);
        $this->fpdf->Cell(45, 5, 'SUBTOTAL', 0, 0, 'R');
        $this->fpdf->Cell(19, 5, number_format(round($st, 2), 2, ',', ' ') . ' S/', 0, 1, 'R');
        $this->fpdf->Cell(45, 5, 'IGV 18%', 0, 0, 'R');
        $this->fpdf->Cell(19, 5, number_format(round($igv, 2), 2, ',', ' ') . ' S/', 0, 1, 'R');
        $this->fpdf->Cell(45, 6, 'TOTAL', 0, 0, 'R');
        $this->fpdf->Cell(19, 6, number_format(round($to, 2), 2, ',', ' ') . ' S/', 0, 1, 'R');

        // PIE DE PAGINA
        $imprimirPie();
        
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
