@extends('layouts.app')
@section('titulo') Mesas @endsection


@section('contenido')


<div class="row">
    <div class="col-md-12 col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <span class="fw-300"><i>Mesas</i></span>&nbsp;&nbsp;OceanClub 
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Minimizar"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Maximizar"></button>                    
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    @foreach ($mesas as $mesa)
                        @if ($mesa->estado == 1 && isset($mesa->id_pedido))
                            <div class="btn-group" role="group">
                                <a id="btnGroupVerticalDrop2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="javascript:void(0);" href="javascript:void(0);" class="btn btn-warning btn-lg btn-icon position-relative js-waves-off ml-2 mt-4" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-dark&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="{{ $mesa->rol }}: {{ $mesa->nombre }}">
                                    <i class="fa fa-window-maximize"></i>
                                    <span class="badge border border-light rounded-pill bg-success-700 position-absolute pos-bottom pos-right">{{ $mesa->id }}</span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2" x-placement="bottom-start" style="position: absolute; will-change: top, left; top: 37px; left: 0px;">
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="OpenPedido({{ $mesa->id }},{{ $mesa->id_pedido }},{{ $mesa->id_user }},'{{ $mesa->rol }}')" >Abrir Mesa</a>
                                </div>
                            </div>                           
                        @elseif ($mesa->estado == 1)                        
                            <a href="javascript:void(0);" class="btn btn-danger btn-lg btn-icon position-relative js-waves-off ml-2 mt-4" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-dark&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Realizando pedido.">
                                <i class="fa fa-window-maximize"></i>
                                <span class="badge border border-light rounded-pill bg-success-700 position-absolute pos-bottom pos-right">{{ $mesa->id }}</span>
                            </a>                              
                        @else
                        <div class="btn-group" role="group">
                            <a id="btnGroupVerticalDrop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="javascript:void(0);" class="btn btn-outline-primary btn-lg btn-icon position-relative js-waves-off ml-2 mt-4" title="Mesa Libre">
                                <i class="fa fa-window-maximize"></i>
                                <span class="badge border border-light rounded-pill bg-success-700 position-absolute pos-bottom pos-right">{{ $mesa->id }}</span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" x-placement="bottom-start" style="position: absolute; will-change: top, left; top: 37px; left: 0px;">
                                <a class="dropdown-item" href="javascript:void(0);" onclick="OpenModal_temp({{ $mesa->id }},{{ $mesa->estado }})">Ocupar Mesa</a>
                            </div>
                        </div>                          
                        @endif
                    @endforeach
                </div>
            </div>            
        </div>
    </div>
</div>

