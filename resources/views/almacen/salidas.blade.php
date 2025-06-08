@extends('layouts.app')
@section('titulo') Almacen-Salidas @endsection


@section('contenido')
<style>

</style>
<div class="row">
    <div class="col-md-12 col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Almacen - Salidas 
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
                            <button onclick="OpenModal();" type="button" class="btn btn-primary waves-effect waves-themed">Nueva Salida</button> 
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
                        <table id="tablaSalidas" class="table table-bordered table-hover table-striped w-100">
                            <thead class="bg-primary-600">
                                <tr>
                                    <th>ID</th>
                                    <th>CodProd</th>
                                    <th>Descripción Producto</th>
                                    <th>Unidad</th>
                                    <th>Cant</th>
                                    <th>Origen (De)</th>
                                    <th>Destino (a)</th>
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

<div class="modal fade default-example-modal" id="DldModalSalidas" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="dlg_form">
                <div class="modal-header">
                    <h5 class="modal-title h4">.: SALIDAS :.</h5>
                    <button onclick="close_modal();" type="button" class="close" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row pl-3 pr-3">
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="DldModalSalidas_origen">Origen (de):<span class="text-danger">*</span></label>
                            <select id="DldModalSalidas_origen" onchange="reiniciar_valores_select(this.value)" class="form-control jquery_field text-uppercase">
                                <option value="">Selecciona</option>
                                <option value="PRINCIPAL_COCINA">PRINCIPAL_COCINA</option>
                                <option value="COCINA_1">COCINA_1</option>
                                <option value="COCINA_2">COCINA_2</option>
                                <option value="PRINCIPAL_BARRA">PRINCIPAL_BARRA</option>
                                <option value="BARRA_1">BARRA_1</option>
                                <option value="BARRA_2">BARRA_2</option>
                                <option value="BARRA_3">BARRA_3</option>
                                <option value="BARRA_4">BARRA_4</option>                                
                            </select>
                            <div id="error_DldModalSalidas_origen" class="error_msg text-danger d-none"> </div>
                        </div>
                        
                        <input type="hidden" id="DldModalSalidas_id">                       
                        <div class="col-md-9 mb-3">
                            <input type="hidden" id="DldModalSalidas_id_prod">
                            <label class="form-label" for="DldModalSalidas_des_pro">Producto:<span class="text-danger">*</span></label>
                            <input id="DldModalSalidas_des_pro" type="text" class="typeahead form-control jquery_field text-uppercase" >
                            <div id="error_DldModalSalidas_id_prod" class="error_msg text-danger d-none"> </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="DldModalSalidas_stock">Stock:<span class="text-danger">*</span></label>
                            <input id="DldModalSalidas_stock" type="text" class="form-control jquery_field text-uppercase" readonly>
                            <div id="error_DldModalSalidas_stock" class="error_msg text-danger d-none"> </div>
                        </div>                               
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="DldModalSalidas_cant">Cantidad:<span class="text-danger">*</span></label>
                            <input id="DldModalSalidas_cant" type="number" min="1" onblur="validar_cantidad(this.value);" class="form-control jquery_field text-uppercase" >
                            <div id="error_DldModalSalidas_cant" class="error_msg text-danger d-none"> </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="DldModalSalidas_unidad">Unidad:<span class="text-danger">*</span></label>
                            <select id="DldModalSalidas_unidad" class="form-control jquery_field text-uppercase">
                                <option value="">Selecciona</option>
                                <option value="Unid.">Unid.</option>
                                <option value="Kilogramo">Kilogramo</option>
                                <option value="Litro">Litro</option>
                            </select>
                            <div id="error_DldModalSalidas_unidad" class="error_msg text-danger d-none"> </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="DldModalSalidas_fecha">Fecha - Hora:<span class="text-danger">*</span></label>
                            <input id="DldModalSalidas_fecha" type="text" class="form-control jquery_field text-uppercase" data-inputmask="'mask': '99-99-9999 99:99'" value="{{ date('d-m-Y H:i') }}" readonly>
                            <span class="help-block">Ejemplo: 17-04-2030 09:45</span>
                            <div id="error_DldModalSalidas_fecha" class="error_msg text-danger d-none"> </div>
                        </div> 
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="DldModalSalidas_destino">Destino (a):<span class="text-danger">*</span></label>
                            <select id="DldModalSalidas_destino" class="form-control jquery_field text-uppercase">
                                <option value="">Selecciona</option>
                                {{-- <option value="PRINCIPAL_COCINA">PRINCIPAL_COCINA</option>
                                <option value="COCINA_1">COCINA_1</option>
                                <option value="COCINA_2">COCINA_2</option>
                                <option value="PRINCIPAL_BARRA">PRINCIPAL_BARRA</option>
                                <option value="BARRA_1">BARRA_1</option>
                                <option value="BARRA_2">BARRA_2</option>
                                <option value="BARRA_3">BARRA_3</option>
                                <option value="BARRA_4">BARRA_4</option>
                                <option value="CONSUMO">CONSUMO</option> --}}
                            </select>
                            <div id="error_DldModalSalidas_destino" class="error_msg text-danger d-none"> </div>
                        </div>                       
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="DldModalSalidas_comentario">Comentario:<span class="text-danger">*</span></label>
                            {{-- <textarea id="DldModalSalidas_comentario" rows="2" class="form-control jquery_field text-uppercase" style="width:100%;"></textarea> --}}
                            <input id="DldModalSalidas_comentario" type="text" class="form-control jquery_field text-uppercase" >
                            <div id="error_DldModalSalidas_comentario" class="error_msg text-danger d-none"> </div>
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
    $("#submenu_salidas").addClass("active");   
    $('#fch').datepicker({
                    todayHighlight: true,
                    orientation: "bottom left",
                    templates: controls,
                    format: 'dd-mm-yyyy'}); 

    var table = $('#tablaSalidas').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "tabla-alm-salidas?fch="+$('#fch').val(),
        columns: [
            {data: 'id', visible:false},
            {data: 'id_prod',visible:false,className: 'text-center'},
            {data: 'des_pro'},
            {data: 'unidad'},
            {data: 'cant',className: 'text-center'},
            {data: 'origen'},
            {data: 'destino'},      
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
        //fixedHeader: true,
        initComplete: function () {
            this.api().columns([5]).every( function () {
                var column = this;
                var select = $("<select class='form-control' style='padding: 0px;font-size: 11px;height: 20px;'><option value=''>ORIGEN TODOS</option></select>")
                    .appendTo( $(column.header()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column.search( val ? '^'+val+'$' : '', true, false ).draw();
                    } );
                select.append("<option value='PRINCIPAL_BARRA'>ORIGEN PRINCIPAL_BARRA</option>")
                select.append("<option value='BARRA_1'>ORIGEN BARRA_1</option>")
                select.append("<option value='BARRA_2'>ORIGEN BARRA_2</option>")
                select.append("<option value='BARRA_3'>ORIGEN BARRA_3</option>")
                select.append("<option value='BARRA_4'>ORIGEN BARRA_4</option>")
                
                
            } );
            this.api().columns([6]).every( function () {
                var column = this;
                var select = $("<select class='form-control' style='padding: 0px;font-size: 11px;height: 20px;'><option value=''>DESTINO TODOS</option></select>")
                    .appendTo( $(column.header()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column.search( val ? '^'+val+'$' : '', true, false ).draw();
                    } );
                select.append("<option value='CONSUMO'>DESTINO CONSUMO</option>")
                select.append("<option value='BARRA_1'>DESTINO BARRA_1</option>")
                select.append("<option value='BARRA_2'>DESTINO BARRA_2</option>")
                select.append("<option value='BARRA_3'>DESTINO BARRA_3</option>")
                select.append("<option value='BARRA_4'>DESTINO BARRA_4</option>")
            } );
            
            
        }
    });
    
});


