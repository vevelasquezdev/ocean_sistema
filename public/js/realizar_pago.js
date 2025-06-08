

function realizarPago(){
    id_pedido = $("#DlgOrdenPedido_txt_id_pedido").val();
    if(id_pedido==''){ return maquinge.notificaciones("No hay nada para pagar...", 'OceanClub', 'warning'); } 


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
                $("#DldModalPago").modal('show');        
                $("#DldModalPago_txt_razon_social").val($("#DlgOrdenPedido_txt_raz_soc").val()); //llenar razon social del cliente
                $("#DldModalPago_txt_id_pedido").val($("#DlgOrdenPedido_txt_id_pedido").val()); // llenar codigo de comanda
                
                $("#DldModalPago_txt_monto").val($("#DlgOrdenPedido_txt_ttotal").text());
                $("#DldModalPago_txt_descripcion").val("PAGO MESA "+$("#DlgOrdenPedido_txt_idMesa").val());
               
                
                if(user_name=="CAJA1"){
                    $("#DldModalPago_txt_caja").val(1);
                    $("#DldModalPago_txt_caja").attr("disabled", true);
                }else if(user_name=="CAJA2"){
                    $("#DldModalPago_txt_caja").val(2);
                    $("#DldModalPago_txt_caja").attr("disabled", true);
                }else if(user_name=="CAJA3"){
                    $("#DldModalPago_txt_caja").val(3);
                    $("#DldModalPago_txt_caja").attr("disabled", true);
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


function forma_pago(id_forma_pago){   
    $("#fp_1, #fp_2, #fp_3, #fp_4, #fp_5, #fp_6, #fp_7, #fp_8, #fp_9, #fp_10").hide();
    $("#DldModalPago_txt_efectivo,#DldModalPago_txt_tarjeta,#DldModalPago_txt_yape,#DldModalPago_txt_transferencia,#DldModalPago_txt_credito,#DldModalPago_txt_cupon").val('');
    $("#DldModalPago_txt_efectivo2,#DldModalPago_txt_tarjeta2,#DldModalPago_txt_yape2,#DldModalPago_txt_transferencia2,#DldModalPago_txt_credito2").val('');
    $("#DldModalPago_txt_efectivo3,#DldModalPago_txt_efectivo4,#DldModalPago_txt_efectivo5").val('');
    switch (id_forma_pago) {
        case '1': $("#fp_1").show(); $("#DldModalPago_txt_efectivo").val($("#DlgOrdenPedido_txt_ttotal").text()); break;
        case '2': $("#fp_2").show(); $("#DldModalPago_txt_tarjeta").val($("#DlgOrdenPedido_txt_ttotal").text()); break;
        case '3': $("#fp_3").show(); $("#DldModalPago_txt_yape").val($("#DlgOrdenPedido_txt_ttotal").text()); break;
        case '4': $("#fp_4").show(); $("#DldModalPago_txt_transferencia").val($("#DlgOrdenPedido_txt_ttotal").text()); break;
        case '5': $("#fp_5").show(); $("#DldModalPago_txt_credito").val($("#DlgOrdenPedido_txt_ttotal").text()); break;
        case '6': $("#fp_6").show(); break;
        case '7': $("#fp_7").show(); break;
        case '8': $("#fp_8").show(); break;
        case '9': $("#fp_9").show(); break;
        case '10': $("#fp_10").show(); $("#DldModalPago_txt_cupon").val($("#DlgOrdenPedido_txt_ttotal").text()); break;
        default:  
            return false;
    }
}


function insert_pago_consumo(){
    $('.error_msg_pago').addClass('d-none').text('');
    initApp.playSound(asset+'smartadmin/dist/media/sound', 'bigbox'); 
    var box = bootbox.confirm({
        title: "<i class='fal fa-times-circle text-danger mr-2'></i> ¿ Confirmar pago de mesa ?",
        message: "<span><strong>Advertencia:</strong> Esta accion liberará la mesa y cerrará las ventanas...!</span>",
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
                confirmar_insert();
            }            
        }
    });

    box.on('hidden.bs.modal', function (e) {
        if($('.modal.in')){  $('body').addClass('modal-open');}
    });    
}