<div class="modal fade default-example-modal-right-lg show" id="DlgOrdenPedido" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-right modal-lg" style="max-width: 950px">
        <div class="modal-content">            
                <div class="modal-header">
                    <h5 class="modal-title h4">ESTAS OCUPANDO ESTA MESA</h5>
                    <button onclick="close_modal();" type="button" class="close" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="dlg_form">
                        <div class="form-row pl-3 pr-3">
                            <div class="col-md-11 col-lg-11 col-xl-11">
                                <div class="form-row">
                                    <div class="col-md-2 mb-3">
                                        <label class="form-label" for="DlgOrdenPedido_txt_idMesa">MESA:<span class="text-danger">*</span></label>
                                        <input id="DlgOrdenPedido_txt_idMesa" type="text" class="form-control text-uppercase" style="font-weight: bold;font-size: 26px; height: 37px;border: 0px; background: ghostwhite;color: red;" readonly>
                                        <div id="error_DlgOrdenPedido_txt_idMesa" class="error_msg text-danger d-none"> </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label" for="DlgOrdenPedido_txt_idMesa">CODIGO COMANDA:<span class="text-danger">*</span></label>
                                        <input id="DlgOrdenPedido_txt_id_pedido" type="text" class="form-control text-uppercase" style="font-weight: bold;font-size: 26px; height: 37px;border: 0px; background: ghostwhite;color: red;" readonly>
                                        <input type="hidden" id="DlgOrdenPedido_txt_idPedidoTemp">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="DlgOrdenPedido_txt_id_moso">MOZO:<span class="text-danger">*</span></label>
                                        <input id="DlgOrdenPedido_txt_id_moso" type="text" class="form-control text-uppercase" value="{!! Auth::user()->name !!}" readonly>
                                        <div id="error_DlgOrdenPedido_txt_id_moso" class="error_msg text-danger d-none"> </div>
                                        <input type="hidden" id="DlgOrdenPedido_txt_id_user_mesa">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label" for="DlgOrdenPedido_txt_fecha">FECHA Y HORA: <span class="text-danger">*</span></label>
                                        <input id="DlgOrdenPedido_txt_fecha" type="text" class="form-control text-uppercase" readonly>
                                        {{-- <span class="help-block">Formato: año-mes-dia hh:mm:ss</span>                                                    --}}
                                        <div id="error_DlgOrdenPedido_txt_fecha" class="error_msg text-danger d-none"> </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="accordion accordion-outline" id="js_demo_accordion-3">
                                            <div class="card">
                                                <div class="card-header">
                                                    <a href="javascript:void(0);" class="card-title collapsed pt-2 pb-2" data-toggle="collapse" data-target="#js_demo_accordion-3b" aria-expanded="false">
                                                        <i class="fal fa-user"></i>&nbsp;&nbsp;Cliente
                                                        <span class="ml-auto">
                                                            <span class="collapsed-reveal">
                                                                <i class="fal fa-minus fs-xl"></i>
                                                            </span>
                                                            <span class="collapsed-hidden">
                                                                <i class="fal fa-plus fs-xl"></i>
                                                            </span>
                                                        </span>
                                                    </a>
                                                </div>
                                                <div id="js_demo_accordion-3b" class="collapse" data-parent="#js_demo_accordion-3">
                                                    <div class="card-body">
                                                        <form id="form_cliente">
                                                            <div class="form-row">
                                                                <div class="col-md-4 mb-3">
                                                                    <input id="DlgOrdenPedido_txt_id_cli" type="hidden">
                                                                    <label class="form-label" for="DlgOrdenPedido_txt_ruc">RUC:<span class="text-danger">*</span></label>
                                                                    <input id="DlgOrdenPedido_txt_ruc" type="text" class="form-control text-uppercase">
                                                                    <div id="error_DlgOrdenPedido_txt_ruc" class="error_msg_cli text-danger d-none"> </div>
                                                                </div>
                                                                <div class="col-md-8 mb-3">
                                                                    <label class="form-label" for="DlgOrdenPedido_txt_raz_soc">Razón social:<span class="text-danger">*</span></label>
                                                                    <input id="DlgOrdenPedido_txt_raz_soc" type="text" class="form-control text-uppercase" value="">
                                                                    <div id="error_DlgOrdenPedido_txt_raz_soc" class="error_msg_cli text-danger d-none"> </div>
                                                                </div>
                                                                <div class="col-md-9 mb-3">
                                                                    <label class="form-label" for="DlgOrdenPedido_txt_dir">Dirección:<span class="text-danger">*</span></label>
                                                                    <input id="DlgOrdenPedido_txt_dir" type="text" class="form-control text-uppercase" value="">
                                                                    <div id="error_DlgOrdenPedido_txt_dir" class="error_msg_cli text-danger d-none"> </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <button onclick="insert_cliente();" type="button" class="btn btn-primary waves-effect waves-themed mt-4">
                                                                        Guardar Cliente
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div id="error_dlgIngreso_txt_matricula_id" class="error_msg text-danger d-none"> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label class="form-label" for="DlgOrdenPedido_txt_cant">Cant.:<span class="text-danger">*</span></label>
                                        <input id="DlgOrdenPedido_txt_cant" type="number" min="1" class="form-control text-uppercase pl-2 pr-2" value="1" required>
                                        <div id="error_DlgOrdenPedido_txt_cant" class="error_msg text-danger d-none"> </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="DlgOrdenPedido_txt_des_pro">Descripcion productos:<span class="text-danger">*</span></label>
                                        <input type="text" id="DlgOrdenPedido_txt_des_pro" placeholder="Buscar en carta..." class="typeahead form-control text-uppercase" autocomplete="off"/>
                                        <input id="hidden_DlgOrdenPedido_id_carta" type="hidden" class="form-control text-uppercase" value="">
                                        <div id="error_DlgOrdenPedido_txt_des_pro" class="error_msg text-danger d-none"> </div>                                                  
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label class="form-label" for="DlgOrdenPedido_txt_pre_pro">Precio Unid.<span class="text-danger">*</span></label>
                                        <input id="DlgOrdenPedido_txt_pre_pro" type="text" class="form-control text-uppercase pl-2 pr-2" placeholder="00.00" readonly>
                                        <div id="error_DlgOrdenPedido_txt_pre_pro" class="error_msg text-danger d-none"> </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" onclick="add_item();" class="btn btn-info waves-effect waves-themed mt-4 mb-2 pl-3">
                                            <span class="fal fa-plus-square mr-2"></span>Más</button>
                                    </div>
                                </div> 
                            </div>
                            <div class="col-md-1 col-lg-1 col-xl-1">
                                {{--<a href="javascript:void(0);" class="btn btn-danger btn-icon waves-effect waves-themed mb-2" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-dark&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Eliminar Comanda">
                                    <i class="fa fa-window-close"></i>
                                </a>--}}
                                <a href="javascript:void(0);" onclick="realizarPago();" class="btn btn-success btn-icon waves-effect waves-themed mb-2" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-dark&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Pagar en Caja">
                                    &#36;                                    
                                </a>
                                <a href="javascript:void(0);" id="btn_print_ticket" onclick="print_ticket();" class="btn btn-primary btn-icon waves-effect waves-themed mb-2" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-dark&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Imprimir ticket">
                                    <i class="fal fa-print"></i>
                                </a>
                                <a href="javascript:void(0);" onclick="descuento();" class="btn btn-info btn-icon waves-effect waves-themed mb-2" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-dark&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Descuento">
                                    <i class="fa fa-angle-double-down"></i>
                                </a>
                                <a href="javascript:void(0);" onclick="miselaneo();" class="btn btn-warning btn-icon waves-effect waves-themed mb-2" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-dark&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Miselaneo">
                                    <i class="fa fa-cart-plus"></i>
                                </a>
                            </div>
                            <div class="col-md-12 col-lg-12 col-xl-12 mb-3">
                                <div class="table-responsive">
                                    <table id="tableDynamic_ittems" class="table table-bordered table-hover table-striped w-100">
                                        <thead class="bg-primary-600">
                                            <tr>
                                                <th>id</th>
                                                <th>Cant</th>
                                                <th style="min-width: 150px">Descripcion</th>
                                                <th style="max-width: 35px">Pr.Unid</th>
                                                <th style="max-width: 35px">Pr.Total</th>
                                                <th style="max-width: 25px">Orden</th>
                                                <th>Estado</th>
                                                <th style="min-width: 150px">Comentario</th>
                                                <th>...</th>
                                            </tr>                                                               
                                        </thead>
                                    </table>
                                </div> 
                                <div class="form-row mt-2">
                                    <div class="col-md-3 mb-3">
                                        <h5>SUBTOTAL S/.<span id="DlgOrdenPedido_txt_subttotal" class="badge badge-info"></span></h5>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <h5>IGV (18%):<span id="DlgOrdenPedido_txt_igv" class="badge badge-info"></span></h5>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <h5>TOTAL S/.<span id="DlgOrdenPedido_txt_ttotal" class="badge badge-info"></span></h5>
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </form>   
                </div>
                
                <div class="modal-footer border-faded">
                    <button onclick="close_modal();" type="button" class="btn btn-secondary">CERRAR</button>
                    <button id="BtnGuardarpedido" onclick="guardar_pedido();" type="button" class="btn btn-primary">ENVIAR COMANDA</button>
                    <button id="BtnReenviar" onclick="guardar_pedido();" type="button" class="btn btn-primary">REENVIAR COMANDA</button>
                </div>
        </div>
    </div>
