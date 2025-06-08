@extends('layouts.app')
@section('titulo') Reporte Barra @endsection


@section('contenido')

<div class="row">
    <div class="col-md-12 col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <span class="fw-300"><i>Reporte</i></span>&nbsp;&nbsp;Barra 
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
                        <div class="col-md-3">
                            <div class="form-group row">
                                <label class="col-form-label col-12 col-lg-2 form-label text-lg-right">Barra:</label>&nbsp;
                                <div class="col-12 col-lg-8">
                                    <select id="barraselect" class="form-control text-uppercase" required>
                                        <option value="0">Todo</option>
                                        <option value="1">BARRA_1</option>
                                        <option value="2">BARRA_2</option>
                                        <option value="3">BARRA_3</option>
                                        <option value="4">BARRA_4</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mb-4">                           
                            <button onclick="actualizar_reporte_barra();" type="button" class="btn btn-primary btn-sm btn-block waves-effect waves-themed">ACTUALIZAR</button> 
                        </div>
                        <div class="col-md-2">
                            <div class="form-group row">
                                <label class="col-form-label col-12 col-lg-3 form-label text-lg-right">Total:</label>&nbsp; <h1><span id="ttotal" class="badge badge-info">0.00</span></h1>
                            </div>
                        </div>                       
                    </div>
                                  
                    <div class="table-responsive">
                        <table id="tableReportBarra" class="table table-bordered table-hover table-striped w-100">
                            <thead class="bg-primary-600">
                                <tr>
                                    <th>Cantidad</th>                                    
                                    <th>Descripcion</th>
                                    <th>Precio</th>
                                    <th>Subtotal</th>  
                                    <th>Cocina</th>                                    
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
<script src="https://cdn.datatables.net/plug-ins/1.10.19/api/sum().js"></script>
<script>  

$(function () { 
    $("#menu_reportes_pedidos").addClass("active open");
    $("#submenu_report_barra").addClass("active");  
    $('#fch').datepicker({
                    todayHighlight: true,
                    orientation: "bottom left",
                    templates: controls,
                    format: 'dd-mm-yyyy'
                });  

    var table = $('#tableReportBarra').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "reporte-barra?fch="+$("#fch").val()+"&barra="+$("#barraselect").val(),
        drawCallback: function () {
            var sum = $('#tableReportBarra').DataTable().column(3).data().sum();            
            $('#ttotal').html(parseFloat(sum).toFixed(2));
        },
        columns: [
            {data: 'cant'},
            {data: 'des_pro'}, 
            {data: 'pre_pro'},   
            {data: 'subtotal'},       
            {data: 'cocina'},
        ],
        dom: dom_buttons_table,
        buttons: [{
            extend: 'pdfHtml5',
            text: 'PDF',
            titleAttr: 'Generate PDF',
            className: 'btn-outline-danger btn-sm mr-1',
            exportOptions: {
                columns: [0,1,2,3,4]
            }
        },{
            extend: 'excelHtml5',
            text: 'Excel',
            titleAttr: 'Generate Excel',
            className: 'btn-outline-success btn-sm mr-1',
            exportOptions: {
                columns: [0,1,2,3,4]
            }
        }],
        lengthMenu: [ [50, 100, -1], [50, 100, "All"] ],
        language: espanol,
        ordering: false,
    });
    
});

function actualizar_reporte_barra(){

    $('#tableReportBarra').DataTable().ajax.url("reporte-barra?fch="+$("#fch").val()+"&barra="+$("#barraselect").val()).load();

}



</script>
@endpush
