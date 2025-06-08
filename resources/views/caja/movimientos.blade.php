@extends('layouts.app')
@section('titulo') Ingresos @endsection

@section('contenido')
<div class="row">
    <div class="col-md-12 col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <span class="fw-300"><i>Tablas</i></span>&nbsp;&nbsp;MOVIMIENTOS DE CAJA
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>                    
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <button onclick="OpenModalMovimiento()" class="btn btn-primary">
                                Nuevo Operación
                            </button>            
                        </div>                       
                    </div>
              
                    <div class="table-responsive">
                        <table id="tableMovimientos" class="table table-bordered table-hover table-striped w-100">
                            <thead class="bg-primary-600">
                                <tr>
                                    <th>ID</th>
                                    <th>ESTADO</th>
                                    <th>CAJA</th>
                                    <th>FORMA PAGO</th>               
                                    <th>RAZON SOCIAL</th>
                                    <th style="min-width: 200px">DESCRIPCION</th>
                                    <th>MONTO</th>
                                    <th>FECHA</th>
                                    <th>Pdf</th>
                                    <th style="min-width: 180px">Acciones</th>
                                </tr>
                            </thead>                    
                        </table>                                             
                    </div>
                </div>
            </div> 
                    
        </div>
    </div>
</div>

<div class="modal fade default-example-modal-right" id="DldModalIngreso" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-right">
        <div class="modal-content">
            <form id="DlgMovimiento_form">
                <div class="modal-header">
                    <h4 class="modal-title text-primary">.: FORMULARIO MOVIMIENTOS :.</h4>
                    <button onclick="closeModalIngresos();" type="button" class="close" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card mb-g">                        
                        <div class="card-body p-3">
                            <div class="form-row">
                                <input type="hidden" id="DlgMovimiento_txt_id">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="DlgMovimiento_txt_caja">Caja: <span class="text-danger">*</span> </label>
                                    <select id="DlgMovimiento_txt_caja" class="form-control jquery_field text-uppercase" required>
                                        <option value="">Selecciona</option>
                                        <option value="1">CAJA_1</option>
                                        <option value="2">CAJA_2</option>
                                        <option value="3">CAJA_3</option>
                                    </select>
                                    <div id="error_DlgMovimiento_txt_caja" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="DlgMovimiento_txt_razon_social">Razon Social: <span class="text-danger">*</span> </label>
                                    <input id="DlgMovimiento_txt_razon_social" type="text" class="form-control jquery_field text-uppercase" placeholder="Recib&iacute; de ..." required>
                                    <div id="error_DlgMovimiento_txt_razon_social" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="DlgMovimiento_txt_descripcion">Descripcion: <span class="text-danger">*</span> </label>
                                    <input id="DlgMovimiento_txt_descripcion" type="text" class="form-control jquery_field text-uppercase" required>
                                    <div id="error_DlgMovimiento_txt_descripcion" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div class="col-md-7 mb-3">
                                    <label class="form-label" for="DlgMovimiento_txt_id_forma_pago">Forma Pago: <span class="text-danger">*</span> </label>
                                    <select id="DlgMovimiento_txt_id_forma_pago" onchange="forma_pago(this.value)" class="form-control jquery_field text-uppercase" required>
                                        <option value="">Selecciona</option>
                                        @foreach ($formapagos as $formapago)
                                            <option value="{{$formapago->id}}">{{$formapago->descripcion}}</option>
                                        @endforeach
                                    </select>
                                    <div id="error_DlgMovimiento_txt_id_forma_pago" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label class="form-label" for="DlgMovimiento_txt_fch_emi">Fecha-Hora Emision: <span class="text-danger">*</span> </label>
                                    <input id="DlgMovimiento_txt_fch_emi" class="form-control jquery_field" type="text" placeholder="" data-inputmask="'mask': '99-99-9999 99:99'" value="{{ date('d-m-Y H:i') }}">
                                    <span class="help-block">Ejemplo: 17-04-2100 09:45</span>
                                    <div id="error_DlgMovimiento_txt_fch_emi" class="error_msg text-danger d-none"> </div>
                                </div>                                                         
                                <div id="fp_1" class="col-md-6 mb-3" style="display: none">
                                    <label class="form-label" for="DlgMovimiento_txt_efectivo">monto Efectivo S/.<span class="text-danger">*</span></label>
                                    <input id="DlgMovimiento_txt_efectivo" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                    <div id="error_DlgMovimiento_txt_efectivo" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div id="fp_2" class="col-md-6 mb-3" style="display: none">
                                    <label class="form-label" for="DlgMovimiento_txt_tarjeta">monto Tarjeta S/.<span class="text-danger">*</span></label>
                                    <input id="DlgMovimiento_txt_tarjeta" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                    <div id="error_DlgMovimiento_txt_tarjeta" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div id="fp_3" class="col-md-6 mb-3" style="display: none">
                                    <label class="form-label" for="DlgMovimiento_txt_yape">monto Yape S/.<span class="text-danger">*</span></label>
                                    <input id="DlgMovimiento_txt_yape" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                    <div id="error_DlgMovimiento_txt_yape" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div id="fp_4" class="col-md-6 mb-3" style="display: none">
                                    <label class="form-label" for="DlgMovimiento_txt_transferencia">monto Transferencia S/.<span class="text-danger">*</span></label>
                                    <input id="DlgMovimiento_txt_transferencia" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                    <div id="error_DlgMovimiento_txt_transferencia" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div id="fp_5" class="col-md-6 mb-3" style="display: none">
                                    <label class="form-label" for="DlgMovimiento_txt_credito">monto Credito S/.<span class="text-danger">*</span></label>
                                    <input id="DlgMovimiento_txt_credito" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                    <div id="error_DlgMovimiento_txt_credito" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div id="fp_6" class="form-row col-md-12 mb-3" style="display: none">
                                    <div class="col-md-6">
                                        <label class="form-label" for="DlgMovimiento_txt_efectivo2">monto Efectivo S/.<span class="text-danger">*</span></label>
                                        <input id="DlgMovimiento_txt_efectivo2" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                        <div id="error_DlgMovimiento_txt_efectivo" class="error_msg text-danger d-none"> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="DlgMovimiento_txt_tarjeta2">monto Tarjeta S/.<span class="text-danger">*</span></label>
                                        <input id="DlgMovimiento_txt_tarjeta2" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                        <div id="error_DlgMovimiento_txt_tarjeta" class="error_msg text-danger d-none"> </div>
                                    </div>
                                </div>
                                <div id="fp_7" class="form-row col-md-12 mb-3" style="display: none">
                                    <div class="col-md-6">
                                        <label class="form-label" for="DlgMovimiento_txt_efectivo3">monto Efectivo S/.<span class="text-danger">*</span></label>
                                        <input id="DlgMovimiento_txt_efectivo3" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                        <div id="error_DlgMovimiento_txt_efectivo" class="error_msg text-danger d-none"> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="DlgMovimiento_txt_yape2">monto Yape S/.<span class="text-danger">*</span></label>
                                        <input id="DlgMovimiento_txt_yape2" type="text" class="form-control text-uppercase">
                                        <div id="error_DlgMovimiento_txt_yape" class="error_msg text-danger d-none"> </div>
                                    </div>
                                </div>
                                <div id="fp_8" class="form-row col-md-12 mb-3" style="display: none">
                                    <div class="col-md-6">
                                        <label class="form-label" for="DlgMovimiento_txt_efectivo4">monto Efectivo S/.<span class="text-danger">*</span></label>
                                        <input id="DlgMovimiento_txt_efectivo4" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                        <div id="error_DlgMovimiento_txt_efectivo" class="error_msg text-danger d-none"> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="DlgMovimiento_txt_transferencia2">monto Transferencia S/.<span class="text-danger">*</span></label>
                                        <input id="DlgMovimiento_txt_transferencia2" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                        <div id="error_DlgMovimiento_txt_transferencia" class="error_msg text-danger d-none"> </div>
                                    </div>
                                </div>
                                <div id="fp_9" class="form-row col-md-12 mb-3" style="display: none">
                                    <div class="col-md-6">
                                        <label class="form-label" for="DlgMovimiento_txt_efectivo5">monto Efectivo S/.<span class="text-danger">*</span></label>
                                        <input id="DlgMovimiento_txt_efectivo5" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                        <div id="error_DlgMovimiento_txt_efectivo" class="error_msg text-danger d-none"> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="DlgMovimiento_txt_credito2">monto Credito S/.<span class="text-danger">*</span></label>
                                        <input id="DlgMovimiento_txt_credito2" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                        <div id="error_DlgMovimiento_txt_credito" class="error_msg text-danger d-none"> </div>
                                    </div>
                                </div>
                                <div id="fp_10" class="col-md-6 mb-3" style="display: none">
                                    <label class="form-label" for="DlgMovimiento_txt_cupon">monto Cupón S/.<span class="text-danger">*</span></label>
                                    <input id="DlgMovimiento_txt_cupon" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                    <div id="error_DlgMovimiento_txt_cupon" class="error_msg text-danger d-none"> </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button onclick="closeModalIngresos();" type="button" class="btn btn-secondary">Cerrar</button>
                    <button onclick="guardar_movimiento();" id="DlgMovimiento_btn_guardar" type="button" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script> 