</div>

<div class="modal fade default-example-modal" id="DldModalPago" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="dlg_form_pago">
                <div class="modal-header">
                    <h5 class="modal-title h4">.: PAGAR CONSUMO :.</h5>
                    <button onclick="close_pago();" type="button" class="close" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row pl-3 pr-3">
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="DldModalPago_txt_caja">Caja: <span class="text-danger">*</span> </label>
                            <select id="DldModalPago_txt_caja" class="form-control jquery_field text-uppercase" required>
                                <option value="">Selecciona</option>
                                <option value="1">CAJA_1</option>
                                <option value="2">CAJA_2</option>
                                <option value="3">CAJA_3</option>
                            </select>
                            <div id="error_DldModalPago_txt_caja" class="error_msg_pago text-danger d-none"> </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="DldModalPago_txt_razon_social">Razon Social:<span class="text-danger">*</span></label>
                            <input id="DldModalPago_txt_razon_social" type="text" class="form-control text-uppercase">
                            <div id="error_DldModalPago_txt_razon_social" class="error_msg_pago text-danger d-none"> </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="DldModalPago_txt_id_pedido">Codigo Comanda:<span class="text-danger">*</span></label>
                            <input id="DldModalPago_txt_id_pedido" type="text" class="form-control text-uppercase" style="font-weight: bold;font-size: 26px; height: 37px;border: 0px; background: ghostwhite;color: red;" readonly>
                            <div id="error_DldModalPago_txt_id_pedido" class="error_msg_pago text-danger d-none"> </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="DldModalPago_txt_descripcion">Descripcion: <span class="text-danger">*</span> </label>
                            <input id="DldModalPago_txt_descripcion" type="text" class="form-control jquery_field text-uppercase" required>
                            <div id="error_DldModalPago_txt_descripcion" class="error_msg_pago text-danger d-none"> </div>
                        </div>                                     
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="DldModalPago_txt_id_forma_pago">Forma Pago: <span class="text-danger">*</span> </label>
                            <select id="DldModalPago_txt_id_forma_pago" onchange="forma_pago(this.value)" class="form-control jquery_field text-uppercase" required>
                                <option value="">Selecciona</option>
                                @foreach ($formapagos as $formapago)
                                    <option value="{{$formapago->id}}">{{$formapago->descripcion}}</option>
                                @endforeach
                            </select>
                            <div id="error_DldModalPago_txt_id_forma_pago" class="error_msg_pago text-danger d-none"> </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="DldModalPago_txt_fch_emi">Fecha-Hora Emision: <span class="text-danger">*</span> </label>
                            <input id="DldModalPago_txt_fch_emi" class="form-control jquery_field" type="text" placeholder="" data-inputmask="'mask': '99-99-9999 99:99'" value="{{ date('d-m-Y H:i') }}">
                            <span class="help-block">Ejemplo: 25-06-2022 09:45</span>
                            <div id="error_DldModalPago_txt_fch_emi" class="error_msg_pago text-danger d-none"> </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="DldModalPago_txt_monto">Monto Total S/.<span class="text-danger">*</span></label>
                            <input id="DldModalPago_txt_monto" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)" readonly>
                            <div id="error_DldModalPago_txt_monto" class="error_msg_pago text-danger d-none"> </div>
                        </div>                         
                        <div id="fp_1" class="col-md-6 mb-3" style="display: none">
                            <label class="form-label" for="DldModalPago_txt_efectivo">monto Efectivo S/.<span class="text-danger">*</span></label>
                            <input id="DldModalPago_txt_efectivo" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                            <div id="error_DldModalPago_txt_efectivo" class="error_msg_pago text-danger d-none"> </div>
                        </div>
                        <div id="fp_2" class="col-md-6 mb-3" style="display: none">
                            <label class="form-label" for="DldModalPago_txt_tarjeta">monto Tarjeta S/.<span class="text-danger">*</span></label>
                            <input id="DldModalPago_txt_tarjeta" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                            <div id="error_DldModalPago_txt_tarjeta" class="error_msg_pago text-danger d-none"> </div>
                        </div>
                        <div id="fp_3" class="col-md-6 mb-3" style="display: none">
                            <label class="form-label" for="DldModalPago_txt_yape">monto Yape S/.<span class="text-danger">*</span></label>
                            <input id="DldModalPago_txt_yape" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                            <div id="error_DldModalPago_txt_yape" class="error_msg_pago text-danger d-none"> </div>
                        </div>
                        <div id="fp_4" class="col-md-6 mb-3" style="display: none">
                            <label class="form-label" for="DldModalPago_txt_transferencia">monto Transferencia S/.<span class="text-danger">*</span></label>
                            <input id="DldModalPago_txt_transferencia" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                            <div id="error_DldModalPago_txt_transferencia" class="error_msg_pago text-danger d-none"> </div>
                        </div>
                        <div id="fp_5" class="col-md-6 mb-3" style="display: none">
                            <label class="form-label" for="DldModalPago_txt_credito">monto Credito S/.<span class="text-danger">*</span></label>
                            <input id="DldModalPago_txt_credito" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                            <div id="error_DldModalPago_txt_credito" class="error_msg_pago text-danger d-none"> </div>
                        </div>
                        <div id="fp_6" class="form-row col-md-12 mb-3" style="display: none">
                            <div class="col-md-6">
                                <label class="form-label" for="DldModalPago_txt_efectivo2">monto Efectivo S/.<span class="text-danger">*</span></label>
                                <input id="DldModalPago_txt_efectivo2" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                <div id="error_DldModalPago_txt_efectivo" class="error_msg_pago text-danger d-none"> </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="DldModalPago_txt_tarjeta2">monto Tarjeta S/.<span class="text-danger">*</span></label>
                                <input id="DldModalPago_txt_tarjeta2" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                <div id="error_DldModalPago_txt_tarjeta" class="error_msg_pago text-danger d-none"> </div>
                            </div>
                        </div>
                        <div id="fp_7" class="form-row col-md-12 mb-3" style="display: none">
                            <div class="col-md-6">
                                <label class="form-label" for="DldModalPago_txt_efectivo3">monto Efectivo S/.<span class="text-danger">*</span></label>
                                <input id="DldModalPago_txt_efectivo3" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                <div id="error_DldModalPago_txt_efectivo" class="error_msg_pago text-danger d-none"> </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="DldModalPago_txt_yape2">monto Yape S/.<span class="text-danger">*</span></label>
                                <input id="DldModalPago_txt_yape2" type="text" class="form-control text-uppercase">
                                <div id="error_DldModalPago_txt_yape" class="error_msg_pago text-danger d-none"> </div>
                            </div>
                        </div>
                        <div id="fp_8" class="form-row col-md-12 mb-3" style="display: none">
                            <div class="col-md-6">
                                <label class="form-label" for="DldModalPago_txt_efectivo4">monto Efectivo S/.<span class="text-danger">*</span></label>
                                <input id="DldModalPago_txt_efectivo4" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                <div id="error_DldModalPago_txt_efectivo" class="error_msg_pago text-danger d-none"> </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="DldModalPago_txt_transferencia2">monto Transferencia S/.<span class="text-danger">*</span></label>
                                <input id="DldModalPago_txt_transferencia2" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                <div id="error_DldModalPago_txt_transferencia" class="error_msg_pago text-danger d-none"> </div>
                            </div>
                        </div>
                        <div id="fp_9" class="form-row col-md-12 mb-3" style="display: none">
                            <div class="col-md-6">
                                <label class="form-label" for="DldModalPago_txt_efectivo5">monto Efectivo S/.<span class="text-danger">*</span></label>
                                <input id="DldModalPago_txt_efectivo5" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                <div id="error_DldModalPago_txt_efectivo" class="error_msg_pago text-danger d-none"> </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="DldModalPago_txt_credito2">monto Credito S/.<span class="text-danger">*</span></label>
                                <input id="DldModalPago_txt_credito2" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                <div id="error_DldModalPago_txt_credito" class="error_msg_pago text-danger d-none"> </div>
                            </div>
                        </div>
                        <div id="fp_10" class="col-md-6 mb-3" style="display: none">
                            <label class="form-label" for="DldModalPago_txt_cupon">monto Cupón S/.<span class="text-danger">*</span></label>
                            <input id="DldModalPago_txt_cupon" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                            <div id="error_DldModalPago_txt_cupon" class="error_msg_pago text-danger d-none"> </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-faded">
                    <button onclick="close_pago();" type="button" class="btn btn-secondary">Cerrar</button>
                    <button onclick="insert_pago_consumo();" type="button" class="btn btn-primary">Guardar</button>
                </div>
            </form>            
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/plug-ins/1.10.19/api/sum().js"></script>    
<script src="{{ asset('js/pedido.js') }}"></script>
<script src="{{ asset('js/realizar_pago.js') }}"></script>
<script>

