@extends('layouts.app')
@section('titulo') Cocina @endsection

@section('contenido')

<div class="row">
    <div class="col-md-12 col-xl-12">
        <div id="panel-4" class="panel">
            <div class="panel-hdr">
                <h2>
                    PEDIDOS <span class="fw-300"><i>COCINA</i></span>
                </h2>
                
                
                <div class="panel-toolbar">
                    <input style="width: 100px" type="text" id="fchselect" class="form-control form-control-sm" value="@php echo date('d-m-Y'); @endphp"/> &nbsp;&nbsp;&nbsp;
                    <button onclick="actualizar_tablas();" type="button" class="btn btn-primary btn-sm btn-block waves-effect waves-themed">ACTUALIZAR TABLAS</button> 
                    <button style="width: 35px;" class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Minimizar"></button>
                    <button style="width: 35px;" class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Maximizar"></button>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">                    
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab_justified-1" role="tab">COCINA 1</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab_justified-2" role="tab">COCINA 2</a></li>
                    </ul>
                    <div class="tab-content p-3">
                        <div class="tab-pane fade show active" id="tab_justified-1" role="tabpanel">
                            <div class="row">
                                <div class="col-xl-12 col-md-12">                                                                                                                      
                                    <div class="table-responsive">
                                        <table id="tableCocina1_1" class="table table-bordered table-hover table-striped w-100">
                                            <thead class="bg-primary-600">
                                                <tr>
                                                    <th>id</th>
                                                    <th>Mozo</th>
                                                    <th>Mesa</th>
                                                    <th>Cant.</th>
                                                    <th style="min-width: 230px">Descripción</th>
                                                    <th>Hora</th>
                                                    <th>Estado</th>
                                                    <th style="min-width: 200px">Comentario</th>
                                                    <th>...</th>                                  
                                                </tr>
                                            </thead>                    
                                        </table>                                             
                                    </div>                                          
                                </div>
                                <div class="col-md-12 col-xl-12 mt-3">
                                    <div class="accordion accordion-outline" id="js_demo_accordion-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <a href="javascript:void(0);" class="card-title collapsed pt-2 pb-2" data-toggle="collapse" data-target="#js_demo_accordion-3b" aria-expanded="false">
                                                    &nbsp;&nbsp;PEDIDOS LISTOS
                                                    <span class="ml-auto">
                                                        <span class="collapsed-reveal">
                                                            <i class="fal fa-minus fs-xl"></i>
                                                        </span>
                                                        <span class="collapsed-hidden">
                                                            <i class="fal fa-plus fs-xl"></i>
                                                        </span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div id="js_demo_accordion-3b" class="collapse" data-parent="#js_demo_accordion-3">
                                                <div class="card-body">
                                                    <div class="col-xl-12">                                                                                                                                        
                                                        <div class="table-responsive">
                                                            <table id="tableCocina1_2" class="table table-bordered table-hover table-striped w-100">
                                                                <thead class="bg-primary-600">
                                                                    <tr>
                                                                        <th>id</th>
                                                                        <th>Mozo</th>
                                                                        <th>Mesa</th>
                                                                        <th>Cant.</th>
                                                                        <th style="min-width: 150px">Descripción</th>
                                                                        <th>Hora</th>
                                                                        <th>Estado</th>
                                                                        <th>Tiempo</th>                                    
                                                                    </tr>
                                                                </thead>                    
                                                            </table>                                              
                                                        </div>                                    
                                                    </div>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab_justified-2" role="tabpanel">
                            <div class="row">
                                <div class="col-xl-12 col-md-12">
                                    <div class="table-responsive">
                                        <table id="tableCocina2_1" class="table table-bordered table-hover table-striped w-100">
                                            <thead class="bg-primary-600">
                                                <tr>
                                                    <th>id</th>
                                                    <th>Mozo</th>
                                                    <th>Mesa</th>
                                                    <th>Cant.</th>
                                                    <th style="min-width: 230px">Descripción</th>
                                                    <th>Hora</th>
                                                    <th>Estado</th>
                                                    <th style="min-width: 200px">Comentario</th>
                                                    <th>...</th>                                  
                                                </tr>
                                            </thead>                    
                                        </table>                                             
                                    </div>                             
                                </div>
                                <div class="col-md-12 col-xl-12 mt-3">
                                    <div class="accordion accordion-outline">
                                        <div class="card">
                                            <div class="card-header">
                                                <a href="javascript:void(0);" class="card-title collapsed pt-2 pb-2" data-toggle="collapse" data-target="#js_demo_accordion-3b" aria-expanded="false">
                                                    &nbsp;&nbsp;PEDIDOS LISTOS
                                                    <span class="ml-auto">
                                                        <span class="collapsed-reveal">
                                                            <i class="fal fa-minus fs-xl"></i>
                                                        </span>
                                                        <span class="collapsed-hidden">
                                                            <i class="fal fa-plus fs-xl"></i>
                                                        </span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div id="js_demo_accordion-3b" class="collapse" data-parent="#js_demo_accordion-3">
                                                <div class="card-body">
                                                    <div class="col-xl-12">                                                                                                                                        
                                                        <div class="table-responsive">
                                                            <table id="tableCocina2_2" class="table table-bordered table-hover table-striped w-100">
                                                                <thead class="bg-primary-600">
                                                                    <tr>
                                                                        <th>id</th>
                                                                        <th>Mozo</th>
                                                                        <th>Mesa</th>
                                                                        <th>Cant.</th>
                                                                        <th style="min-width: 150px">Descripción</th>
                                                                        <th>Hora</th>
                                                                        <th>Estado</th>
                                                                        <th>Tiempo</th>                                    
                                                                    </tr>
                                                                </thead>                    
                                                            </table>                                              
                                                        </div>                                    
                                                    </div>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>                       
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
    $("#submenu_cocina").addClass("active");  
    $('#fchselect').datepicker({
                    todayHighlight: true,
                    orientation: "bottom left",
                    templates: controls,
                    format: 'dd-mm-yyyy'
                }); 
    $.fn.dataTableExt.sErrMode = 'throw';

    var table11 = $('#tableCocina1_1').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "get_cocina_1?fch="+$("#fchselect").val(),
        columns: [
            {data: 'id_detalle', name: 'id_detalle',visible: false, searchable: false},
            {data: 'usuario', name: 'usuario'},
            {data: 'id_mesa', name: 'id_mesa', className: 'text-center'},
            {data: 'cant', name: 'cant', className: 'text-center'},
            {data: 'des_pro', name: 'des_pro'},
            {data: 'fechahora_detalle', name: 'fechahora_detalle',className: 'text-center'},
            {data: 'est_detalle', name: 'est_detalle',className: 'text-center'},
            {data: 'comentario', name: 'comentario'},
            {data: 'action', name: 'action',className: 'text-center', orderable: false, searchable: false},
        ],
        columnDefs: [{targets: 3,
            render: function ( data, type, row ) {
                return '<h5 class="color-fusion-900 my-auto" style="font-weight:bold;">'+data+'</h5>';
            }
        }],
        dom: dom_buttons_table,
        buttons: [{
            extend: 'pdfHtml5',
            text: 'PDF',
            titleAttr: 'Generate PDF',
            className: 'btn-outline-danger btn-sm mr-1',
            exportOptions: {
                columns: [1,2,3,4,5,6,7]
            }
        },{
            extend: 'excelHtml5',
            text: 'EXCEL',
            titleAttr: 'Generate Excel',
            className: 'btn-outline-success btn-sm mr-1',
            exportOptions: {
                columns: [1,2,3,4,5,6,7]
            }
        },{
            text: 'AGRUPAR',
            className: 'btn-outline-info btn-sm mr-1',
            action: function ( e, dt, node, config ) {
                agrupar1();
            }
        }],
        lengthMenu: [ [50, 100, -1], [50, 100, "All"] ],        
        language: espanol,
        ordering: false,       
    });
    
    var table12 = $('#tableCocina1_2').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "get_cocina_1_2?fch="+$("#fchselect").val(),        
        columns: [
            {data: 'id_detalle', name: 'id_detalle',visible: false, searchable: false},
            {data: 'usuario', name: 'usuario'},
            {data: 'id_mesa', name: 'id_mesa', className: 'text-center'},
            {data: 'cant', name: 'cant', className: 'text-center'},
            {data: 'des_pro', name: 'des_pro'},
            {data: 'fechahora_detalle', name: 'fechahora_detalle',className: 'text-center',visible: false},
            {data: 'est_detalle', name: 'est_detalle',className: 'text-center'},
            {data: 'tiempo_preparacion', name: 'tiempo_preparacion', orderable: false, searchable: false},
        ],
        dom: dom_buttons_table,
        buttons: [{
            extend: 'pdfHtml5',
            text: 'PDF',
            titleAttr: 'Generate PDF',
            className: 'btn-outline-danger btn-sm mr-1',
            exportOptions: {
                columns: [1,2,3,4,5,6,7]
            }
        },{
            extend: 'excelHtml5',
            text: 'Excel',
            titleAttr: 'Generate Excel',
            className: 'btn-outline-success btn-sm mr-1',
            exportOptions: {
                columns: [1,2,3,4,5,6,7]
            }
        }], 
        lengthMenu: [ [50, 100, -1], [50, 100, "All"] ],
        language: espanol,
        ordering: false,
    });

    var table21 = $('#tableCocina2_1').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "get_cocina_2?fch="+$("#fchselect").val(),
        columns: [
            {data: 'id_detalle', name: 'id_detalle',visible: false, searchable: false},
            {data: 'usuario', name: 'usuario', className: 'text-center'},
            {data: 'id_mesa', name: 'id_mesa', className: 'text-center'},
            {data: 'cant', name: 'cant', className: 'text-center'},
            {data: 'des_pro', name: 'des_pro'},
            {data: 'fechahora_detalle', name: 'fechahora_detalle',className: 'text-center'},
            {data: 'est_detalle', name: 'est_detalle',className: 'text-center'},
            {data: 'comentario', name: 'comentario'},
            {data: 'action', name: 'action',className: 'text-center', orderable: false, searchable: false},
        ],
        columnDefs: [{targets: 3,
            render: function ( data, type, row ) {
                return '<h5 class="color-fusion-900 my-auto" style="font-weight:bold;">'+data+'</h5>';
            }
        }],
        dom: dom_buttons_table,
        buttons: [{
            extend: 'pdfHtml5',
            text: 'PDF',
            titleAttr: 'Generate PDF',
            className: 'btn-outline-danger btn-sm mr-1',
            exportOptions: {
                columns: [1,2,3,4,5,6,7]
            }
        },{
            extend: 'excelHtml5',
            text: 'Excel',
            titleAttr: 'Generate Excel',
            className: 'btn-outline-success btn-sm mr-1',
            exportOptions: {
                columns: [1,2,3,4,5,6,7]
            }
        },{
            text: 'AGRUPAR',
            className: 'btn-outline-info btn-sm mr-1',
            action: function ( e, dt, node, config ) {
                agrupar2('tableCocina2_1');
            }
        }],
        lengthMenu: [ [50, 100, -1], [50, 100, "All"] ],         
        language: espanol,
        ordering: false,
    });

    var table22 = $('#tableCocina2_2').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "get_cocina_2_2?fch="+$("#fchselect").val(),        
        columns: [
            {data: 'id_detalle', name: 'id_detalle',visible: false, searchable: false},
            {data: 'usuario', name: 'usuario', className: 'text-center'},
            {data: 'id_mesa', name: 'id_mesa', className: 'text-center'},
            {data: 'cant', name: 'cant', className: 'text-center'},
            {data: 'des_pro', name: 'des_pro'},
            {data: 'fechahora_detalle', name: 'fechahora_detalle',className: 'text-center',visible: false},
            {data: 'est_detalle', name: 'est_detalle',className: 'text-center'},
            {data: 'tiempo_preparacion', name: 'tiempo_preparacion', orderable: false, searchable: false},
        ], 
        dom: dom_buttons_table,
        buttons: [{
            extend: 'pdfHtml5',
            text: 'PDF',
            titleAttr: 'Generate PDF',
            className: 'btn-outline-danger btn-sm mr-1',
            exportOptions: {
                columns: [1,2,3,4,5,6,7]
            }
        },{
            extend: 'excelHtml5',
            text: 'Excel',
            titleAttr: 'Generate Excel',
            className: 'btn-outline-success btn-sm mr-1',
            exportOptions: {
                columns: [1,2,3,4,5,6,7]
            }
        }],       
        lengthMenu: [ [50, 100, -1], [50, 100, "All"] ],   
        language: espanol,
        ordering: false,
    });

    setInterval( function() {       
        table11.ajax.reload();
        table12.ajax.reload();
        table21.ajax.reload();
        table22.ajax.reload();
    },30000);
});

