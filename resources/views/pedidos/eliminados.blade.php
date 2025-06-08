@extends('layouts.app')
@section('titulo') Eliminados @endsection


@section('contenido')

<div class="row">
    <div class="col-md-12 col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <span class="fw-300"><i>Tabla</i></span>&nbsp;&nbsp;Eliminados 
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
                        <div class="col-md-2 mb-3">                           
                            <button onclick="actualizar();" type="button" class="btn btn-primary btn-sm btn-block waves-effect waves-themed">ACTUALIZAR</button> 
                        </div>                                              
                    </div>      
                    <div class="table-responsive">
                        <table id="tableEliminados" class="table table-bordered table-hover table-striped w-100">
                            <thead class="bg-primary-600">
                                <tr>
                                    <th>Cod</th>
                                    <th>Mozo</th>
                                    <th>Mesa</th>
                                    <th>Cant</th>
                                    <th>Desc. Producto</th>
                                    <th>Pre.Unid</th>
                                    <th>Pre.Total</th>
                                    <th>Fecha</th>
                                    <th>Razón</th>
                                    <th>Usuario</th>                                  
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
    $("#menu_pedidos").addClass("active open");
    $("#submenu_eliminados").addClass("active");
    $('#fch').datepicker({
                    todayHighlight: true,
                    orientation: "bottom left",
                    templates: controls,
                    format: 'dd-mm-yyyy'
                });     
    var table = $('#tableEliminados').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "tabla-eliminados?fch="+$("#fch").val(),
        columns: [
            {data: 'id', name: 'id',visible: false, searchable: false},
            {data: 'mozo', name: 'mozo'},
            {data: 'id_mesa', name: 'id_mesa'},
            {data: 'cant', name: 'cant'},
            {data: 'des_pro', name: 'des_pro'}, 
            {data: 'pre_pro', name: 'pre_pro'}, 
            {data: 'pre_tot', name: 'pre_tot'},       
            {data: 'fch_elim', name: 'fch_elim'},
            {data: 'razon', name: 'razon'},
            {data: 'user_elim', name: 'user_elim'},
        ],
        dom: dom_buttons_table,
        buttons: [{
            extend: 'pdfHtml5',
            text: 'PDF',
            titleAttr: 'Generate PDF',
            className: 'btn-outline-danger btn-sm mr-1',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8]
            }
        },{
            extend: 'excelHtml5',
            text: 'Excel',
            titleAttr: 'Generate Excel',
            className: 'btn-outline-success btn-sm mr-1',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8]
            }
        }],
        lengthMenu: [ [50, 100, -1], [50, 100, "All"] ],
        language: espanol,
        ordering: false,
    });
    
});

function actualizar(){
    $('#tableEliminados').DataTable().ajax.url("tabla-eliminados?fch="+$("#fch").val()).load();
}

</script>
@endpush
