@extends('layouts.app')
@section('titulo') Barra @endsection

@section('contenido')

<div class="row">
    <div class="col-md-12">
        <div id="panel-4" class="panel">
            <div class="panel-hdr">
                <h2> BARRA</h2>
                
                <div class="panel-toolbar">
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Minimizar"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Maximizar"></button>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="form-row ml-3">
                        <div class="col-md-2">                           
                            <div class="form-group row">
                                <label class="col-form-label col-12 col-lg-2 form-label text-lg-right mr-2">Fecha:</label>
                                <div class="col-12 col-lg-9">
                                    <input style="width: 100px" type="text" id="fchselect" class="form-control form-control-sm" value="@php echo date('d-m-Y'); @endphp"/>
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
                        <div class="col-md-2">                           
                            <button onclick="actualizar_tablas();" type="button" class="btn btn-primary btn-sm btn-block waves-effect waves-themed">ACTUALIZAR TABLA</button> 
                        </div>
                                             
                    </div>
                    <div class="tab-content p-3">
                        <div class="tab-pane fade show active" id="tab_justified-1" role="tabpanel">
                            <div class="row">
                                <div class="col-xl-12 col-md-12">                                                                                                                    
                                    <div class="table-responsive">
                                        <table id="tableBarra_1" class="table table-bordered table-hover table-striped w-100">
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
                                                            <table id="tableBarra_1_2" class="table table-bordered table-hover table-striped w-100">
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
    $("#submenu_barra").addClass("active");
    $('#fchselect').datepicker({
                    todayHighlight: true,
                    orientation: "bottom left",
                    templates: controls,
                    format: 'dd-mm-yyyy'
                }); 

    $.fn.dataTableExt.sErrMode = 'throw';    

    var table = $('#tableBarra_1').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "get_barra_1?fch="+$("#fchselect").val()+"&barra="+$("#barraselect").val(),
        columns: [
            {data: 'id_detalle', name: 'id_detalle',visible: false, searchable: false},
            {data: 'usuario', name: 'usuario'},
            {data: 'id_mesa', name: 'id_mesa', className: 'text-center'},
            {data: 'cant', name: 'cant', className: 'text-center'},
            {data: 'des_pro', name: 'des_pro'},
            {data: 'fechahora_detalle', name: 'fechahora_detalle',className: 'text-center',searchable: false},
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
                agrupar();
            }
        }], 
        lengthMenu: [ [50, 100, -1], [50, 100, "All"] ],     
        language: espanol,
        ordering: false,
    });
   

    var table2 = $('#tableBarra_1_2').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "get_barra_1_2?fch="+$("#fchselect").val()+"&barra="+$("#barraselect").val(),
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
        info:false,       
        language: espanol,
        ordering: false,
    });

    setInterval( function() {       
        table.ajax.reload();
        table2.ajax.reload();
    },30000);
    
});

function cambiar_est_barra(id_detalle){
    
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
                url: 'barra/'+id_detalle+'/edit',
                type: 'GET',          
            }).done(function(data){
                setTimeout(function(){
                    $('#tableBarra_1').DataTable().ajax.url("get_barra_1?fch="+$("#fchselect").val()+"&barra="+$("#barraselect").val()).load();
                    $('#tableBarra_1_2').DataTable().ajax.url("get_barra_1_2?fch="+$("#fchselect").val()+"&barra="+$("#barraselect").val()).load();      
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

function actualizar_tablas(){
    $('#tableBarra_1').DataTable().ajax.url("get_barra_1?fch="+$("#fchselect").val()+"&barra="+$("#barraselect").val()).load();
    $('#tableBarra_1_2').DataTable().ajax.url("get_barra_1_2?fch="+$("#fchselect").val()+"&barra="+$("#barraselect").val()).load();
  
}

function agrupar(){
    $('#tableBarra_1').DataTable().ajax.url("agrupar_barra_1?fch="+$("#fchselect").val()+"&barra="+$("#barraselect").val()).load();
}

</script>
@endpush