window.onbeforeunload = function(e) { /// al actualizar liberar mesa
    MsgDlgLoadAjaxForm("panel-1");
    if($("#DlgOrdenPedido_txt_id_pedido").val()==""){
        liberar_mesa_borrar_registros_temp();
    }else{
        borrar_registros_orden_no();
    }
    setTimeout(function(){       
        MsgDlgLoadAjaxFinish("panel-1"); 
    }, 200);   
};
var id_user = "{!! Auth::user()->id !!}";
var user_rol = "{!! Auth::user()->rol !!}";
        // var id_user = {!! Auth::id() !!};   
var user_name = "{!! Auth::user()->name !!}";
var contador_check_print=0;
$(document).ready(function() { 
    // setInterval( function() {
        var seconds = new Date().getSeconds();
        var tseconds = ( seconds < 10 ? "0" : "" ) + seconds;            

        var min = new Date().getMinutes();
        var tminu = ( min < 10 ? "0" : "" ) + min;

        var hours = new Date().getHours();
        var thours = ( hours < 10 ? "0" : "" ) + hours;

        var txtDateTime = thours + ":"+ tminu + ":"+ tseconds;
        var todayDate = new Date().toISOString().slice(0, 10);
        $("#DlgOrdenPedido_txt_fecha").val(todayDate + " " +txtDateTime);
        
    // },1000);

    $("#menu_mesas").addClass("active");    
    
    MsgDlgLoadAjaxForm("dlg_form");
    var table = $('#tableDynamic_ittems').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        ajax : "{{ route('table_pedido_detalle_temp') }}"+"?id_pedido_temp=0&id_mesa=0",
        drawCallback: function () {
            var sum = $('#tableDynamic_ittems').DataTable().column(4).data().sum();            
            var subtotal=sum/1.18; 
            var igv = subtotal*0.18;       
            $('#DlgOrdenPedido_txt_ttotal').html(parseFloat(sum).toFixed(2));
            $('#DlgOrdenPedido_txt_subttotal').html(parseFloat(subtotal).toFixed(2));
            $('#DlgOrdenPedido_txt_igv').html(parseFloat(igv).toFixed(2));
        },
        columns: [
            {data: 'id_detalle', name: 'id_detalle',  visible: false, orderable: false, searchable: false}, 
            {data: 'cant', name: 'cant', className:'text-center'},
            {data: 'des_pro', name: 'des_pro'},
            {data: 'pre_pro', name: 'pre_pro',className:'text-right'},
            {data: 'pre_tot', name: 'pre_tot',className:'text-right'},
            {data: 'orden', name: 'orden',className:'text-center'},
            {data: 'est_detalle', name: 'est_detalle',className:'text-center'},
            {data: 'comentario', name: 'comentario'},
            {data: 'action', name: 'action', className:'text-center', orderable: false, searchable: false}
        ], 
        columnDefs: [{targets: 5,
            render: function ( data, type, row ) {
                if(data=="SI"){
                    
                    if(contador_check_print<=0){ $("#btn_print_ticket").show(); contador_check_print=0; 
                    }else{$("#btn_print_ticket").hide(); }

                    console.log(contador_check_print);
                    return "SI";  

                }else if(data=="NO"){
                    contador_check_print=contador_check_print+1;
                    
                    if(contador_check_print<=0){ $("#btn_print_ticket").show(); contador_check_print=0; 
                    }else{$("#btn_print_ticket").hide(); }

                    console.log(contador_check_print);
                    return "NO";
                }else{
                    $("#btn_print_ticket").hide();
                }       
            }
        }],             
        ordering: false,
        bLengthChange: false,
        searching: false,
        bPaginate: false,
        info:false,        
        language: espanol
    });
    setTimeout(function(){ 
        MsgDlgLoadAjaxFinish("dlg_form"); 
    }, 300); 

});