function confirmar_insert(){
    MsgDlgLoadAjaxForm("dlg_form_pago");
    var fp = $('#DldModalPago_txt_id_forma_pago').val();

    var formDataPago = new FormData($("#dlg_form_pago")[0]);
    
    formDataPago.append('_token', $('input[name=_token]').val());
    formDataPago.append('caja',$("#DldModalPago_txt_caja").val()); 
    formDataPago.append('razon_social',($("#DldModalPago_txt_razon_social").val()).toUpperCase());
    formDataPago.append('descripcion',($("#DldModalPago_txt_descripcion").val()).toUpperCase());
    formDataPago.append('id_forma_pago',$('#DldModalPago_txt_id_forma_pago').val());
    formDataPago.append('fch_emi',$('#DldModalPago_txt_fch_emi').val());
    formDataPago.append('id_pedido',$('#DldModalPago_txt_id_pedido').val());
    formDataPago.append('monto',$('#DldModalPago_txt_monto').val());

    if(fp==6){
        formDataPago.append('efectivo',$('#DldModalPago_txt_efectivo2').val());
        formDataPago.append('tarjeta',$('#DldModalPago_txt_tarjeta2').val());
    }else if(fp==7){
        formDataPago.append('efectivo',$('#DldModalPago_txt_efectivo3').val());
        formDataPago.append('yape',$('#DldModalPago_txt_yape2').val()); 
    }else if(fp==8){  
        formDataPago.append('efectivo',$('#DldModalPago_txt_efectivo4').val());
        formDataPago.append('transferencia',$('#DldModalPago_txt_transferencia2').val());
    }else if(fp==9){
        formDataPago.append('efectivo',$('#DldModalPago_txt_efectivo5').val());
        formDataPago.append('credito',$('#DldModalPago_txt_credito2').val());    
    }else{
        formDataPago.append('efectivo',$('#DldModalPago_txt_efectivo').val());
        formDataPago.append('tarjeta',$('#DldModalPago_txt_tarjeta').val());
        formDataPago.append('yape',$('#DldModalPago_txt_yape').val());
        formDataPago.append('transferencia',$('#DldModalPago_txt_transferencia').val());
        formDataPago.append('credito',$('#DldModalPago_txt_credito').val());  
    }
    formDataPago.append('cupon',$('#DldModalPago_txt_cupon').val());
    formDataPago.append('id_mesa',$('#DlgOrdenPedido_txt_idMesa').val());
    

    MsgDlgLoadAjaxForm("dlg_form");
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        url: 'movimientosctrl',
        type: 'POST',
        data: formDataPago,
        cache:false,
        contentType: false,
        processData: false,
    }).done(function (data) { 
        if(data.msg=='incorrecto'){
            MsgDlgLoadAjaxFinish("dlg_form_pago");
            maquinge.notificaciones("Monto incorrecto...!", 'Sistema', 'error');
        }else{
            setTimeout(function(){    
                MsgDlgLoadAjaxFinish("dlg_form_pago");
                close_pago();
                close_modal();
            }, 1000);
        }  
          
    }).fail(function (data, jqXHR, textStatus) {
        var response = JSON.parse(data.responseText);            
        $.each( response.errors, function( key, value) {
            $('#error_DldModalPago_txt_' + key).removeClass('d-none').text(value);
        });
        
        initApp.playSound(asset+'smartadmin/dist/media/sound', 'voice_alert');
        MsgDlgLoadAjaxFinish("dlg_form_pago");
    });
}

function close_pago(){
    $('.error_msg_pago').addClass('d-none').text('');  
    $("#DldModalPago_txt_caja").attr("disabled", false);  
    $("#DldModalPago").modal('hide');
    $('#DldModalPago').on('hidden.bs.modal', function () {  
        if($('.modal.in')){  $('body').addClass('modal-open');}
    })
    $("#dlg_form_pago")[0].reset();

    $("#fp_1, #fp_2, #fp_3, #fp_4, #fp_5, #fp_6, #fp_7, #fp_8, #fp_9, #fp_10").hide();
    $("#DldModalPago_txt_efectivo,#DldModalPago_txt_tarjeta,#DldModalPago_txt_yape,#DldModalPago_txt_transferencia,#DldModalPago_txt_credito,#DldModalPago_txt_cupon").val('');
}





// $.ajax({
//     headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
//     url: 'clientes',
//     type: 'post',
//     data: {},
//     cache:false,
//     contentType: false,
//     processData: false,
// }).done(function (data) {  
//     $("#DlgOrdenPedido_txt_id_cli").val(data.id_cli);      
//     maquinge.notificaciones(data.msg, 'OceanClub', 'success');        
// }).fail(function (data, jqXHR, textStatus) {
//     var response = JSON.parse(data.responseText);            
//     $.each( response.errors, function( key, value) {
//         $('#error_DlgOrdenPedido_txt_' + key).removeClass('d-none').text(value);
//     });
//     initApp.playSound(asset+'smartadmin/dist/media/sound', 'voice_alert');
// });