$(function () { 
    
    $("#menu_caja").addClass("active open");
    $("#submenu_caja_ingresos").addClass("active");
    $.fn.dataTableExt.sErrMode = 'throw';
    $('#tableMovimientos').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "{!! route('movimientos.list') !!}",
        columns: [
            {data: 'id', name: 'id', visible: false, orderable: false, searchable: false},
            {data: 'estado', name: 'estado',className:"text-center", width: '20px'},
            {data: 'caja', name: 'caja',className: 'text-center'},
            {data: 'desc_forma_pago', name: 'categoria'},
            {data: 'razon_social', name: 'razon_social'},
            {data: 'descripcion', name: 'descripcion'},
            {data: 'monto', name: 'monto'},
            {data: 'fch_emi', name: 'fch_emi',className: 'text-center'},
            {data: 'pdf', name: 'pdf'},
            {data: 'action', name: 'action',width: '140px', orderable: false, searchable: false},
        ],
        dom: dom_buttons_table,
        buttons: [{
            extend: 'pdfHtml5',
            orientation: 'portrait',
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
   
});

function OpenModalMovimiento(){
   
    var user_rol = "{!! Auth::user()->rol !!}";
    var user_name = "{!! Auth::user()->name !!}";
    if(user_rol=='ADMINISTRADOR' ||  user_rol=='CAJA'){ //modal show
        $.ajax({ 
            cache: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            url: 'check-apertura-caja',
            type: 'GET',
            data:{"_token": "{{ csrf_token() }}",}
        }).done(function (data) {
            if(data.msg==0){
                return maquinge.notificaciones("Caja no esta abierta!<br>* Se requiere apertura de caja.", 'OceanClub', 'warning');
            }else{
                $("#DldModalIngreso").modal('show');    
                $("#DlgMovimiento_btn_guardar").prop("disabled",false);
                $('input[type="text"], select, textarea').prop("disabled",false);  
                
                if(user_name=="CAJA1"){
                    $("#DlgMovimiento_txt_caja").val(1);
                    $("#DlgMovimiento_txt_caja").prop("disabled", true);
                }else if(user_name=="CAJA2"){
                    $("#DlgMovimiento_txt_caja").val(2);
                    $("#DlgMovimiento_txt_caja").prop("disabled", true);
                }else if(user_name=="CAJA3"){
                    $("#DlgMovimiento_txt_caja").val(3);
                    $("#DlgMovimiento_txt_caja").prop("disabled", true);
                }
            }             
        }).fail(function (error, jqXHR, textStatus) {
            maquinge.notificaciones(textStatus, 'OceanClub', 'error');
            initApp.playSound(asset+'smartadmin/dist/media/sound', 'voice_alert');
        });

    }else{
        return maquinge.notificaciones("No tienes permiso para Pagar...<br>* Dirígete a caja para realizar este pago...", 'OceanClub', 'warning');
    }  
}


function guardar_movimiento(){
    $('.error_msg').addClass('d-none').text('');

    var fp = $('#DlgMovimiento_txt_id_forma_pago').val();
    
    var formDataPago = new FormData($("#DlgMovimiento_form")[0]);
    formDataPago.append('_token', $('input[name=_token]').val());
    formDataPago.append('id',$("#DlgMovimiento_txt_id").val());
    formDataPago.append('caja',$("#DlgMovimiento_txt_caja").val());    
    formDataPago.append('razon_social',($("#DlgMovimiento_txt_razon_social").val()).toUpperCase());
    formDataPago.append('descripcion',($("#DlgMovimiento_txt_descripcion").val()).toUpperCase());
    formDataPago.append('id_forma_pago',$('#DlgMovimiento_txt_id_forma_pago').val());
    formDataPago.append('fch_emi',$('#DlgMovimiento_txt_fch_emi').val());   

    if(fp==6){
        formDataPago.append('efectivo',$('#DlgMovimiento_txt_efectivo2').val());
        formDataPago.append('tarjeta',$('#DlgMovimiento_txt_tarjeta2').val());
    }else if(fp==7){
        formDataPago.append('efectivo',$('#DlgMovimiento_txt_efectivo3').val());
        formDataPago.append('yape',$('#DlgMovimiento_txt_yape2').val()); 
    }else if(fp==8){  
        formDataPago.append('efectivo',$('#DlgMovimiento_txt_efectivo4').val());
        formDataPago.append('transferencia',$('#DlgMovimiento_txt_transferencia2').val());
    }else if(fp==9){
        formDataPago.append('efectivo',$('#DlgMovimiento_txt_efectivo5').val());
        formDataPago.append('credito',$('#DlgMovimiento_txt_credito2').val());    
    }else{
        formDataPago.append('efectivo',$('#DlgMovimiento_txt_efectivo').val());
        formDataPago.append('tarjeta',$('#DlgMovimiento_txt_tarjeta').val());
        formDataPago.append('yape',$('#DlgMovimiento_txt_yape').val());
        formDataPago.append('transferencia',$('#DlgMovimiento_txt_transferencia').val());
        formDataPago.append('credito',$('#DlgMovimiento_txt_credito').val());
        formDataPago.append('cupon',$('#DlgMovimiento_txt_cupon').val()); 
    }

    MsgDlgLoadAjaxForm("DlgMovimiento_form");
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        url: 'insert-movimiento',
        type: 'POST',
        data: formDataPago,
        cache:false,
        contentType: false,
        processData: false,
    }).done(function (data) {  
        setTimeout(function(){    
            MsgDlgLoadAjaxFinish("DlgMovimiento_form");
            closeModalIngresos();
        }, 1000);      
        $('#tableMovimientos').DataTable().ajax.url("{!! route('movimientos.list') !!}").load();
        maquinge.notificaciones(data.msg, 'Sistema.', 'success');        
    }).fail(function (data, jqXHR, textStatus) {
        var response = JSON.parse(data.responseText);   
        $.each( response.errors, function( key, value) {
            $('#error_DlgMovimiento_txt_' + key).removeClass('d-none').text(value);
        });
        if (data.status === 500) {
            maquinge.notificaciones('Error interno comun&iacute;quese con el &aacute;rea de sistemas', 'Sistema', 'error');
        } 
        initApp.playSound(asset+'smartadmin/dist/media/sound', 'voice_alert');
        MsgDlgLoadAjaxFinish("DlgMovimiento_form");
    });
}