function OpenModal(){    
    
    $.ajax({        
        url: 'check_recarga_inventarios',
        type: 'GET',              
    }).done(function(data){
        if(data.msg==0){
            maquinge.notificaciones('Es necesario realizar Recarga de Inventarios.<br>* Ir a Menu Productos.', 'Sistema', 'error');
        }else{
            $("#DldModalSalidas").modal('show');
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
    $("#DldModalSalidas").modal('hide');    
    $('.error_msg').addClass('d-none').text('');  
    $("#dlg_form")[0].reset();
    $("#DldModalSalidas_id,#DldModalSalidas_id_prod").val('');
}


function guardar(){
    $('.error_msg').addClass('d-none').text('');  
    MsgDlgLoadAjaxForm("dlg_form");  
    $.ajax({ 
        cache: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        url: 'alm-salidas',
        type: 'POST',
        data:{
            "_token"    : "{{ csrf_token() }}",
            id          : $("#DldModalSalidas_id").val(),
            id_prod     : $("#DldModalSalidas_id_prod").val(),
            cant        : $("#DldModalSalidas_cant").val(),
            unidad      : $("#DldModalSalidas_unidad").val(),
            destino     : $("#DldModalSalidas_destino").val(),
            origen      : $("#DldModalSalidas_origen").val(),
            fecha       : $("#DldModalSalidas_fecha").val(),
            stock       : $("#DldModalSalidas_stock").val(),
            comentario  : $("#DldModalSalidas_comentario").val()               
        }
    }).done(function (data) {
        $('#tablaSalidas').DataTable().ajax.url("tabla-alm-salidas?fch="+$('#fch').val()).load();
        maquinge.notificaciones(data.msg, 'Sistema', 'success');
        setTimeout(function(){    
            MsgDlgLoadAjaxFinish("dlg_form");
            close_modal();
        }, 1000);
    }).fail(function (data, jqXHR, textStatus) {
        var response = JSON.parse(data.responseText);            
        $.each( response.errors, function( key, value) {
            $('#error_DldModalSalidas_' + key).removeClass('d-none').text(value);
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
        url: 'alm-salidas/'+id+'/edit',
        type: 'GET',              
    }).done(function(data){
        $("#DldModalSalidas_id").val(data[0].id),
        $("#DldModalSalidas_id_prod").val(data[0].id_prod),
        $("#DldModalSalidas_des_pro").val(data[0].des_pro),
        $("#DldModalSalidas_cant").val(data[0].cant),
        $("#DldModalSalidas_unidad").val(data[0].unidad),
        $("#DldModalSalidas_destino").val(data[0].destino),
        $("#DldModalSalidas_origen").val(data[0].origen),
        $("#DldModalSalidas_fecha").val(data[0].fecha)

        setTimeout(function(){            
            if($("#DldModalSalidas_id").val()==''){
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
                url: 'alm-salidas/'+id,
                type: 'DELETE',
                data:{
                    "_token": "{{ csrf_token() }}",
                    id      : id,           
                },
                success: function (data) {    
                    maquinge.notificaciones(data.msg, 'Sistema', 'success');
                    $('#tablaSalidas').DataTable().ajax.url("tabla-alm-salidas?fch="+$('#fch').val()).load();
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
    $('#tablaSalidas').DataTable().ajax.url("tabla-alm-salidas?fch="+$('#fch').val()).load();
}

//BUSCADOR GOOGLE
DldModalSalidas_des_pro.oninput = function() {
    if($("#DldModalSalidas_origen").val()==''){
        maquinge.notificaciones('Es necesario seleccionar el Origen...', 'Sistema', 'error');
        $("#DldModalSalidas_origen").focus();
    }else{
        $('#DldModalSalidas_des_pro').typeahead({
            source: function(query, process) {
                objects = [];
                map = {};
                $.getJSON('almacen-productos?query='+query+'&origen='+$("#DldModalSalidas_origen").val(), null,function ( jsonData ){
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
                $('#DldModalSalidas_id_prod').val(map[item].id);
                $("#DldModalSalidas_unidad").val(map[item].unidad);
                $("#DldModalSalidas_stock").val(map[item].stock);
                if(map[item].stock==0){
                    maquinge.notificaciones('Stock=0', 'Sistema', 'error');
                }
                return map[item].descripcion;
            }
        }); 
    }
};

function reiniciar_valores_select(origen){
    $('#DldModalSalidas_destino').prop('options').length = 1;
    $('#DldModalSalidas_id_prod,#DldModalSalidas_des_pro').val('');
    $("#DldModalSalidas_unidad").val('');
    $("#DldModalSalidas_stock").val(''); 
    $("#DldModalSalidas_des_pro").focus();  
    
    if(origen=='PRINCIPAL_COCINA'){
        $('#DldModalSalidas_destino').append("<option value='COCINA_1'>COCINA_1</option>");
        $('#DldModalSalidas_destino').append("<option value='COCINA_2'>COCINA_2</option>");
    }else if(origen=='PRINCIPAL_BARRA'){
        $('#DldModalSalidas_destino').append("<option value='BARRA_1'>BARRA_1</option>");
        $('#DldModalSalidas_destino').append("<option value='BARRA_2'>BARRA_2</option>");
        $('#DldModalSalidas_destino').append("<option value='BARRA_3'>BARRA_3</option>");
        $('#DldModalSalidas_destino').append("<option value='BARRA_4'>BARRA_4</option>");
    }else if(origen=='COCINA_1'){
        $('#DldModalSalidas_destino').append("<option value='PRINCIPAL_COCINA'>PRINCIPAL_COCINA</option>");
        $('#DldModalSalidas_destino').append("<option value='COCINA_2'>COCINA_2</option>");
        $('#DldModalSalidas_destino').append("<option value='CONSUMO'>CONSUMO</option>");
    }else if(origen=='COCINA_2'){
        $('#DldModalSalidas_destino').append("<option value='PRINCIPAL_COCINA'>PRINCIPAL_COCINA</option>");
        $('#DldModalSalidas_destino').append("<option value='COCINA_1'>COCINA_1</option>");
        $('#DldModalSalidas_destino').append("<option value='CONSUMO'>CONSUMO</option>");
    }else if(origen=='BARRA_1'){
        $('#DldModalSalidas_destino').append("<option value='PRINCIPAL_BARRA'>PRINCIPAL_BARRA</option>");
        $('#DldModalSalidas_destino').append("<option value='BARRA_2'>BARRA_2</option>");
        $('#DldModalSalidas_destino').append("<option value='BARRA_3'>BARRA_3</option>");
        $('#DldModalSalidas_destino').append("<option value='BARRA_4'>BARRA_4</option>");
        $('#DldModalSalidas_destino').append("<option value='CONSUMO'>CONSUMO</option>");
    }else if(origen=='BARRA_2'){
        $('#DldModalSalidas_destino').append("<option value='PRINCIPAL_BARRA'>PRINCIPAL_BARRA</option>");
        $('#DldModalSalidas_destino').append("<option value='BARRA_1'>BARRA_1</option>");
        $('#DldModalSalidas_destino').append("<option value='BARRA_3'>BARRA_3</option>");
        $('#DldModalSalidas_destino').append("<option value='BARRA_4'>BARRA_4</option>");
        $('#DldModalSalidas_destino').append("<option value='CONSUMO'>CONSUMO</option>");
    }else if(origen=='BARRA_3'){
        $('#DldModalSalidas_destino').append("<option value='PRINCIPAL_BARRA'>PRINCIPAL_BARRA</option>");
        $('#DldModalSalidas_destino').append("<option value='BARRA_1'>BARRA_1</option>");
        $('#DldModalSalidas_destino').append("<option value='BARRA_2'>BARRA_2</option>");
        $('#DldModalSalidas_destino').append("<option value='BARRA_4'>BARRA_4</option>");
        $('#DldModalSalidas_destino').append("<option value='CONSUMO'>CONSUMO</option>");
    }else if(origen=='BARRA_4'){ 
        $('#DldModalSalidas_destino').append("<option value='PRINCIPAL_BARRA'>PRINCIPAL_BARRA</option>");
        $('#DldModalSalidas_destino').append("<option value='BARRA_1'>BARRA_1</option>");
        $('#DldModalSalidas_destino').append("<option value='BARRA_2'>BARRA_2</option>");
        $('#DldModalSalidas_destino').append("<option value='BARRA_3'>BARRA_3</option>");
        $('#DldModalSalidas_destino').append("<option value='CONSUMO'>CONSUMO</option>");
    }
}

function validar_cantidad(cant){
    var stock=$("#DldModalSalidas_stock").val();
    if(cant==0){
        maquinge.notificaciones('Cantidad debe ser mayor a 0 "cero".', 'Sistema', 'error');
        
        return false;
    }
}

</script>
@endpush
