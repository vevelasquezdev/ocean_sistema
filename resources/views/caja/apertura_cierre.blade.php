@extends('layouts.app')
@section('titulo') Apertura y Cierre de Caja @endsection


@section('contenido')

<div class="row">
    <div class="col-md-12 col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    APERTURA Y CIERRE DE CAJA 
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>                    
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="row ml-1 mb-3">
                        <button onclick="OpenModal_apertura_caja();" class="btn btn-primary" data-target='.default-example-modal-right'>
                            Apertura de Caja
                        </button>
                    </div>
                                  
                    <div class="table-responsive">
                        <table id="tableAperturaCierre" class="table table-bordered table-hover table-striped w-100">
                            <thead class="bg-primary-600">
                                <tr>
                                    <th>ID</th>
                                    <th>Estado</th>
                                    <th>Usuario Apertura</th>
                                    <th>Fecha Apertura</th>
                                    <th>Monto Inicial S/.</th>
                                    <th>Usuario Cierre</th>
                                    <th>Fecha Cierre</th>
                                    <th>Monto Total</th>
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

<div class="modal fade default-example-modal" id="DldModalAperturaCaja" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="dlg_form">
                <div class="modal-header">
                    <h5 class="modal-title h4">.: APERTURA DE CAJA :.</h5>
                    <button onclick="close_modal_apertura_caja();" type="button" class="close" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row pl-3 pr-3">                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="DldModalApeCierreCaja_txt_usuario_apertura">Usuario Apertura<span class="text-danger">*</span></label>
                            <input id="DldModalApeCierreCaja_txt_usuario_apertura" type="text" class="form-control text-uppercase" value="{!! Auth::user()->name." ".Auth::user()->surname !!}" readonly>
                            <div id="error_DldModalApeCierreCaja_txt_usuario_apertura" class="error_msg text-danger d-none"> </div>
                        </div>                                
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="DldModalApeCierreCaja_txt_fch_apertura">Fecha - Hora<span class="text-danger">*</span></label>
                            <input id="DldModalApeCierreCaja_txt_fch_apertura" type="text" class="form-control text-uppercase" readonly>
                            <span class="help-block">Formato: año-mes-dia hh:mm:ss</span>
                            <div id="error_DldModalApeCierreCaja_txt_fch_apertura" class="error_msg text-danger d-none"> </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="DldModalApeCierreCaja_txt_monto_inicial">Monto Inicial: S/.<span class="text-danger">*</span> </label>
                            <input id="DldModalApeCierreCaja_txt_monto_inicial" onkeypress="return isNumberKey(event)" type="text" class="form-control text-uppercase" required>
                            <span class="help-block">Formato: 150.00</span>
                            <div id="error_DldModalApeCierreCaja_txt_monto_inicial" class="error_msg text-danger d-none"> </div>
                        </div>                                
                    </div>
                </div>
                <div class="modal-footer">
                    <button onclick="close_modal_apertura_caja();" type="button" class="btn btn-secondary">Cerrar</button>
                    <button onclick="apertura_caja();" type="button" class="btn btn-primary">Guardar</button>
                </div>
            </form>            
        </div>
    </div>
</div>

<div class="modal fade default-example-modal" id="DldModalCierreCaja" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="dlg_form">
                <div class="modal-header">
                    <h5 class="modal-title h4">.: CIERRE DE CAJA :.</h5>
                    <button onclick="close_modal_cierre_caja();" type="button" class="close" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row pl-3 pr-3">
                        <input type="hidden" id="txt_id_ape_cierre">
                        <div class="col-md-12 mb-3">                            
                            <label class="form-label" for="DldModalApeCierreCaja_txt_usuario_cierre">Usuario Cierre<span class="text-danger">*</span></label>
                            <input id="DldModalApeCierreCaja_txt_usuario_cierre" type="text" class="form-control text-uppercase" value="{!! Auth::user()->name." ".Auth::user()->surname !!}" readonly>
                            <div id="error_DldModalApeCierreCaja_txt_usuario_cierre" class="error_msg text-danger d-none"> </div>
                        </div>                                
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="DldModalApeCierreCaja_txt_fch_cierre">Fecha - Hora<span class="text-danger">*</span></label>
                            <input id="DldModalApeCierreCaja_txt_fch_cierre" type="text" class="form-control text-uppercase" readonly>
                            <span class="help-block">Formato: año-mes-dia hh:mm:ss</span>
                            <div id="error_DldModalApeCierreCaja_txt_fch_cierre" class="error_msg text-danger d-none"> </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="DldModalApeCierreCaja_txt_monto_total">Monto Total: S/.<span class="text-danger">*</span> </label>
                            <input id="DldModalApeCierreCaja_txt_monto_total" onkeypress="return isNumberKey(event)" type="text" class="form-control text-uppercase" required>
                            <span class="help-block">Formato: 150.00</span>
                            <div id="error_DldModalApeCierreCaja_txt_monto_total" class="error_msg text-danger d-none"> </div>
                        </div>                                
                    </div>
                </div>
                <div class="modal-footer">
                    <button onclick="close_modal_cierre_caja();" type="button" class="btn btn-secondary">Cerrar</button>
                    <button onclick="cerrar_caja();" type="button" class="btn btn-primary">Guardar</button>
                </div>
            </form>            
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>  