function guardar_pedido(){
    var id_user = "{!! Auth::user()->id !!}";
    var table = $('#tableDynamic_ittems').DataTable();
    var table_length = table.data().count();
    id_pedido_temp = $("#DlgOrdenPedido_txt_idPedidoTemp").val();
    if(table_length==0){
        $("#DlgOrdenPedido_txt_des_pro").focus(); 
        return maquinge.notificaciones("Tabla productos esta vacia...<br> * Agregue productos a la tabla", 'OceanClub', 'warning');        
    }    
   
    MsgDlgLoadAjaxForm("dlg_form");
    $.ajax({        
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        url: 'temp-pedidos/'+id_pedido_temp+'/edit',
        type: 'GET',
        data:{
            "_token": "{{ csrf_token() }}",            
            id_mesa         : $("#DlgOrdenPedido_txt_idMesa").val(),          
            id_user         : id_user,
        }        
    }).done(function(data){
        if(data.msg==0){
            maquinge.notificaciones('No hay nada para reenviar...', 'OceanClub', 'warning');
            MsgDlgLoadAjaxFinish("dlg_form");
        }else{
            maquinge.notificaciones(data.msg, 'OceanClub', 'info');
            $("#DlgOrdenPedido_txt_id_pedido").val(data.id_pedido_temp);
            setTimeout(function(){    
                MsgDlgLoadAjaxFinish("dlg_form");
                close_modal();
            }, 1000);
        }
        
    }).fail( function(data, jqXHR, textStatus, errorThrown ) {
        maquinge.notificaciones(textStatus+" <br>* Base de Datos", 'OceanClub', 'error');        
        initApp.playSound(asset+'smartadmin/dist/media/sound', 'voice_alert');
        MsgDlgLoadAjaxFinish("dlg_form"); 
    });
}

