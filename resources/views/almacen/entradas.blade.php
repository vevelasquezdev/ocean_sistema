@extends('layouts.app')
@section('titulo') Almacen-Entradas @endsection


@section('contenido')
<style>

</style>
<div class="row">
    <div class="col-md-12 col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Almacen - Entradas
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
                            <button onclick="OpenModal();" type="button" class="btn btn-primary waves-effect waves-themed">Entradas</button> 
                        </div>
                        <div class="col-md-2 mb-4">                           
                            <div class="form-group row">
                                <label class="col-form-label col-12 col-lg-2 form-label text-lg-right mr-2">Fecha:</label>
                                <div class="col-12 col-lg-9">
                                    <input style="width: 100px" type="text" id="fch" class="form-control form-control-sm" value="@php echo date('d-m-Y'); @endphp"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mb-4">                           
                            <button onclick="actualizar();" type="button" class="btn btn-info btn-sm waves-effect waves-themed">Actualizar</button> 
                        </div> 
                    </div>                   
                                  
                    <div class="table-responsive">
                        <table id="tablaEntradas" class="table table-bordered table-hover table-striped w-100">
                            <thead class="bg-primary-600">
                                <tr>
                                    <th>ID</th>
                                    <th>CodProd</th>
                                    <th>Descripción Producto</th>
                                    <th>Unidad</th>
                                    <th>Cant</th>
                                    <th>Destino (a)</th>
                                    <th>Origen (De)</th>                                    
                                    <th>Fecha y Hora</th>
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

