@extends('layouts.app')
@section('titulo') Administracion Categorias @endsection

@section('contenido')

<div class="row">
    <div class="col-md-6 col-xl-6">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <span class="fw-300"><i>Tabla</i></span>&nbsp;&nbsp;CATEGORIAS DE INGRESOS
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>                    
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="row ml-1 mb-3">
                        <button class="btn btn-primary" data-toggle='modal' data-target='#DldModalIngresoCategoria'>
                            Nuevo Ingreso
                        </button>
                    </div>                                  
                    <div class="table-responsive">
                        <table id="tableIngresoCat" class="table table-bordered table-hover table-striped w-100">
                            <thead class="bg-primary-600">
                                <tr>
                                    <th>ID</th>
                                    <th>CATEGORIA</th>
                                    <th>Acciones</th>                                    
                                </tr>
                            </thead>                    
                        </table>                                             
                    </div>
                </div>
            </div>            
        </div>
    </div>
    <div class="col-md-6 col-xl-6">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <span class="fw-300"><i>Tabla</i></span>&nbsp;&nbsp;CATEGORIAS DE EGRESOS
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>                    
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="row ml-1 mb-3">
                        <button class="btn btn-primary" data-toggle='modal' data-target='#DldModalEgresoCategoria'>
                            Nuevo Egreso
                        </button>
                    </div>                                  
                    <div class="table-responsive">
                        <table id="tableEgresoCat" class="table table-bordered table-hover table-striped w-100">
                            <thead class="bg-primary-600">
                                <tr>
                                    <th>ID</th>
                                    <th>CATEGORIA</th>
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

<div class="modal fade" id="DldModalIngresoCategoria" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="dlgInCategoria_form">
                <div class="modal-header">
                    <h4 class="modal-title">.: CATEGORIA INGRESOS :.</h4>
                    <button onclick="closeModalInCat();" type="button" class="close" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="dlgInCategoria_txt_id_ingre_cat">
                    <div class="col-md-12 mb-3">
                        <label class="form-label" for="dlgInCategoria_txt_desc_ingre_cat">Categoria: <span class="text-danger">*</span> </label>
                        <input id="dlgInCategoria_txt_desc_ingre_cat" type="text" class="form-control jquery_field text-uppercase" required>
                        <div id="error_dlgInCategoria_txt_desc_ingre_cat" class="error_msg text-danger d-none"> </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button onclick="closeModalInCat();" type="button" class="btn btn-secondary">Cerrar</button>
                    <button  onclick="guardar_InCat();" type="button" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="DldModalEgresoCategoria" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="dlgEgCategoria_form">
                <div class="modal-header">
                    <h4 class="modal-title">.: CATEGORIA EGRESOS :.</h4>
                    <button onclick="closeModalEgCat();" type="button" class="close" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="dlgEgCategoria_txt_id_egre_cat">
                    <div class="col-md-12 mb-3">
                        <label class="form-label" for="dlgInCategoria_txt_desc_egre_cat">Categoria: <span class="text-danger">*</span> </label>
                        <input id="dlgInCategoria_txt_desc_egre_cat" type="text" class="form-control jquery_field text-uppercase" required>
                        <div id="error_dlgInCategoria_txt_desc_egre_cat" class="error_msg text-danger d-none"> </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button onclick="closeModalEgCat();" type="button" class="btn btn-secondary">Cerrar</button>
                    <button  onclick="guardar_EgCat();" type="button" class="btn btn-primary">Guardar</button>
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
    $("#submenu_categorias").addClass("active");   
    var table = $('#tableIngresoCat').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "{{ route('InCategoria.list') }}",
        columns: [
            {data: 'id_ingre_cat', name: 'id_ingre_cat'},
            {data: 'desc_ingre_cat', name: 'desc_ingre_cat'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],        
        language: espanol
    });

    var table = $('#tableEgresoCat').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "{{ route('EgCategoria.list') }}",
        columns: [
            {data: 'id_egre_cat', name: 'id_egre_cat'},
            {data: 'desc_egre_cat', name: 'eg_categoria'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],        
        language: espanol
    });
});