function add_item(){
   
    $('.error_msg').addClass('d-none').text('');
    if($("#DlgOrdenPedido_txt_des_pro").val()=="" || $("#hidden_DlgOrdenPedido_id_carta").val()==""){
        $("#DlgOrdenPedido_txt_des_pro").focus(); 
        return maquinge.notificaciones("Descripcion del producto esta vacia...", 'OceanClub', 'warning');        
    }
    MsgDlgLoadAjaxForm("dlg_form");   
    $.ajax({ 
        cache: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        url: 'temp-pedidos/create',
        type: 'GET',
        data:{            
            id_pedido_temp  : $("#DlgOrdenPedido_txt_idPedidoTemp").val(),         
            cant            : $("#DlgOrdenPedido_txt_cant").val(),
            id_carta        : $("#hidden_DlgOrdenPedido_id_carta").val()           
        },
    }).done(function (data) {
        id_mesa = $("#DlgOrdenPedido_txt_idMesa").val();
        id_pedido_temp = $("#DlgOrdenPedido_txt_idPedidoTemp").val();        
        actualizar_tabla_dinamica(id_pedido_temp,id_mesa,id_user);

        setTimeout(function(){
            $("#DlgOrdenPedido_txt_cant").val('1');
            $("#DlgOrdenPedido_txt_des_pro").val('');
            $("#hidden_DlgOrdenPedido_id_carta").val('');
            $("#DlgOrdenPedido_txt_pre_pro").val('');
            MsgDlgLoadAjaxFinish("dlg_form");
            $("#DlgOrdenPedido_txt_des_pro").focus(); 
        }, 200);
    }).fail(function (jqXHR, textStatus,errorThrown) {
        maquinge.notificaciones(textStatus+" <br>* Base de Datos", 'OceanClub', 'error');     
        initApp.playSound(asset+'smartadmin/dist/media/sound', 'voice_alert');
        MsgDlgLoadAjaxFinish("dlg_form"); 
    });
}

function del_ittem(id_detalle_temp){    
    id_pedido=$("#DlgOrdenPedido_txt_id_pedido").val();
    
    $.ajax({ 
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        url: 'check_orden/'+id_detalle_temp,
        type: 'GET',            
    }).done(function (data) {
        if(data.msg=="NO"){            
            $.ajax({ 
                headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                url: 'temp-pedidos/'+id_detalle_temp,
                type: 'DELETE',
                data:{
                    "_token": "{{ csrf_token() }}",
                    id_detalle_temp : id_detalle_temp,
                    tipo:'ELIMINAR'                        
                },
            }).done(function (data) {
                id_pedido_temp = $("#DlgOrdenPedido_txt_idPedidoTemp").val();
                id_mesa = $("#DlgOrdenPedido_txt_idMesa").val();
                id_user = $("#DlgOrdenPedido_txt_id_user_mesa").val();
                actualizar_tabla_dinamica(id_pedido_temp,id_mesa,id_user);
            }).fail(function (error, jqXHR, textStatus,errorThrown) {
                var errors = error.responseJSON;                        
                if (error.status === 500) {
                    maquinge.notificaciones(errorThrown, 'OceanClub', 'error');
                }
            });
        }else{
            var box = bootbox.prompt({
                title: "¿Porqué eliminas este registro?", 
                centerVertical: true,
                callback: function(result){
                    
                    if(result){
                        $.ajax({ 
                            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                            url: 'temp-pedidos/'+id_detalle_temp,
                            type: 'DELETE',
                            data:{
                                "_token": "{{ csrf_token() }}",
                                id_detalle_temp : id_detalle_temp,
                                des_elim: result,
                                tipo:'NO_ELIMINAR'        
                            },
                        }).done(function (data) {
                            id_pedido_temp = $("#DlgOrdenPedido_txt_idPedidoTemp").val();
                            id_mesa = $("#DlgOrdenPedido_txt_idMesa").val();
                            id_user = $("#DlgOrdenPedido_txt_id_user_mesa").val();
                            actualizar_tabla_dinamica(id_pedido_temp,id_mesa,id_user);                            
                        }).fail(function (error, jqXHR, textStatus,errorThrown) {
                            var errors = error.responseJSON;                        
                            if (error.status === 500) {
                                maquinge.notificaciones(errorThrown, 'OceanClub', 'error');
                            }                          
                        });
                    }
                }
            });
            box.on('hidden.bs.modal', function (e) {
                if($('.modal.in')){  $('body').addClass('modal-open');}
            });

        }

    }).fail(function (error, jqXHR, textStatus,errorThrown) {
        var errors = error.responseJSON;                        
        if (error.status === 500) {
            maquinge.notificaciones(errorThrown, 'OceanClub', 'error');
        }
    });
        
   
        
    
}

