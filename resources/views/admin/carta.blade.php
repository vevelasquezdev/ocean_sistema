@extends('layouts.app')
@section('titulo') Carta @endsection


@section('contenido')

<div class="row">
    <div class="col-md-12 col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <span class="fw-300"><i>Tabla</i></span>&nbsp;&nbsp;Carta 
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
                            Agregar Nuevo
                        </button>
                    </div>
                                  
                    <div class="table-responsive">
                        <table id="tableCarta" class="table table-bordered table-hover table-striped w-100">
                            <thead class="bg-primary-600">
                                <tr>
                                    <th>Cod</th>
                                    <th>Tipo Producto</th>
                                    <th>Descripcion</th>
                                    <th>Precio</th>
                                    <th>Cocina</th>
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
<div class="modal fade default-example-modal-right" id="DldModalCarta" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-right">
        <div class="modal-content">
            <form id="dlg_form">
                <div class="modal-header">
                    <h5 class="modal-title h4">FORMULARIO CARTA DE PRODUCTOS</h5>
                    <button onclick="close_modal();" type="button" class="close" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">               
                    <div class="card mb-g">
                        <div class="card-body p-3">
                            <div class="form-row">
                                <input type="hidden" id="dlgcarta_txt_id">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="dlgcarta_txt_tip_pro">Tipo<span class="text-danger">*</span></label>
                                    <select id="dlgcarta_txt_tip_pro" class="form-control" required>
                                        <option value="">Selecciona</option>
                                        <option value="ENTRADAS">ENTRADAS</option>
                                        <option value="CEVICHES">CEVICHES</option>
                                        <option value="CONBINADOS">CONBINADOS</option>
                                        <option value="SOPAS">SOPAS</option>
                                        <option value="CROCANTES">CROCANTES</option>
                                        <option value="TACUTACUS">TACUTACUS</option>
                                        <option value="PASTAS">PASTAS</option>
                                        <option value="ARROCES">ARROCES</option>
                                        <option value="FILETES">FILETES</option>
                                        <option value="FUERA">FUERA</option>
                                        <option value="CRIOLLOS">CRIOLLOS</option>
                                        <option value="PARRILLAS">PARRILLAS</option>
                                        <option value="INFANTILES">INFANTILES</option>
                                        <option value="POSTRES">POSTRES</option>
                                        <option value="BEBIDAS">BEBIDAS</option>
                                        <option value="OTROS">OTROS</option>
                                    </select>                                    
                                    <div id="error_dlgcarta_txt_tip_pro" class="error_msg text-danger d-none"> </div>
                                </div>                                
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="dlgcarta_txt_des_pro">Descripcion<span class="text-danger">*</span></label>
                                    <input id="dlgcarta_txt_des_pro" type="text" class="form-control text-uppercase" required>
                                    <div id="error_dlgcarta_txt_des_pro" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="dlgcarta_txt_pre_pro">Precio: <span class="text-danger">*</span> </label>
                                    <input id="dlgcarta_txt_pre_pro" onkeypress="return isNumberKey(event)" type="text" class="form-control text-uppercase" required>
                                    <div id="error_dlgcarta_txt_pre_pro" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <label class="form-label" for="dlgcarta_txt_cocina">Asignar lugar: </label>
                                    <select id="dlgcarta_txt_cocina" class="form-control" required>
                                        <option value="">Selecciona</option>
                                        <option value="COCINA_1">COCINA 1</option>
                                        <option value="COCINA_2">COCINA 2</option>
                                        <option value="BARRA">BARRA</option>                                                                             
                                    </select>                                    
                                    <div id="error_dlgcarta_txt_cocina" class="error_msg text-danger d-none"> </div>
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
    $("#submenu_carta").addClass("active");   
    var table = $('#tableCarta').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "{{ route('vwcarta') }}",
        columns: [
            {data: 'id', name: 'id',className: 'text-center'},
            {data: 'tip_pro', name: 'tip_pro'},
            {data: 'des_pro', name: 'des_pro'},      
            {data: 'pre_pro', name: 'pre_pro', className: 'text-center'},
            {data: 'cocina', name: 'cocina', className: 'text-center'},      
            {data: 'action', name: 'action', searchable: false},
        ],
        dom: dom_buttons_table,
        buttons: [{
            extend: 'pdfHtml5',
            text: 'PDF',
            titleAttr: 'Generate PDF',
            className: 'btn-outline-danger btn-sm mr-1',
            exportOptions: {
                columns: [1,2,3,4]
            }
        },{
            extend: 'excelHtml5',
            text: 'Excel',
            titleAttr: 'Generate Excel',
            className: 'btn-outline-success btn-sm mr-1',
            exportOptions: {
                columns: [1,2,3,4]
            }
        }],
        lengthMenu: [ [50, 100, -1], [50, 100, "All"] ],
        language: espanol,
        ordering: false,
    });
    
});

function OpenModal(){
    $("#DldModalCarta").modal('show');
}

function getdata(id){   
    MsgDlgLoadAjaxForm("dlg_form");
    $.ajax({        
        url: 'carta/'+id+'/edit',
        type: 'GET',
        success: function (data) {
            $("#dlgcarta_txt_id").val(data.id);
            $("#dlgcarta_txt_tip_pro").val(data.tip_pro);
            $("#dlgcarta_txt_des_pro").val(data.des_pro);
            $("#dlgcarta_txt_pre_pro").val(data.pre_pro);
            $("#dlgcarta_txt_cocina").val(data.cocina);            
        },        
    }).done(function(data){
        setTimeout(function(){            
            if($("#dlgcarta_txt_id").val()==''){
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
        url: 'carta',
        type: 'POST',
        data:{
            "_token": "{{ csrf_token() }}",
            id      : $("#dlgcarta_txt_id").val(),
            tip_pro    : ($("#dlgcarta_txt_tip_pro").val()).toUpperCase(),
            des_pro : ($("#dlgcarta_txt_des_pro").val()).toUpperCase(),
            pre_pro   : $("#dlgcarta_txt_pre_pro").val(),
            cocina   : $("#dlgcarta_txt_cocina").val()            
        }
    }).done(function (data) {
        $('#tableCarta').DataTable().ajax.url("{{ route('vwcarta') }}").load();
        maquinge.notificaciones(data.msg, 'OceanClub', 'success');
        close_modal();
    }).fail(function (data, jqXHR, textStatus) {
        var response = JSON.parse(data.responseText);            
        $.each( response.errors, function( key, value) {
            $('#error_dlgcarta_txt_' + key).removeClass('d-none').text(value);
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
                    url: 'carta/'+id,
                    type: 'DELETE',
                    data:{
                        "_token": "{{ csrf_token() }}",
                        id      : id,           
                    },
                    success: function (data) {    
                        maquinge.notificaciones(data.msg, 'OceanClub', 'success');
                        $('#tableCarta').DataTable().ajax.url("{{ route('vwcarta') }}").load();
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
    $("#DldModalCarta").modal('hide');
    $("#dlgcarta_txt_id").val('');
    $('.error_msg').addClass('d-none').text('');  
    $("#dlg_form")[0].reset();
}




</script>
@endpush
