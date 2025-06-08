@extends('layouts.app')
@section('titulo') Almacen-Productos @endsection


@section('contenido')
<style>

</style>
<div class="row">
    <div class="col-md-12 col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Almacen - Productos 
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
                            <button onclick="OpenModal();" type="button" class="btn btn-primary waves-effect waves-themed">Nuevo Producto</button>
                        </div>
                        <div class="col-md-4 mb-4">                           
                            <button onclick="recuento_barra();" type="button" class="btn btn-info waves-effect waves-themed">Recuento Barra</button>
                            <button onclick="recuento_cocina();" type="button" class="btn btn-info waves-effect waves-themed">Recuento Cocina</button>  
                        </div>
                        <div class="col-md-2 mb-4">                           
                            <button onclick="recargar_inventarios();" type="button" class="btn btn-success waves-effect waves-themed">Recargar Inventarios</button>
                            
                        </div>
                    </div>
                                  
                    <div class="table-responsive">
                        <table id="tablaProductos" class="table table-bordered table-hover table-striped w-100">
                            <thead class="bg-primary-600">
                                <tr>                                    
                                    <th>CodProd</th>
                                    <th>Descripción Producto</th>
                                    <th>Unidad</th>
                                    <th>Existencia</th>
                                    <th>Lugar</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>                    
                        </table>                                             
                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>

<div class="modal fade default-example-modal" id="DldModalProductos" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="dlg_form">
                <div class="modal-header">
                    <h5 class="modal-title h4">.: Productos :.</h5>
                    <button onclick="close_modal();" type="button" class="close" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row pl-3 pr-3">
                        <input type="hidden" id="DldModalProductos_id">                       
                        <div class="col-md-12 mb-3">                           
                            <label class="form-label" for="DldModalProductos_des_pro">Producto:<span class="text-danger">*</span></label>
                            <input id="DldModalProductos_des_pro" type="text" class="typeahead form-control jquery_field text-uppercase" >
                            <div id="error_DldModalProductos_des_pro" class="error_msg text-danger d-none"> </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="DldModalProductos_unidad">Unidad:<span class="text-danger">*</span></label>
                            <select id="DldModalProductos_unidad" class="form-control jquery_field text-uppercase">
                                <option value="">Selecciona</option>
                                <option value="Unid.">Unid.</option>
                                <option value="Kilogramo">Kilogramo</option>
                                <option value="Litro">Litro</option>
                            </select>
                            <div id="error_DldModalProductos_unidad" class="error_msg text-danger d-none"> </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="DldModalProductos_existencia">Existencia:<span class="text-danger">*</span></label>
                            <input id="DldModalProductos_existencia" type="number" min="1" value="0" class="form-control jquery_field text-uppercase" readonly>
                            <div id="error_DldModalProductos_existencia" class="error_msg text-danger d-none"> </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="DldModalProductos_lugar">Lugar:<span class="text-danger">*</span></label>
                            <select id="DldModalProductos_lugar" class="form-control jquery_field text-uppercase">
                                <option value="">Selecciona</option>
                                <option value="BARRA">BARRA</option>
                                <option value="COCINA">COCINA</option>                                
                            </select>
                            <div id="error_DldModalProductos_lugar" class="error_msg text-danger d-none"> </div>
                        </div>                                                               
                    </div>
                </div>
                <div class="modal-footer">
                    <button onclick="close_modal();" type="button" class="btn btn-secondary">Cerrar</button>
                    <button onclick="guardar();" type="button" class="btn btn-primary">Guardar</button>
                </div>
            </form>            
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>  

$(function () { 
    $("#menu_productos").addClass("active");
    $.fn.dataTable.ext.errMode = 'throw';
    var table = $('#tablaProductos').DataTable({
        cache: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "alm-productos",
        columns: [
            {data: 'id'},
            {data: 'des_pro'},
            {data: 'unidad'},
            {data: 'existencia'},
            {data: 'lugar'},
            {data: 'action', searchable: false},
        ],
        dom: dom_buttons_table,
        buttons: [{
            extend: 'pdfHtml5',
            text: 'PDF',
            titleAttr: 'Generate PDF',
            className: 'btn-outline-danger btn-sm mr-1',
            exportOptions: {
                columns: [0,1,2,3]
            }
        },{
            extend: 'excelHtml5',
            text: 'Excel',
            titleAttr: 'Generate Excel',
            className: 'btn-outline-success btn-sm mr-1',
            exportOptions: {
                columns: [0,1,2,3]
            }
        }],        
        lengthMenu: [ [50, 100, -1], [50, 100, "All"] ],
        language: espanol,
        ordering: false,
    });
    
});


function OpenModal(){    
    $("#DldModalProductos").modal('show');
}

function close_modal(){  
    $("#DldModalProductos").modal('hide');    
    $('.error_msg').addClass('d-none').text('');  
    $("#dlg_form")[0].reset();
    $("#DldModalProductos_id").val('');
}