function getDataMovimiento(id, type){    
    MsgDlgLoadAjaxForm("DlgMovimiento_form");    
    $.ajax({        
        url: 'movimientosctrl/'+id+'/edit',
        type: 'GET',        
    }).done(function(data){
        $("#DlgMovimiento_txt_id").val(data[0].id);  
        $("#DlgMovimiento_txt_caja").val(data[0].caja);      
        $("#DlgMovimiento_txt_razon_social").val(data[0].razon_social);
        $("#DlgMovimiento_txt_descripcion").val(data[0].descripcion);        
        $("#DlgMovimiento_txt_id_forma_pago").val(data[0].id_forma_pago);        
        $("#DlgMovimiento_txt_fch_emi").val(data[0].fch_emi);

        idd_forma_pago = data[0].id_forma_pago;
       
        switch (idd_forma_pago) {
            case 1: $("#fp_1").show(); $("#DlgMovimiento_txt_efectivo").val(data[0].efectivo); break;
            case 2: $("#fp_2").show(); $("#DlgMovimiento_txt_tarjeta").val(data[0].tarjeta); break;
            case 3: $("#fp_3").show(); $("#DlgMovimiento_txt_yape").val(data[0].yape); break;
            case 4: $("#fp_4").show(); $("#DlgMovimiento_txt_transferencia").val(data[0].transferencia); break;
            case 5: $("#fp_5").show(); $("#DlgMovimiento_txt_credito").val(data[0].credito); break;
            case 6: $("#fp_6").show(); 
                $("#DlgMovimiento_txt_efectivo2").val(data[0].efectivo);
                $("#DlgMovimiento_txt_tarjeta2").val(data[0].tarjeta);
                break;
            case 7: $("#fp_7").show(); 
                $("#DlgMovimiento_txt_efectivo3").val(data[0].efectivo);
                $("#DlgMovimiento_txt_yape2").val(data[0].yape);
                break;
            case 8: $("#fp_8").show(); 
                $("#DlgMovimiento_txt_efectivo4").val(data[0].efectivo);
                $("#DlgMovimiento_txt_transferencia2").val(data[0].transferencia);
                break;
            case 9: $("#fp_9").show(); 
                $("#DlgMovimiento_txt_efectivo5").val(data[0].efectivo);
                $("#DlgMovimiento_txt_credito2").val(data[0].credito);
                break;
            case 10: $("#fp_10").show(); $("#DlgMovimiento_txt_cupon").val(data[0].cupon); break;            
        }

        setTimeout(function(){
            MsgDlgLoadAjaxFinish("DlgMovimiento_form"); 
        }, 500);
    }).fail( function(error, jqXHR, textStatus, errorThrown ) {
        var errors = error.responseJSON;                        
            if (error.status === 500) {
                maquinge.notificaciones(errors.msg, 'Sistema', 'error');  }
        MsgDlgLoadAjaxFinish("DlgMovimiento_form"); 
    });

    if(type=="view"){
        $('input[type="text"], select, textarea').prop("disabled",true);
        $("#DlgMovimiento_btn_guardar").prop("disabled",true);
    }else{
        $('input[type="text"], select, textarea').prop("disabled",false);
        $("#DlgMovimiento_btn_guardar").prop("disabled",false);
    }
}