function ocupar_mesa(id_mesa){
    var id_user = "{!! Auth::user()->id !!}";
    MsgDlgLoadAjaxForm("dlg_form");
    $.ajax({        
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        url: 'temp-pedidos',
        type: 'POST',
        data:{
            "_token": "{{ csrf_token() }}",
            id_pedido_temp  : $("#DlgOrdenPedido_txt_idPedidoTemp").val(),  
            id_mesa         : id_mesa,          
            id_user         : id_user,
        }        
    }).done(function(data){
        setTimeout(function(){
            $("#DlgOrdenPedido_txt_idPedidoTemp").val(data.id_pedido_temp),
            MsgDlgLoadAjaxFinish("dlg_form"); 
        }, 300);
    }).fail( function(data, jqXHR, textStatus, errorThrown ) {
        maquinge.notificaciones(textStatus+" <br>* Base de Datos", 'OceanClub', 'error');        
        initApp.playSound(asset+'smartadmin/dist/media/sound', 'voice_alert');
        MsgDlgLoadAjaxFinish("dlg_form"); 
    });
}


function OpenModal_temp(id_mesa,estado){
    var id_user = "{!! Auth::user()->id !!}";
    MsgDlgLoadAjaxForm("dlg_form");
    $.ajax({        
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        url: 'mesas/'+id_mesa,
        type: 'GET',
    }).done(function(data){
        if(data.estado==1){           
            maquinge.notificaciones("Mesa ocupada...<br>Actualice la pagina.", 'Sistema', 'warning');                     
        }else{
            $("#BtnGuardarpedido").show();
            $("#BtnReenviar").hide();
            $("#DlgOrdenPedido").modal('show');
            $("#DlgOrdenPedido_txt_idMesa").val(id_mesa);
            id_pedido_temp = $("#DlgOrdenPedido_txt_idPedidoTemp").val();
            ocupar_mesa(id_mesa);            
            actualizar_tabla_dinamica(id_pedido_temp,id_mesa,id_user);//id_user esta en el app
        }
    }).fail( function(data, jqXHR, textStatus, errorThrown ) {
        maquinge.notificaciones(textStatus+" <br>* Base de Datos", 'Sistema', 'error');        
        initApp.playSound(asset+'smartadmin/dist/media/sound', 'voice_alert');
        MsgDlgLoadAjaxFinish("dlg_form"); 
    });
}

function actualizar_tabla_dinamica(id_pedido_temp,id_mesa,id_user){
    contador_check_print=0;
    var id_user = "{!! Auth::user()->id !!}";
    $('#tableDynamic_ittems').DataTable().ajax.url("{{ route('table_pedido_detalle_temp') }}"+"?id_pedido_temp="+id_pedido_temp+"&id_mesa="+id_mesa+"&id_user="+id_user).load();
}

function liberar_mesa_borrar_registros_temp(){
    id_pedido_temp = $("#DlgOrdenPedido_txt_idPedidoTemp").val();
    id_mesa = $("#DlgOrdenPedido_txt_idMesa").val();
    
    MsgDlgLoadAjaxForm("dlg_form");
    $.ajax({        
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        url: 'temp-pedidos/'+id_pedido_temp,
        type: 'GET',
        data:{
            id_mesa: id_mesa
        }            
    }).done(function(data){        
        MsgDlgLoadAjaxFinish("dlg_form");
    }).fail( function(jqXHR, textStatus, errorThrown ) {
        maquinge.notificaciones(textStatus+" <br>* Base de Datos", 'OceanClub', 'error');        
        initApp.playSound(asset+'smartadmin/dist/media/sound', 'voice_alert');
        MsgDlgLoadAjaxFinish("dlg_form");
        
    });
}

function add_comentario(id_detalle_temp){
    
    var box = bootbox.prompt({
        title: "Escribe aqui el comentario...", 
        centerVertical: true,
        backdrop: false,        
        callback: function(result){            
            if(result){
                $.ajax({ 
                    headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                    url: 'add_coment',
                    type: 'GET',
                    data:{                    
                        id_detalle_temp : id_detalle_temp,
                        comentario : result          
                    },
                }).done(function (data) {
                    id_pedido_temp = $("#DlgOrdenPedido_txt_idPedidoTemp").val();
                    id_mesa = $("#DlgOrdenPedido_txt_idMesa").val();
                    actualizar_tabla_dinamica(id_pedido_temp,id_mesa,id_user);
                    $("body").addClass("modal-open");
                }).fail(function (error, jqXHR, textStatus,errorThrown) {
                    var errors = error.responseJSON;                        
                    if (error.status === 500) {
                        maquinge.notificaciones(errorThrown, 'OceanClub', 'error');
                    }                                       
                });                
            }        
        },
        
    });

    box.on('hidden.bs.modal', function (e) {
        if($('.modal.in')){  $('body').addClass('modal-open');}
    });
    
}

