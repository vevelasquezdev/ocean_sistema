@extends('layouts.app')
@section('titulo') Reporte Totales Barra @endsection


@section('contenido')

<div class="row">
    <div class="col-md-12 col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <span class="fw-300"><i>Reporte</i></span>&nbsp;&nbsp;Totales Barra 
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>                    
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="form-row">
                        <div class="col-md-2 mb-4">                           
                            <div class="form-group row">
                                <label class="col-form-label col-12 col-lg-2 form-label text-lg-right mr-2">Fecha:</label>
                                <div class="col-12 col-lg-9">
                                    <input style="width: 100px" type="text" id="fch" class="form-control form-control-sm" value="@php echo date('d-m-Y'); @endphp"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mb-4">                           
                            <button onclick="actualizar_tabla();" type="button" class="btn btn-primary btn-sm btn-block waves-effect waves-themed">ACTUALIZAR</button> 
                        </div>                                             
                    </div>
                                  
                    <div class="table-responsive">
                        <table id="tablaTotalesBarra" class="table table-bordered table-hover table-striped w-100">
                            <thead class="bg-primary-600">
                                <tr>
                                    <th>CodProd</th>
                                    <th>Descripcion prod.</th>
                                    <th>Principal</th>                         
                                    <th>Barra 1</th>
                                    <th>Barra 2</th>  
                                    <th>Barra 3</th>
                                    <th>Barra 4</th> 
                                    <th>Total</th>                                  
                                </tr>
                            </thead>                    
                        </table>                                             
                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>  

$(function () { 
    $("#menu_reportes_almacen").addClass("active open");
    $("#submenu_reporte_totales_barra").addClass("active");  
    $('#fch').datepicker({
                    todayHighlight: true,
                    orientation: "bottom left",
                    templates: controls,
                    format: 'dd-mm-yyyy'
                });  

    var table = $('#tablaTotalesBarra').DataTable({
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "rep-totales-barra?fch="+$("#fch").val(),        
        columns: [
            {data: 'id_prod',visible: false, searchable: false},
            {data: 'des_pro'},
            {data: 'b0_stock',className: 'text-center'},
            {data: 'b1_stock',className: 'text-center'},
            {data: 'b2_stock',className: 'text-center'},
            {data: 'b3_stock',className: 'text-center'},
            {data: 'b4_stock',className: 'text-center'},   
            {data: 'total',className: 'text-center'},
        ],
        dom: dom_buttons_table,
        buttons: [{
            extend: 'pdfHtml5',
            text: 'PDF',
            titleAttr: 'Generate PDF',
            className: 'btn-outline-danger btn-sm mr-1',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7]
            }
        },{
            extend: 'excelHtml5',
            text: 'Excel',
            titleAttr: 'Generate Excel',
            className: 'btn-outline-success btn-sm mr-1',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7]
            }
        }],
        lengthMenu: [ [50, 100, -1], [50, 100, "All"] ],
        language: espanol,
        ordering: false,
    });
    setTimeout(function(){
        if (table.rows().count()==0) {
            maquinge.notificaciones('Es necesario realizar Recarga de Inventarios.<br>* Ir a Menu Productos.', 'Sistema', 'error');
        }
    }, 500);
});

function actualizar_tabla(){

    $('#tablaTotalesBarra').DataTable().ajax.url("rep-totales-barra?fch="+$("#fch").val()).load();

}



</script>
@endpush
