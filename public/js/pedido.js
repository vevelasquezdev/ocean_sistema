
function OpenPedido(id_mesa,id_pedido_temp, id_user_mesa,rol){    
    
    if(id_user==id_user_mesa || user_rol=='ADMINISTRADOR' || user_rol=='CAJA'){        
        $("#DlgOrdenPedido").modal('show');
        $("#DlgOrdenPedido_txt_idMesa").val(id_mesa);
        $("#DlgOrdenPedido_txt_idPedidoTemp").val(id_pedido_temp);
        $("#DlgOrdenPedido_txt_id_pedido").val(id_pedido_temp);
        $("#DlgOrdenPedido_txt_id_user_mesa").val(id_user_mesa);
        actualizar_tabla_dinamica(id_pedido_temp,id_mesa,id_user_mesa);
        traer_cliente(id_pedido_temp);
        $("#BtnGuardarpedido").hide();
        $("#BtnReenviar").show();
        
        
    }else{  
        return maquinge.notificaciones("No puede acceder a esa mesa", 'OceanClub', 'warning');
    }
}

function actualizar_tabla(id_pedido,id_mesa,id_user){
    console.log(id_pedido+'  --  '+id_mesa+'  --  '+id_user);
    $('#tableDynamic_ittems').DataTable().ajax.url("table_pedido_detalle"+"?id_pedido="+id_pedido+"&id_mesa="+id_mesa+"&id_user="+id_user).load();
}

function traer_cliente(id_pedido_temp){ //traer cliente y usuario de pedido
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        url: 'clientes/'+id_pedido_temp,
        type: 'GET',        
    }).done(function (data) {  
        $("#DlgOrdenPedido_txt_id_cli").val(data.id_cli);      
        $("#DlgOrdenPedido_txt_ruc").val(data.ruc);
        $("#DlgOrdenPedido_txt_raz_soc").val(data.raz_soc);
        $("#DlgOrdenPedido_txt_dir").val(data.dir);
        
        $("#DlgOrdenPedido_txt_fecha").val(data.fecha);
        $("#DlgOrdenPedido_txt_id_moso").val(data.name+' '+data.surname);
        $("#DlgOrdenPedido_txt_dir").val(data.dir);
    }).fail(function (jqXHR, textStatus) {
        maquinge.notificaciones(textStatus+" <br>* Base de Datos", 'OceanClub', 'error');
        initApp.playSound(asset+'smartadmin/dist/media/sound', 'voice_alert');
    });
}

function insert_cliente(){
    $('.error_msg_cli').addClass('d-none').text('');

    var formData = new FormData($("#form_cliente")[0]);
    
    formData.append('_token', $('input[name=_token]').val());
    formData.append('id',$('#DlgOrdenPedido_txt_id_cli').val());
    formData.append('ruc',$('#DlgOrdenPedido_txt_ruc').val());
    formData.append('raz_soc',($("#DlgOrdenPedido_txt_raz_soc").val()).toUpperCase());
    formData.append('dir',($("#DlgOrdenPedido_txt_dir").val()).toUpperCase());
    formData.append('id_pedido_temp',$("#DlgOrdenPedido_txt_idPedidoTemp").val());

    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        url: 'clientes',
        type: 'post',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
    }).done(function (data) {  
        $("#DlgOrdenPedido_txt_id_cli").val(data.id_cli);      
        maquinge.notificaciones(data.msg, 'OceanClub', 'success');        
    }).fail(function (data, jqXHR, textStatus) {
        var response = JSON.parse(data.responseText);            
        $.each( response.errors, function( key, value) {
            $('#error_DlgOrdenPedido_txt_' + key).removeClass('d-none').text(value);
        });
        initApp.playSound(asset+'smartadmin/dist/media/sound', 'voice_alert');
    });
}


function eliminar_comanda(){ 
    if(user_rol=='ADMINISTRADOR'){
        cod_comanda=$("#DlgOrdenPedido_txt_id_pedido").val();
        initApp.playSound(asset+'smartadmin/dist/media/sound', 'bigbox'); 
        var boxx = bootbox.confirm({
            title: "<i class='fal fa-times-circle text-danger mr-2'></i> ¿ Está seguro que desea eliminar esta Comanda ?",
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
                        url: 'mesas/'+cod_comanda,
                        type: 'DELETE',
                        data:{
                            "_token": $('input[name=_token]').val(),
                            'id_mesa': $("#DlgOrdenPedido_txt_idMesa").val()
                        } 
                    }).done(function (data) {  
                        close_modal();
                        maquinge.notificaciones(data.msg, 'OceanClub', 'success');        
                    }).fail(function (data, jqXHR, textStatus) {
                        maquinge.notificaciones(textStatus, 'OceanClub', 'error');
                        initApp.playSound(asset+'smartadmin/dist/media/sound', 'voice_alert');
                    });
                }            
            }
        });

        boxx.on('hidden.bs.modal', function (e) {
            if($('.modal.in')){  $('body').addClass('modal-open');}
        });

    }else{
        return maquinge.notificaciones("No tiene permiso para eliminar esta Comanda...", 'OceanClub', 'warning');
    }
}
