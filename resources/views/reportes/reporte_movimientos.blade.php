@extends('layouts.app')
@section('titulo') Reporte Movimientos @endsection


@section('contenido')

<div class="row">
    <div class="col-md-12 col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <span class="fw-300"><i>Reporte</i></span>&nbsp;&nbsp;Movimientos Caja
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
                                <label class="col-form-label col-12 col-lg-2 form-label text-lg-right mr-2">Desde:</label>
                                <div class="col-12 col-lg-9">
                                    <input style="width: 100px" type="text" id="fch" class="form-control form-control-sm" value="@php echo date('d-m-Y'); @endphp"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mb-4">
                            <div class="form-group row">
                                <label class="col-form-label col-12 col-lg-2 form-label text-lg-right mr-2">Hasta:</label>
                                <div class="col-12 col-lg-9">
                                    <input style="width: 100px" type="text" id="fch_fin" class="form-control form-control-sm" value="@php echo date('d-m-Y'); @endphp"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group row">
                                <label class="col-form-label col-12 col-lg-2 form-label text-lg-right">Caja:</label>&nbsp;
                                <div class="col-12 col-lg-9">
                                    <select id="txt_caja_gral" class="form-control text-uppercase" required>
                                        <option value="0">Todo</option>
                                        <option value="1">CAJA_1</option>
                                        <option value="2">CAJA_2</option>
                                        <option value="3">CAJA_3</option>
                                    </select>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group row">
                                <div class="col-12 col-lg-9">
                                    <select id="txt_tipo" class="form-control text-uppercase" required>
                                        <option value="0">Todo</option>
                                        <option value="1">INGRESOS</option>
                                        <option value="2">EGRESOS</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mb-3">                           
                            <button onclick="actualizar_reporte_movimientos();" type="button" class="btn btn-primary btn-sm btn-block waves-effect waves-themed">ACTUALIZAR</button> 
                        </div> 
                        <div class="col-md-2">
                            <div class="form-group row">
                                <label class="col-form-label col-12 col-lg-3 form-label text-lg-right">Total:</label>&nbsp; <h1><span id="ttotal_caja" class="badge badge-info">0.00</span></h1>
                            </div>
                        </div>                       
                    </div>
                                  
                    <div class="table-responsive">
                        <table id="tableReportMovimientos" class="table table-bordered table-hover table-striped w-100">
                            <thead class="bg-primary-600">
                                <tr>
                                    <th>ID</th>
                                    <th>ESTADO</th>
                                    <th>CAJA</th>
                                    <th>FORMA PAGO</th>               
                                    <th>RAZON SOCIAL</th>
                                    <th style="min-width: 200px">DESCRIPCION</th>
                                    <th>MONTO</th>
                                    <th style="min-width: 130px">FECHA</th>                    
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
    $("#menu_reportes_caja").addClass("active open");
    $("#submenu_report_movimientos").addClass("active");  

    $('#fch, #fch_fin').datepicker({
                    todayHighlight: true,
                    orientation: "bottom left",
                    templates: controls,
                    format: 'dd-mm-yyyy'
                });

    var table = $('#tableReportMovimientos').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "reporte-movimientos?fch="+$("#fch").val()+"&fch_fin="+$("#fch_fin").val()+"&caja="+$("#txt_caja_gral").val()+"&tipo="+$("#txt_tipo").val(),
        drawCallback: function () {
            var sum = $('#tableReportMovimientos').DataTable().column(6).data().sum();            
            $('#ttotal_caja').html(parseFloat(sum).toFixed(2));
        },
        columns: [
            {data: 'id'},
            {data: 'estado'},
            {data: 'caja'},
            {data: 'desc_forma_pago'},
            {data: 'razon_social'},
            {data: 'descripcion'},
            {data: 'monto'},
            {data: 'fch_emi'}
        ],
        columnDefs: [{targets: 6,
            render: function ( data, type, row ) {
                
                if (data < 0) {
                    return '<h5 class="text-danger my-auto" style="font-weight:bold;">'+data+'</h5>';
                }else{
                    return '<h5 class="text-success my-auto" style="font-weight:bold;">+'+data+'</h5>';
                }
                
            }
        }],
        dom: dom_buttons_table,
        buttons: [{
            text: 'Reporte PDF',
            className: 'btn-outline-danger btn-sm mr-1',
            action: function ( e, dt, node, config ) {
                reporte_movimientos_pdf();
            }
        }
        ,{
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
    
});

function actualizar_reporte_movimientos(){

    $('#tableReportMovimientos').DataTable().ajax.url("reporte-movimientos?fch="+$("#fch").val()+"&fch_fin="+$("#fch_fin").val()+"&caja="+$("#txt_caja_gral").val()+"&tipo="+$("#txt_tipo").val()).load();

}

function reporte_movimientos_pdf(){
    window.open('reporte-movimientos-pdf?fch='+$("#fch").val()+"&fch_fin="+$("#fch_fin").val()+"&caja="+$("#txt_caja_gral").val());
}


</script>
@endpush
