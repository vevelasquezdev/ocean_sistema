@extends('layouts.app')
@section('titulo') {{__('Users')}} @endsection


@section('contenido')

<div class="row">
    <div class="col-md-12 col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <span class="fw-300"><i>Tabla</i></span>&nbsp;&nbsp;USUARIOS 
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>                    
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="row ml-1 mb-3">
                        <button class="btn btn-primary" data-toggle='modal' data-target='.default-example-modal-right'>
                            Agregar Nuevo Usuario
                        </button>
                    </div>
                                  
                    <div class="table-responsive">
                        <table id="tableUsers" class="table table-bordered table-hover table-striped w-100">
                            <thead class="bg-primary-600">
                                <tr>
                                    <th>ID</th>
                                    <th>FOTO</th>                                    
                                    <th>NOMBRES</th>
                                    <th>APELLIDOS</th>
                                    <th>EMAIL</th>
                                    <th>ROL</th>
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
<div class="modal fade default-example-modal-right" id="DldModalUser" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-right">
        <div class="modal-content">
            <form id="dlguser_form" class="needs-validation" novalidate>
                <div class="modal-header">
                    <h5 class="modal-title h4">FORMULARIO DE USUARIOS</h5>
                    <button onclick="close_modal();" type="button" class="close" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">               
                    <div class="card mb-g">
                        <div class="card-body p-3">
                            <div class="form-row">
                                <input type="hidden" id="dlguser_txt_id">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="dlguser_txt_name">Nombres <span class="text-danger">*</span> </label>
                                    <input id="dlguser_txt_name" type="text" class="form-control jquery_field text-uppercase" required>
                                    <div id="error_dlguser_txt_name" class="error_msg text-danger d-none">sdsd </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="dlguser_txt_surname">Apellidos<span class="text-danger">*</span></label>
                                    <input id="dlguser_txt_surname" type="text" class="form-control jquery_field text-uppercase" required>
                                    <div id="error_dlguser_txt_surname" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="dlguser_txt_email">Email<span class="text-danger">*</span></label>
                                    <input id="dlguser_txt_email" type="text" class="form-control jquery_field" required>
                                    <div id="error_dlguser_txt_email" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="dlguser_txt_rol">Rol<span class="text-danger">*</span></label>
                                    <select id="dlguser_txt_rol" class="form-control jquery_field" required>
                                        <option value="">Selecciona</option>
                                        <option value="ADMINISTRADOR">ADMINISTRADOR</option>
                                        <option value="ENCARGADO">ENCARGADO</option>
                                        <option value="CAJA">CAJA</option>
                                        <option value="MOZO">MOZO</option>
                                        <option value="BAR">BAR</option>
                                        <option value="COCINA">COCINA</option>
                                        <option value="ALMACEN">ALMACEN</option>                                  
                                    </select>                                    
                                    <div id="error_dlguser_txt_rol" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="dlguser_txt_password">Contraseña:<span class="text-danger">*</span></label>
                                    <input id="dlguser_txt_password" type="text" class="form-control jquery_field" required>
                                    <div id="error_dlguser_txt_password" class="error_msg text-danger d-none"> </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button onclick="close_modal();" type="button" class="btn btn-secondary">Cerrar</button>
                    <button onclick="guardar_user();" type="button" class="btn btn-primary">Guardar</button>
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
    $("#submenu_usuarios").addClass("active");   
    var table = $('#tableUsers').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "{{ route('vwuser') }}",
        columns: [
            {data: 'id', name: 'id', className: 'user_id', visible: false, searchable: false},
            {data: 'profile_photo_path', name: 'profile_photo_path', searchable: false, align:'center'},                           
            {data: 'name', name: 'name', className: 'user_name'},
            {data: 'surname', name: 'surname'},      
            {data: 'email', name: 'email'},                 
            {data: 'rol', name: 'rol'},                
            {data: 'action', name: 'action', searchable: false},
        ],
        dom: dom_buttons_table,
        buttons: [{
            extend: 'pdfHtml5',
            text: 'PDF',
            titleAttr: 'Generate PDF',
            className: 'btn-outline-danger btn-sm mr-1',
            exportOptions: {
                columns: [2,3,4,5]
            }
        },{
            extend: 'excelHtml5',
            text: 'Excel',
            titleAttr: 'Generate Excel',
            className: 'btn-outline-success btn-sm mr-1',
            exportOptions: {
                columns: [2,3,4,5]
            }
        }],
        lengthMenu: [ [50, 100, -1], [50, 100, "All"] ],
        language: espanol,
        ordering: false,
    });
    
});

function getdatauser(id){   
     
    $.ajax({        
        url: 'users/'+id+'/edit',
        type: 'GET',
        success: function (data) {
            $("#dlguser_txt_id").val(data.id);
            $("#dlguser_txt_name").val(data.name);
            $("#dlguser_txt_surname").val(data.surname);
            $("#dlguser_txt_email").val(data.email);
            $("#dlguser_txt_rol").val(data.rol);
        },
        error: function (error) {            
            var errors = error.responseJSON;                        
            if (error.status === 500) {
                maquinge.notificaciones(errors.msg, 'Maquingenieros', 'error');
            }
        }
    });
}

function guardar_user(){
    $('.error_msg').addClass('d-none').text('');
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        url: 'users',
        type: 'POST',
        data:{
            "_token": "{{ csrf_token() }}",
            id      : $("#dlguser_txt_id").val(),
            name    : ($("#dlguser_txt_name").val()).toUpperCase(),
            surname : ($("#dlguser_txt_surname").val()).toUpperCase(),
            email   : $("#dlguser_txt_email").val(),
            rol     : $("#dlguser_txt_rol").val(),
            password: $("#dlguser_txt_password").val(),
        },
        success: function (data) {
            $('#tableUsers').DataTable().ajax.url("{{ route('vwuser') }}").load();
            maquinge.notificaciones(data.msg, 'Maquingenieros', 'success');
            close_modal();
        },
        error: function (data) {
            var response = JSON.parse(data.responseText);            
            $.each( response.errors, function( key, value) {
                $('#error_dlguser_txt_' + key).removeClass('d-none').text(value);
            });   
            initApp.playSound(asset+'smartadmin/dist/media/sound', 'voice_alert');
        }
    });
}

function delete_user(id){ 
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
                    url: 'users/'+id,
                    type: 'DELETE',
                    data:{
                        "_token": "{{ csrf_token() }}",
                        id      : id,           
                    },
                    success: function (data) {    
                        maquinge.notificaciones(data.msg, 'Maquingenieros', 'success');
                        $('#tableUsers').DataTable().ajax.url("{{ route('vwuser') }}").load();
                    },
                    error: function (error) {  
                        var errors = error.responseJSON;                        
                        if (error.status === 500) {
                            maquinge.notificaciones(errors.msg, 'Maquingenieros', 'error');
                        }
                    }
                });
            }            
        }
    });
}

function close_modal(){  
    $("#DldModalUser").modal('hide');
    $("#dlguser_txt_id").val('');
    $('.error_msg').addClass('d-none').text('');  
    $("#dlguser_form")[0].reset();
}




</script>
@endpush
