@extends('layouts.app')
@section('titulo') Administracion - Mesas @endsection


@section('contenido')

<div class="row">
    <div class="col-md-12 col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <span class="fw-300"><i>Tabla</i></span>&nbsp;&nbsp;Mesas 
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>                    
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="row ml-1 mb-3">
                        <button onclick="OpenModal();" class="btn btn-primary" data-target='.default-example-modal-right'>
                            Agregar Nueva Mesa
                        </button>
                    </div>
                                  
                    <div class="table-responsive">
                        <table id="tableMesas" class="table table-bordered table-hover table-striped w-100">
                            <thead class="bg-primary-600">
                                <tr>
                                    <th>Cod</th>
                                    <th>Estado</th>
                                    <th>Zona</th>
                                    <th>Posicion</th>
                                    <th>Mozo</th>                                  
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
<div class="modal fade default-example-modal-right" id="DldModalMesa" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-right">
        <div class="modal-content">
            <form id="dlg_form">
                <div class="modal-header">
                    <h5 class="modal-title h4">FORMULARIO ADMINISTRACION MESAS</h5>
                    <button onclick="close_modal();" type="button" class="close" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">               
                    <div class="card mb-g">
                        <div class="card-body p-3">
                            <div class="form-row">
                                <input type="hidden" id="DldModalMesa_id">                                                              
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="DldModalMesa_zona">Zona<span class="text-danger">*</span></label>
                                    <input id="DldModalMesa_zona" type="text" class="form-control text-uppercase" required>
                                    <div id="error_DldModalMesa_zona" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="DldModalMesa_posicion">Posicion: <span class="text-danger">*</span></label>
                                    <select id="DldModalMesa_posicion" class="form-control" required>
                                        <option value="">Selecciona</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>                                        
                                    </select>                                    
                                    <div id="error_DldModalMesa_posicion" class="error_msg text-danger d-none"> </div>
                                </div>                                
                            </div>
                            
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
    $("#menu_administracion").addClass("active open");
    $("#submenu_mesas").addClass("active");   
    var table = $('#tableMesas').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "{{ route('vwadminmesas') }}",
        columns: [
            {data: 'id', name: 'id',className: 'text-center'},
            {data: 'desc_estado', name: 'desc_estado'},
            {data: 'zona', name: 'zona'},      
            {data: 'posicion', name: 'posicion', className: 'text-center'},
            {data: 'nombre', name: 'nombre', className: 'text-center'},      
            {data: 'action', name: 'action', searchable: false},
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

function OpenModal(){
    $("#DldModalMesa").modal('show');
}

function getdata(id){   
    MsgDlgLoadAjaxForm("dlg_form");
    $.ajax({        
        url: 'admin-mesas/'+id+'/edit',
        type: 'GET',
        success: function (data) {
            $("#DldModalMesa_id").val(data.id);
            $("#DldModalMesa_zona").val(data.zona);
            $("#DldModalMesa_posicion").val(data.posicion);                       
        },        
    }).done(function(data){
        setTimeout(function(){            
            if($("#DldModalMesa_id").val()==''){
                maquinge.notificaciones('No se pudo completar el formulario', 'OceanClub', 'error');
            }
            MsgDlgLoadAjaxFinish("dlg_form"); 
        }, 300);
    }).fail( function( jqXHR, textStatus, errorThrown ) {        
        
        var errors = error.responseJSON;                        
        if (error.status === 500) {
            maquinge.notificaciones(errors.msg, 'OceanClub', 'error');
        }
        MsgDlgLoadAjaxFinish("dlg_form"); 
    });
}

function guardar(){
    $('.error_msg').addClass('d-none').text('');    
    $.ajax({ 
        cache: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        url: 'admin-mesas',
        type: 'POST',
        data:{
            "_token": "{{ csrf_token() }}",
            id      : $("#DldModalMesa_id").val(),
            zona    : ($("#DldModalMesa_zona").val()).toUpperCase(),
            posicion : $("#DldModalMesa_posicion").val(),              
        }
    }).done(function (data) {
        $('#tableMesas').DataTable().ajax.url("{{ route('vwadminmesas') }}").load();
        maquinge.notificaciones(data.msg, 'OceanClub', 'success');
        close_modal();
    }).fail(function (data, jqXHR, textStatus) {
        var response = JSON.parse(data.responseText);            
        $.each( response.errors, function( key, value) {
            $('#error_DldModalMesa_' + key).removeClass('d-none').text(value);
        });
        initApp.playSound(asset+'smartadmin/dist/media/sound', 'voice_alert');
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
                    url: 'admin-mesas/'+id,
                    type: 'DELETE',
                    data:{
                        "_token": "{{ csrf_token() }}",
                        id      : id,           
                    },
                    success: function (data) {    
                        maquinge.notificaciones(data.msg, 'OceanClub', 'success');
                        $('#tableMesas').DataTable().ajax.url("{{ route('vwadminmesas') }}").load();
                    },
                    error: function (error) {  
                        var errors = error.responseJSON;                        
                        if (error.status === 500) {
                            maquinge.notificaciones(errors.msg, 'OceanClub', 'error');
                        }
                    }
                });
            }            
        }
    });
}

function close_modal(){  
    $("#DldModalMesa").modal('hide');
    $("#DldModalMesa_id").val('');
    $('.error_msg').addClass('d-none').text('');  
    $("#dlg_form")[0].reset();
}




</script>
@endpush