function forma_pago(id_forma_pago){   
    $("#fp_1, #fp_2, #fp_3, #fp_4, #fp_5, #fp_6, #fp_7, #fp_8, #fp_9, #fp_10").hide();
    $("#DlgMovimiento_txt_efectivo,#DlgMovimiento_txt_tarjeta,#DlgMovimiento_txt_yape,#DlgMovimiento_txt_transferencia,#DlgMovimiento_txt_credito,#DlgMovimiento_txt_cupon").val('');
    $("#DlgMovimiento_txt_efectivo2,#DlgMovimiento_txt_tarjeta2,#DlgMovimiento_txt_yape2,#DlgMovimiento_txt_transferencia2,#DlgMovimiento_txt_credito2").val('');
    $("#DlgMovimiento_txt_efectivo3,#DlgMovimiento_txt_efectivo4,#DlgMovimiento_txt_efectivo5").val('');
    switch (id_forma_pago) {
        case '1': $("#fp_1").show(); $("#DlgMovimiento_txt_efectivo").val(); break;
        case '2': $("#fp_2").show(); $("#DlgMovimiento_txt_tarjeta").val(); break;
        case '3': $("#fp_3").show(); $("#DlgMovimiento_txt_yape").val(); break;
        case '4': $("#fp_4").show(); $("#DlgMovimiento_txt_transferencia").val(); break;
        case '5': $("#fp_5").show(); $("#DlgMovimiento_txt_credito").val(); break;
        case '6': $("#fp_6").show(); break;
        case '7': $("#fp_7").show(); break;
        case '8': $("#fp_8").show(); break;
        case '9': $("#fp_9").show(); break;
        case '10': $("#fp_10").show(); $("#DlgMovimiento_txt_cupon").val(); break;
        default:  
            return false;
    }
}