$(function () { 

    setInterval( function() {
        var seconds = new Date().getSeconds();
        var tseconds = ( seconds < 10 ? "0" : "" ) + seconds;            

        var min = new Date().getMinutes();
        var tminu = ( min < 10 ? "0" : "" ) + min;

        var hours = new Date().getHours();
        var thours = ( hours < 10 ? "0" : "" ) + hours;

        var txtDateTime = thours + ":"+ tminu + ":"+ tseconds;
        var todayDate = new Date().toISOString().slice(0, 10);
        $("#DldModalApeCierreCaja_txt_fch_apertura").val(todayDate + " " +txtDateTime);
        $("#DldModalApeCierreCaja_txt_fch_cierre").val(todayDate + " " +txtDateTime);
    },1000);

    $("#menu_caja").addClass("active open");
    $("#submenu_apertura_cierre").addClass("active");   
    var table = $('#tableAperturaCierre').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "apecierrecaja",
        columns: [
            {data: 'id_ape_cierre', name: 'id_ape_cierre', visible:false},
            {data: 'est_ape_cierre', name: 'est_ape_cierre',className: 'text-center'},
            {data: 'user_apertura', name: 'user_apertura'},      
            {data: 'fch_apertura', name: 'fch_apertura', className: 'text-center'},
            {data: 'monto_inicial', name: 'monto_inicial'}, 
            {data: 'user_cierre', name: 'user_cierre'},      
            {data: 'fch_cierre', name: 'fch_cierre', className: 'text-center'},
            {data: 'monto_total', name: 'monto_total'},     
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

function apertura_caja(){
    $('.error_msg').addClass('d-none').text('');    
    $.ajax({ 
        cache: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        url: 'apecierrecaja',
        type: 'POST',
        data:{
            "_token": "{{ csrf_token() }}",            
            monto_inicial  : $("#DldModalApeCierreCaja_txt_monto_inicial").val(),                       
        }
    }).done(function (data) {
        $('#tableAperturaCierre').DataTable().ajax.url("apecierrecaja").load();
        if(data.msg==1){
            maquinge.notificaciones('Apertura de caja YA EXISTE!.<br>* para aperturar otra caja espere hasta mañana.', 'Sistema', 'warning');
        }else{
            maquinge.notificaciones(data.msg, 'Sistema', 'success');
        }
        close_modal_apertura_caja();
    }).fail(function (error, jqXHR, textStatus) {
        maquinge.notificaciones(textStatus+" <br>* Base de Datos", 'OceanClub', 'error');
        initApp.playSound(asset+'smartadmin/dist/media/sound', 'voice_alert');
    });
    
}

function OpenModal_apertura_caja(){    
    $("#DldModalAperturaCaja").modal('show');
}

function close_modal_apertura_caja(){  
    $("#DldModalAperturaCaja").modal('hide');    
    $('.error_msg').addClass('d-none').text('');  
    $("#dlg_form")[0].reset();
}

/* cierre de caja*/

function cerrar_caja(){
    id_ape_cierre = $("#txt_id_ape_cierre").val();
    
    $.ajax({ 
        cache: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        url: 'apecierrecaja/'+id_ape_cierre+'/edit',
        type: 'GET',
        data:{
            "_token": "{{ csrf_token() }}",            
            monto_total     : $("#DldModalApeCierreCaja_txt_monto_total").val(),                       
        }
    }).done(function (data) {
        
        $('#tableAperturaCierre').DataTable().ajax.url("apecierrecaja").load();
        maquinge.notificaciones(data.msg, 'OceanClub', 'success');
        close_modal_cierre_caja();
    }).fail(function (error, jqXHR, textStatus) {
        maquinge.notificaciones(textStatus+" <br>* Base de Datos", 'OceanClub', 'error');
        initApp.playSound(asset+'smartadmin/dist/media/sound', 'voice_alert');
    });
}


function OpenModal_cierre_caja(id_ape_cierre){        
    $("#DldModalCierreCaja").modal('show');
    $("#txt_id_ape_cierre").val(id_ape_cierre);

    $.ajax({ 
        cache: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        url: 'apecierrecaja/'+id_ape_cierre,
        type: 'GET',
        data:{
            "_token": "{{ csrf_token() }}",
        }
    }).done(function (data) {        
        $("#DldModalApeCierreCaja_txt_monto_total").val(data.total);
        $('#tableAperturaCierre').DataTable().ajax.url("apecierrecaja").load();
    }).fail(function (error, jqXHR, textStatus) {
        maquinge.notificaciones(textStatus+" <br>* Base de Datos", 'OceanClub', 'error');
        initApp.playSound(asset+'smartadmin/dist/media/sound', 'voice_alert');
    });

}

function close_modal_cierre_caja(){  
    $("#DldModalCierreCaja").modal('hide');    
    $('.error_msg').addClass('d-none').text('');  
    $("#dlg_form")[0].reset();
}

</script>
@endpush