function close_modal(){    
    MsgDlgLoadAjaxForm("panel-1");
    if($("#DlgOrdenPedido_txt_id_pedido").val()==""){
        liberar_mesa_borrar_registros_temp();
    }else{
        borrar_registros_orden_no();
    }
    
    setTimeout(function(){
        $("#DlgOrdenPedido").modal('hide');
        $("#dlg_form")[0].reset();
        location.reload();
        MsgDlgLoadAjaxFinish("panel-1"); 
    }, 1000);
}

function borrar_registros_orden_no(){// eliminar pedido orden no
    id_pedido_temp = $("#DlgOrdenPedido_txt_idPedidoTemp").val();    
    
    MsgDlgLoadAjaxForm("dlg_form");
    $.ajax({        
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        url: 'temp-pedidos/'+id_pedido_temp,
        type: 'PUT',
        data:{
            "_token": "{{ csrf_token() }}",
        }                  
    }).done(function(data){        
        MsgDlgLoadAjaxFinish("dlg_form");
    }).fail( function(jqXHR, textStatus, errorThrown ) {
        maquinge.notificaciones(textStatus+" <br>* Base de Datos", 'OceanClub', 'error');        
        initApp.playSound(asset+'smartadmin/dist/media/sound', 'voice_alert');
        MsgDlgLoadAjaxFinish("dlg_form");
        
    });
}

function print_ticket(){
    id_ped_temp= $("#DlgOrdenPedido_txt_id_pedido").val();
    window.open('print_ticket/'+id_ped_temp,"width=400,height=500,scrollbars=NO");
}

function descuento(){
    if(user_rol=='ADMINISTRADOR' ||  user_name=='SADMIN'){ //modal show
        var box2 = bootbox.prompt({
            title: "Ingresa Monto de Descuento:", 
            centerVertical: true,
            backdrop: false,        
            callback: function(result){            
                if(result){
                    MsgDlgLoadAjaxForm("dlg_form");   
                    $.ajax({ 
                        cache: false,
                        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                        url: 'temp-pedidos/create',
                        type: 'GET',
                        data:{            
                            id_pedido_temp  : $("#DlgOrdenPedido_txt_idPedidoTemp").val(),       
                            cant            : 1,
                            tipo            : 'DESCUENTO',
                            descuento       : result          
                        }
                    }).done(function (data) {
                        id_mesa = $("#DlgOrdenPedido_txt_idMesa").val();
                        id_pedido_temp = $("#DlgOrdenPedido_txt_idPedidoTemp").val();        
                        actualizar_tabla_dinamica(id_pedido_temp,id_mesa,id_user);

                        setTimeout(function(){ MsgDlgLoadAjaxFinish("dlg_form"); }, 200);

                    }).fail(function (jqXHR, textStatus,errorThrown) {
                        maquinge.notificaciones(textStatus+" <br>* Base de Datos", 'OceanClub', 'error');     
                        initApp.playSound(asset+'smartadmin/dist/media/sound', 'voice_alert');
                        MsgDlgLoadAjaxFinish("dlg_form"); 
                    });               
                }        
            },
            
        });

        box2.on('hidden.bs.modal', function (e) {
            if($('.modal.in')){  $('body').addClass('modal-open');}
        });

    }else{
        return maquinge.notificaciones("No tienes permiso para realizar Descuento...", 'OceanClub', 'warning');
    }
}

function miselaneo(){
    var box2 = bootbox.prompt({
        title: "Ingresa el Monto:", 
        centerVertical: true,
        backdrop: false,        
        callback: function(result){            
            if(result){
                MsgDlgLoadAjaxForm("dlg_form");   
                $.ajax({ 
                    cache: false,
                    headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                    url: 'temp-pedidos/create',
                    type: 'GET',
                    data:{            
                        id_pedido_temp  : $("#DlgOrdenPedido_txt_idPedidoTemp").val(),       
                        cant            : 1,
                        tipo            : 'MISELANEO',
                        miselaneo       : result          
                    }
                }).done(function (data) {
                    id_mesa = $("#DlgOrdenPedido_txt_idMesa").val();
                    id_pedido_temp = $("#DlgOrdenPedido_txt_idPedidoTemp").val();        
                    actualizar_tabla_dinamica(id_pedido_temp,id_mesa,id_user);

                    setTimeout(function(){ MsgDlgLoadAjaxFinish("dlg_form"); }, 200);

                }).fail(function (jqXHR, textStatus,errorThrown) {
                    maquinge.notificaciones(textStatus+" <br>* Base de Datos", 'OceanClub', 'error');     
                    initApp.playSound(asset+'smartadmin/dist/media/sound', 'voice_alert');
                    MsgDlgLoadAjaxFinish("dlg_form"); 
                });               
            }        
        },
    });

    box2.on('hidden.bs.modal', function (e) {
        if($('.modal.in')){  $('body').addClass('modal-open');}
    });
}


//BUSCADOR GOOGLE
$('#DlgOrdenPedido_txt_des_pro').typeahead({
    source: function(query, process) {
        objects = [];
        map = {};
        $.getJSON('productos/'+query, null,function ( jsonData ){
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
        $('#hidden_DlgOrdenPedido_id_carta').val(map[item].id);
        $('#DlgOrdenPedido_txt_pre_pro').val(map[item].precio);        
        return map[item].descripcion;
        $('#DlgOrdenPedido_txt_pre_pro').focus();
    }
}); 




</script>

@endpush