function anular_Movimiento(id){ 
    initApp.playSound(asset+'smartadmin/dist/media/sound', 'bigbox'); 
    bootbox.confirm({
        title: "<i class='fal fa-times-circle text-danger mr-2'></i> ¿ Está seguro que desea Anular Movimiento. ?",
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
                    url: 'movimientosctrl/'+id,
                    type: 'PUT',
                    data:{
                        '_token': $('input[name=_token]').val(),
                    }       
                }).done(function (data) {  
                    $('#tableMovimientos').DataTable().ajax.url("{!! route('movimientos.list') !!}").load();
                }).fail(function (jqXHR, textStatus) {
                    maquinge.notificaciones(textStatus+" <br>* Base de Datos", 'Sistema', 'error');
                    initApp.playSound(asset+'smartadmin/dist/media/sound', 'voice_alert');
                });
                
            }            
        }
    });
}

function eliminar_Movimiento(id){ 
    initApp.playSound(asset+'smartadmin/dist/media/sound', 'bigbox'); 
    bootbox.confirm({
        title: "<i class='fal fa-times-circle text-danger mr-2'></i> ¿ Está seguro de ELIMINAR ESTE REGISTRO... ?",
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
                    url: 'movimientosctrl/'+id,
                    type: 'DELETE',
                    data:{
                        '_token': $('input[name=_token]').val(),
                    }       
                }).done(function (data) {  
                    $('#tableMovimientos').DataTable().ajax.url("{!! route('movimientos.list') !!}").load();
                }).fail(function (jqXHR, textStatus) {
                    maquinge.notificaciones(textStatus+" <br>* Base de Datos", 'Sistema', 'error');
                    initApp.playSound(asset+'smartadmin/dist/media/sound', 'voice_alert');
                });
                
            }            
        }
    });
}