<div class="modal fade default-example-modal" id="DldModalEntradas" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="dlg_form">
                <div class="modal-header">
                    <h5 class="modal-title h4">.: ENTRADAS :.</h5>
                    <button onclick="close_modal();" type="button" class="close" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row pl-3 pr-3">
                        <input type="hidden" id="DldModalEntradas_id">                       
                        <div class="col-md-9 mb-3">
                            <input type="hidden" id="DldModalEntradas_id_prod">
                            <label class="form-label" for="DldModalEntradas_des_pro">Producto:<span class="text-danger">*</span></label>
                            <input id="DldModalEntradas_des_pro" type="text" class="typeahead form-control jquery_field text-uppercase" >
                            <div id="error_DldModalEntradas_id_prod" class="error_msg text-danger d-none"> </div>
                        </div>                                
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="DldModalEntradas_cant">Cantidad:<span class="text-danger">*</span></label>
                            <input id="DldModalEntradas_cant" type="number" min="1" class="form-control jquery_field text-uppercase" >
                            <div id="error_DldModalEntradas_cant" class="error_msg text-danger d-none"> </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="DldModalEntradas_unidad">Unidad:<span class="text-danger">*</span></label>
                            <select id="DldModalEntradas_unidad" class="form-control jquery_field text-uppercase">
                                <option value="">Selecciona</option>
                                <option value="Unid.">Unid.</option>
                                <option value="Kilogramo">Kilogramo</option>
                                <option value="Litro">Litro</option>
                            </select>
                            <div id="error_DldModalEntradas_unidad" class="error_msg text-danger d-none"> </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="DldModalEntradas_fecha">Fecha - Hora:<span class="text-danger">*</span></label>
                            <input id="DldModalEntradas_fecha" type="text" class="form-control jquery_field text-uppercase" data-inputmask="'mask': '99-99-9999 99:99'" value="{{ date('d-m-Y H:i') }}" readonly>
                            <span class="help-block">Ejemplo: 17-04-2030 09:45</span>
                            <div id="error_DldModalEntradas_fecha" class="error_msg text-danger d-none"> </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="DldModalEntradas_destino">Destino (a):<span class="text-danger">*</span></label>
                            <select id="DldModalEntradas_destino" class="form-control jquery_field text-uppercase" disabled>
                                <option value="">Selecciona</option>
                                <option value="PRINCIPAL_COCINA">PRINCIPAL_COCINA</option>
                                {{-- <option value="COCINA_1">COCINA_1</option>
                                <option value="COCINA_2">COCINA_2</option> --}}
                                <option value="PRINCIPAL_BARRA">PRINCIPAL_BARRA</option>
                                {{-- <option value="BARRA_1">BARRA_1</option>
                                <option value="BARRA_2">BARRA_2</option>
                                <option value="BARRA_3">BARRA_3</option>
                                <option value="BARRA_4">BARRA_4</option>                                 --}}
                            </select>
                            <div id="error_DldModalEntradas_destino" class="error_msg text-danger d-none"> </div>
                        </div> 
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="DldModalEntradas_origen">Origen (de):<span class="text-danger">*</span></label>
                            <select id="DldModalEntradas_origen" class="form-control jquery_field text-uppercase">
                                <option value="">Selecciona</option>
                                {{-- <option value="PRINCIPAL_COCINA">PRINCIPAL_COCINA</option>
                                <option value="COCINA_1">COCINA_1</option>
                                <option value="COCINA_2">COCINA_2</option>
                                <option value="PRINCIPAL_BARRA">PRINCIPAL_BARRA</option>
                                <option value="BARRA_1">BARRA_1</option>
                                <option value="BARRA_2">BARRA_2</option>
                                <option value="BARRA_3">BARRA_3</option>
                                <option value="BARRA_4">BARRA_4</option> --}}
                                <option value="COMPRA">COMPRA</option>
                            </select>
                            <div id="error_DldModalEntradas_origen" class="error_msg text-danger d-none"> </div>
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
    $("#menu_almacen_ent_sal").addClass("active open");
    $("#submenu_entradas").addClass("active");   
    $('#fch').datepicker({
                    todayHighlight: true,
                    orientation: "bottom left",
                    templates: controls,
                    format: 'dd-mm-yyyy'
                }); 
    var table = $('#tablaEntradas').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "tabla-alm-entradas?fch="+$('#fch').val(),
        columns: [
            {data: 'id', visible:false},
            {data: 'id_prod',visible:false,className: 'text-center'},
            {data: 'des_pro'},
            {data: 'unidad'},
            {data: 'cant',className: 'text-center'},
            {data: 'destino'}, 
            {data: 'origen'},
            {data: 'fecha'},     
            {data: 'action', searchable: false},
        ],
        dom: dom_buttons_table,
        buttons: [{
            extend: 'pdfHtml5',
            text: 'PDF',
            titleAttr: 'Generate PDF',
            className: 'btn-outline-danger btn-sm mr-1',
            exportOptions: {
                columns: [2,3,4,5,6,7]
            }
        },{
            extend: 'excelHtml5',
            text: 'Excel',
            titleAttr: 'Generate Excel',
            className: 'btn-outline-success btn-sm mr-1',
            exportOptions: {
                columns: [2,3,4,5,6,7]
            }
        }],
        lengthMenu: [ [50, 100, -1], [50, 100, "All"] ],
        language: espanol,
        ordering: false,
    });
    
});


function OpenModal(){
    MsgDlgLoadAjaxForm("dlg_form");
    $.ajax({        
        url: 'check_recarga_inventarios',
        type: 'GET',              
    }).done(function(data){
        if(data.msg==0){
            maquinge.notificaciones('Es necesario realizar Recarga de Inventarios.<br>* Ir a Menu Productos.', 'Sistema', 'error');
        }else{
            $("#DldModalEntradas").modal('show');
            $("#DldModalEntradas_origen").val('COMPRA');
        }
        setTimeout(function(){
            MsgDlgLoadAjaxFinish("dlg_form"); 
        }, 500);
    }).fail( function(jqXHR, textStatus, errorThrown ) {        
        maquinge.notificaciones(textStatus, 'Sistema', 'error');
        MsgDlgLoadAjaxFinish("dlg_form"); 
    });
}

function close_modal(){  
    $("#DldModalEntradas").modal('hide');    
    $('.error_msg').addClass('d-none').text('');  
    $("#dlg_form")[0].reset();
    $("#DldModalEntradas_id,#DldModalEntradas_id_prod").val('');
}