/* INGRESOS CATEGORIAS */
function getDataInCategoria(id){  
    $.ajax({        
        url: 'ingresoscategorias/'+id+'/edit',
        type: 'GET',
        success: function (data) {            
            $("#dlgInCategoria_txt_id_ingre_cat").val(data.id_ingre_cat);               
            $("#dlgInCategoria_txt_desc_ingre_cat").val(data.desc_ingre_cat); 
        },
        error: function (error) {            
            var errors = error.responseJSON;                        
            if (error.status === 500) {
                maquinge.notificaciones(errors.msg, 'Maquingenieros', 'error');
            }
        }
    });
}
function guardar_InCat(){
    $('.error_msg').addClass('d-none').text('');
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        url: 'ingresoscategorias',
        type: 'POST',
        data:{
            "_token"        : "{{ csrf_token() }}",
            id_ingre_cat    : $("#dlgInCategoria_txt_id_ingre_cat").val(),
            desc_ingre_cat  : ($("#dlgInCategoria_txt_desc_ingre_cat").val()).toUpperCase(),            
        },
        success: function (data) {
            $('#tableIngresoCat').DataTable().ajax.url("{{ route('InCategoria.list') }}").load();
            maquinge.notificaciones(data.msg, 'Maquingenieros', 'success');
            closeModalInCat();
        },
        error: function (data) {
            var response = JSON.parse(data.responseText);            
            $.each( response.errors, function( key, value) {
                $('#error_dlgInCategoria_txt_' + key).removeClass('d-none').text(value);
            });
            if (data.status === 500) {
                maquinge.notificaciones('Error interno comun&iacute;quese con el &aacute;rea de sistemas', 'Maquingenieros', 'error');
            } 
            initApp.playSound(asset+'smartadmin/dist/media/sound', 'voice_alert');
        }
    });
}

function closeModalInCat(){
    $("#DldModalIngresoCategoria").modal('hide');
    $('.error_msg').addClass('d-none').text('');
    $("#dlgInCategoria_txt_id").val('');
    $("#dlgInCategoria_form")[0].reset();
    $("#dlgInCategoria_txt_id_ingre_cat").val('');
}

/* ---------------    EGRESOS CATEGORIAS  -------------------------- */

function getDataEgresoCategoria(id){  
    $.ajax({        
        url: 'egresoscategorias/'+id+'/edit',
        type: 'GET',
        success: function (data) {
            $("#dlgEgCategoria_txt_id_egre_cat").val(data.id_egre_cat)                 
            $("#dlgInCategoria_txt_desc_egre_cat").val(data.desc_egre_cat) 
        },
        error: function (error) {            
            var errors = error.responseJSON;                        
            if (error.status === 500) {
                maquinge.notificaciones(errors.msg, 'Maquingenieros', 'error');
            }
        }
    });
}
function guardar_EgCat(){
    $('.error_msg').addClass('d-none').text('');
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        url: 'egresoscategorias',
        type: 'POST',
        data:{
            "_token"        : "{{ csrf_token() }}",
            id_egre_cat     : $("#dlgEgCategoria_txt_id_egre_cat").val(),
            desc_egre_cat   : ($("#dlgInCategoria_txt_desc_egre_cat").val()).toUpperCase(),            
        },
        success: function (data) {
            $('#tableEgresoCat').DataTable().ajax.url("{{ route('EgCategoria.list') }}").load();
            maquinge.notificaciones(data.msg, 'Maquingenieros', 'success');
            closeModalEgCat();
        },
        error: function (data) {
            var response = JSON.parse(data.responseText);            
            $.each( response.errors, function( key, value) {
                $('#error_dlgInCategoria_txt_' + key).removeClass('d-none').text(value);
            });
            if (data.status === 500) {
                maquinge.notificaciones('Error interno comun&iacute;quese con el &aacute;rea de sistemas', 'Maquingenieros', 'error');
            } 
            initApp.playSound(asset+'smartadmin/dist/media/sound', 'voice_alert');
        }
    });
}

function closeModalEgCat(){
    $("#DldModalEgresoCategoria").modal('hide');
    $('.error_msg').addClass('d-none').text('');
    $("#dlgEgCategoria_txt_id").val('');
    $("#dlgEgCategoria_form")[0].reset();
    $("#dlgEgCategoria_txt_id_egre_cat").val('');
}

</script>
@endpush