function guardar(){
    $('.error_msg').addClass('d-none').text('');  
    MsgDlgLoadAjaxForm("dlg_form");  
    $.ajax({ 
        cache: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        url: 'alm-productos',
        type: 'POST',
        data:{
            "_token"    : "{{ csrf_token() }}",
            id          : $("#DldModalProductos_id").val(),
            des_pro     : ($("#DldModalProductos_des_pro").val()).toUpperCase(),
            unidad      : $("#DldModalProductos_unidad").val(),
            existencia  : $("#DldModalProductos_existencia").val(),
            lugar       : $("#DldModalProductos_lugar").val()
        }
    }).done(function (data) {
        if(data.msg==0){
            maquinge.notificaciones('Es necesario realizar Recarga de Inventarios antes de ingresar un nuevo producto.', 'Sistema', 'error');
        }else{
            $('#tablaProductos').DataTable().ajax.url("alm-productos").load();
            maquinge.notificaciones(data.msg, 'Sistema', 'success');
            close_modal();
        }
        setTimeout(function(){    
            MsgDlgLoadAjaxFinish("dlg_form");
        }, 1000);
        
    }).fail(function (data, jqXHR, textStatus) {
        var response = JSON.parse(data.responseText);            
        $.each( response.errors, function( key, value) {
            $('#error_DldModalProductos_' + key).removeClass('d-none').text(value);
        });
                            
        if (data.status === 500) {
            maquinge.notificaciones(textStatus+" <br>* Base de Datos", 'Sistema', 'error');
        }
        
        initApp.playSound(asset+'smartadmin/dist/media/sound', 'voice_alert');
        MsgDlgLoadAjaxFinish("dlg_form");
    });
    
}

function getdata(id){   
    MsgDlgLoadAjaxForm("dlg_form");
    $.ajax({        
        url: 'alm-productos/'+id+'/edit',
        type: 'GET',              
    }).done(function(data){
        $("#DldModalProductos_id").val(data[0].id);
        $("#DldModalProductos_des_pro").val(data[0].des_pro);
        $("#DldModalProductos_unidad").val(data[0].unidad);
        $("#DldModalProductos_existencia").val(data[0].existencia);
        $("#DldModalProductos_lugar").val(data[0].lugar);
        setTimeout(function(){            
            if($("#DldModalProductos_id").val()==''){
                maquinge.notificaciones('No se pudo completar el formulario', 'Sistema', 'error');
            }
            MsgDlgLoadAjaxFinish("dlg_form"); 
        }, 1000);
    }).fail( function( jqXHR, textStatus, errorThrown ) {        
        maquinge.notificaciones(textStatus, 'Sistema', 'error');
        MsgDlgLoadAjaxFinish("dlg_form"); 
    });
}

function del(id){ 
    initApp.playSound(asset+'smartadmin/dist/media/sound', 'bigbox'); 
    bootbox.confirm({
        title: "<i class='fal fa-times-circle text-danger mr-2'></i> ¿ Está seguro que desea eliminar el registro ?",
        message: "<span><strong>Advertencia:</strong> Esta acción no se puede deshacer!</span>",
        centerVertical: true,
        swapButtonOrder: true,
        buttons: {
            confirm: {
                label: 'Aceptar',
                className: 'btn-danger shadow-0'                
            },
            cancel: {
                label: 'Cancelar',
                className: 'btn-default'
            }
        },
        className: "modal-alert",
        closeButton: false,        
        callback: function (result) {
            if(result){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                    url: 'alm-productos/'+id,
                    type: 'DELETE',
                    data:{
                        "_token": "{{ csrf_token() }}",
                        id      : id,           
                    },
                    success: function (data) {    
                        maquinge.notificaciones(data.msg, 'Sistema', 'success');
                        $('#tablaProductos').DataTable().ajax.url("alm-productos").load();
                    },
                    error: function (error) {  
                        var errors = error.responseJSON;                        
                        if (error.status === 500) {
                            maquinge.notificaciones(errors.msg, 'Sistema', 'error');
                        }
                    }
                });
            }            
        }
    });
}

function recuento_barra(){
    $.ajax({   
        cache: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },     
        url: 'productos-recuento-barra',
        type: 'GET',              
    }).done(function(data){
        maquinge.notificaciones(data.msg, 'Sistema', 'success');
        $('#tablaProductos').DataTable().ajax.url("alm-productos").load();
    }).fail( function( jqXHR, textStatus, errorThrown ) {        
        maquinge.notificaciones(textStatus, 'Sistema', 'error');
    });
}

function recuento_cocina(){
    $.ajax({ 
        cache: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },       
        url: 'productos-recuento-cocina',
        type: 'GET',              
    }).done(function(data){
        maquinge.notificaciones(data.msg, 'Sistema', 'success');
        $('#tablaProductos').DataTable().ajax.url("alm-productos").load();
    }).fail( function( jqXHR, textStatus, errorThrown ) {        
        maquinge.notificaciones(textStatus, 'Sistema', 'error');
    });
}

function recargar_inventarios(){
    $.ajax({  
        cache: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },      
        url: 'recargar-inventarios',
        type: 'GET',              
    }).done(function(data){
        maquinge.notificaciones(data.msg, 'Sistema', 'success');

    }).fail(function(data, jqXHR, textStatus, errorThrown){ 
        maquinge.notificaciones(textStatus, 'Sistema', 'error');        
    });
}


</script>
@endpush