function guardar(){
    $('.error_msg').addClass('d-none').text('');  
    MsgDlgLoadAjaxForm("dlg_form");  
    $.ajax({ 
        cache: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        url: 'alm-entradas',
        type: 'POST',
        data:{
            "_token"    : "{{ csrf_token() }}",
            id          : $("#DldModalEntradas_id").val(),
            id_prod     : $("#DldModalEntradas_id_prod").val(),
            cant        : $("#DldModalEntradas_cant").val(),
            unidad      : $("#DldModalEntradas_unidad").val(),
            destino     : $("#DldModalEntradas_destino").val(),
            origen      : $("#DldModalEntradas_origen").val(),
            fecha       : $("#DldModalEntradas_fecha").val()                
        }
    }).done(function (data) {
        $('#tablaEntradas').DataTable().ajax.url("tabla-alm-entradas?fch="+$('#fch').val()).load();
        maquinge.notificaciones(data.msg, 'Sistema', 'success');
        setTimeout(function(){    
            MsgDlgLoadAjaxFinish("dlg_form");
            close_modal();
        }, 1000);
    }).fail(function (data, jqXHR, textStatus) {
        var response = JSON.parse(data.responseText);            
        $.each( response.errors, function( key, value) {
            $('#error_DldModalEntradas_' + key).removeClass('d-none').text(value);
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
        url: 'alm-entradas/'+id+'/edit',
        type: 'GET',              
    }).done(function(data){
        $("#DldModalEntradas_id").val(data[0].id),
        $("#DldModalEntradas_id_prod").val(data[0].id_prod),
        $("#DldModalEntradas_des_pro").val(data[0].des_pro),
        $("#DldModalEntradas_cant").val(data[0].cant),
        $("#DldModalEntradas_unidad").val(data[0].unidad),
        $("#DldModalEntradas_destino").val(data[0].destino),
        $("#DldModalEntradas_origen").val(data[0].origen),
        $("#DldModalEntradas_fecha").val(data[0].fecha)

        setTimeout(function(){            
            if($("#DldModalEntradas_id").val()==''){
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
    Swal.fire({
        title: "¿ Está seguro que desea eliminar el registro ?",
        text: "Esta acción no se puede deshacer!",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Aceptar"
    }).then(function(result){
        if (result.value){
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                url: 'alm-entradas/'+id,
                type: 'DELETE',
                data:{
                    "_token": "{{ csrf_token() }}",
                    id      : id,           
                },
                success: function (data) {    
                    maquinge.notificaciones(data.msg, 'Sistema', 'success');
                    $('#tablaEntradas').DataTable().ajax.url("tabla-alm-entradas?fch="+$('#fch').val()).load();
                },
                error: function (error) {  
                    var errors = error.responseJSON;                        
                    if (error.status === 500) {
                        maquinge.notificaciones(errors.msg, 'Sistema', 'error');
                    }
                }
            });
        }
    });
    
}

function actualizar(){
    $('#tablaEntradas').DataTable().ajax.url("tabla-alm-entradas?fch="+$('#fch').val()).load();
}
//BUSCADOR GOOGLE
$('#DldModalEntradas_des_pro').typeahead({
    source: function(query, process) {
        objects = [];
        map = {};
        $.getJSON('productos-entradas/'+query, null,function ( jsonData ){
            $.each(jsonData, function(i, object) {
                map[object.label] = object;
                objects.push(object.label);
            });
            process(objects);
        });
    },
    items: 15,
    minLength: 2,
    delay: 300,
    highlighter: function (item) {
        var regex = new RegExp( '(' + this.query + ')', 'gi' );
        return item.replace( regex, "<strong>$1</strong>" );
    },
    updater: function(item) {
        $('#DldModalEntradas_id_prod').val(map[item].id);
        $("#DldModalEntradas_unidad").val(map[item].unidad);

        if(map[item].lugar=='BARRA'){
            $("#DldModalEntradas_destino").val('PRINCIPAL_BARRA');
        }else{
            $("#DldModalEntradas_destino").val('PRINCIPAL_COCINA');
        }
        return map[item].descripcion;
    }
}); 



</script>
@endpush