function agrupar1(){
    $('#tableCocina1_1').DataTable().ajax.url("agrupar_cocina_1?fch="+$("#fchselect").val()).load();
}

function agrupar2(){
    $('#tableCocina2_1').DataTable().ajax.url("agrupar_cocina_2?fch="+$("#fchselect").val()).load();
}

function actualizar_tablas(){
    $('#tableCocina1_1').DataTable().ajax.url("get_cocina_1?fch="+$("#fchselect").val()).load();
    $('#tableCocina1_2').DataTable().ajax.url("get_cocina_1_2?fch="+$("#fchselect").val()).load();
    $('#tableCocina2_1').DataTable().ajax.url("get_cocina_2?fch="+$("#fchselect").val()).load();
    $('#tableCocina2_2').DataTable().ajax.url("get_cocina_2_2?fch="+$("#fchselect").val()).load();    
}

function cambiar_est_preparado_cocina_1(id_detalle){

    Swal.fire({
        title: "¿ Está seguro que desea enviar el pedido.  ?",
        text: "Esta acción no se puede deshacer!",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Aceptar"
    }).then(function(result){
        if (result.value){
            MsgDlgLoadAjaxForm("panel-4");
            $.ajax({        
                url: 'cocina/'+id_detalle+'/edit',
                type: 'GET',          
            }).done(function(data){
                setTimeout(function(){
                    $('#tableCocina1_1').DataTable().ajax.url("get_cocina_1?fch="+$("#fchselect").val()).load();
                    $('#tableCocina1_2').DataTable().ajax.url("get_cocina_1_2?fch="+$("#fchselect").val()).load();           
                    MsgDlgLoadAjaxFinish("panel-4"); 
                }, 300);
                
            }).fail( function(error, jqXHR, textStatus, errorThrown ) {        
                var errors = error.responseJSON;                        
                if (error.status === 500) {
                    maquinge.notificaciones(errors.msg, 'Sistema', 'error');
                }
                MsgDlgLoadAjaxFinish("panel-4"); 
            });
        }
    });
   

   
}

function cambiar_est_preparado_cocina_2(id_detalle){
    Swal.fire({
        title: "¿ Está seguro que desea enviar el pedido.  ?",
        text: "Esta acción no se puede deshacer!",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Aceptar"
    }).then(function(result){
        if (result.value){
            MsgDlgLoadAjaxForm("panel-4");
                $.ajax({        
                    url: 'cocina/'+id_detalle+'/edit',
                    type: 'GET',          
                }).done(function(data){
                    setTimeout(function(){            
                        $('#tableCocina2_1').DataTable().ajax.url("get_cocina_2?fch="+$("#fchselect").val()).load();
                        $('#tableCocina2_2').DataTable().ajax.url("get_cocina_2_2?fch="+$("#fchselect").val()).load();
                        MsgDlgLoadAjaxFinish("panel-4"); 
                    }, 300);
                    //maquinge.notificaciones(data.msg, 'Sistema', 'success');
                }).fail( function(error, jqXHR, textStatus, errorThrown ) {        
                    var errors = error.responseJSON;                        
                    if (error.status === 500) {
                        maquinge.notificaciones(errors.msg, 'Sistema', 'error');
                    }
                    MsgDlgLoadAjaxFinish("panel-4"); 
                });
        }
    });
}
</script>
@endpush