function closeModalIngresos(){
    $("#DldModalIngreso").modal('hide');
    $('.error_msg').addClass('d-none').text('');
    $("#DlgMovimiento_txt_caja").prop("disabled", false);
    $("#DlgMovimiento_txt_id").val('');
    $("#DlgMovimiento_form")[0].reset();
    $("#fp_1, #fp_2, #fp_3, #fp_4, #fp_5, #fp_6, #fp_7, #fp_8, #fp_9, #fp_10").hide();
    $("#DlgMovimiento_txt_efectivo,#DlgMovimiento_txt_tarjeta,#DlgMovimiento_txt_yape,#DlgMovimiento_txt_transferencia,#DlgMovimiento_txt_credito,#DlgMovimiento_txt_cupon").val('');
    $("#DlgMovimiento_txt_efectivo2,#DlgMovimiento_txt_tarjeta2,#DlgMovimiento_txt_yape2,#DlgMovimiento_txt_transferencia2,#DlgMovimiento_txt_credito2").val('');
    $("#DlgMovimiento_txt_efectivo3,#DlgMovimiento_txt_efectivo4,#DlgMovimiento_txt_efectivo5").val('');
}

function print_ticket(id_ped_temp){
    window.open('print_ticket/'+id_ped_temp,"width=400,height=500,scrollbars=NO");
}


 
</script>
@endpush