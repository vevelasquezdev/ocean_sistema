@extends('layouts.app')
@section('titulo') Ingresos @endsection

@section('contenido')
<div class="row">
    <div class="col-md-12 col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <span class="fw-300"><i>Tablas</i></span>&nbsp;&nbsp;REGISTRO DE INGRESOS
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>                    
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="form-row">
                        <div class="col-md-3 mb-3 ml-3">
                            <div class="form-group row">
                                <button onclick="OpenModalIngreso()" class="btn btn-primary">
                                    Nuevo Ingreso
                                </button>&nbsp;
                                <button onclick="OpenModalEgreso()" class="btn btn-primary">
                                    Nuevo Egreso
                                </button>
                            </div>                           
                        </div>
                        <div class="col-md-2">                           
                            <div class="form-group row">
                                <label class="col-form-label col-12 col-lg-2 form-label text-lg-right mr-2">Fecha:</label>
                                <div class="col-12 col-lg-9">
                                    <input style="width: 100px" type="text" id="fchselect" class="form-control form-control-sm" value="@php echo date('d-m-Y'); @endphp"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group row">
                                <label class="col-form-label col-12 col-lg-2 form-label text-lg-right">Caja:</label>&nbsp;
                                <div class="col-12 col-lg-9">
                                    <select id="txt_caja_gral" class="form-control text-uppercase" required>
                                        <option value="">Todo</option>
                                        <option value="1">CAJA_1</option>
                                        <option value="2">CAJA_2</option>
                                        <option value="3">CAJA_3</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group row">
                                <label class="col-form-label col-12 col-lg-3 form-label text-lg-right">Total:</label>&nbsp; <h1><span id="txt_ttotal_gral" class="badge badge-info">80.00</span></h1>
                            </div>
                          
                        </div>
                        
                    </div>
              
                    <div class="table-responsive">
                        <table id="tableIngresos" class="table table-bordered table-hover table-striped w-100">
                            <thead class="bg-primary-600">
                                <tr>
                                    <th>ID</th>
                                    <th>ESTADO</th>
                                    <th>CAJA</th>
                                    <th>FORMA PAGO</th>
                                    <th>CATEGORIA</th>
                                    <th>MESA</th>                                   
                                    <th>RAZON SOCIAL</th>
                                    <th>DESCRIPCION</th>
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
            <form id="DlgIngreso_form">
                <div class="modal-header">
                    <h4 class="modal-title text-primary">.: INGRESOS :.</h4>
                    <button onclick="closeModalIngresos();" type="button" class="close" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card mb-g">                        
                        <div class="card-body p-3">
                            <div class="form-row">
                                <input type="hidden" id="DlgIngreso_txt_id">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="DlgIngreso_txt_caja">Caja: <span class="text-danger">*</span> </label>
                                    <select id="DlgIngreso_txt_caja" class="form-control jquery_field text-uppercase" required>
                                        <option value="">Selecciona</option>
                                        <option value="1">CAJA_1</option>
                                        <option value="2">CAJA_2</option>
                                        <option value="3">CAJA_3</option>
                                    </select>
                                    <div id="error_DlgIngreso_txt_caja" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="DlgIngreso_txt_razon_social">Razon Social: <span class="text-danger">*</span> </label>
                                    <input id="DlgIngreso_txt_razon_social" type="text" class="form-control jquery_field text-uppercase" placeholder="Recib&iacute; de ..." required>
                                    <div id="error_DlgIngreso_txt_razon_social" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="DlgIngreso_txt_descripcion">Descripcion: <span class="text-danger">*</span> </label>
                                    <input id="DlgIngreso_txt_descripcion" type="text" class="form-control jquery_field text-uppercase" required>
                                    <div id="error_DlgIngreso_txt_descripcion" class="error_msg text-danger d-none"> </div>
                                </div>                                
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="DlgIngreso_txt_id_ingre_cat">Categoria Ingreso: <span class="text-danger">*</span> </label>
                                    <select id="DlgIngreso_txt_id_ingre_cat" class="form-control jquery_field text-uppercase" required>
                                        <option value="">Selecciona</option>
                                        @foreach ($categorias_in as $cat)
                                            <option value="{{$cat->id_ingre_cat}}">{{$cat->desc_ingre_cat}}</option>
                                        @endforeach
                                    </select>
                                    <div id="error_DlgIngreso_txt_id_ingre_cat" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div class="col-md-7 mb-3">
                                    <label class="form-label" for="DlgIngreso_txt_id_forma_pago">Forma Pago: <span class="text-danger">*</span> </label>
                                    <select id="DlgIngreso_txt_id_forma_pago" onchange="forma_pago(this.value)" class="form-control jquery_field text-uppercase" required>
                                        <option value="">Selecciona</option>
                                        @foreach ($formapagos as $formapago)
                                            <option value="{{$formapago->id}}">{{$formapago->descripcion}}</option>
                                        @endforeach
                                    </select>
                                    <div id="error_DlgIngreso_txt_id_forma_pago" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label class="form-label" for="DlgIngreso_txt_fch_emi">Fecha-Hora Emision: <span class="text-danger">*</span> </label>
                                    <input id="DlgIngreso_txt_fch_emi" class="form-control jquery_field" type="text" placeholder="" data-inputmask="'mask': '99-99-9999 99:99'" value="{{ date('d-m-Y H:i') }}">
                                    <span class="help-block">Ejemplo: 17-04-2100 09:45</span>
                                    <div id="error_DlgIngreso_txt_fch_emi" class="error_msg text-danger d-none"> </div>
                                </div>                                                         
                                <div id="fp_1" class="col-md-6 mb-3" style="display: none">
                                    <label class="form-label" for="DlgIngreso_txt_efectivo">monto Efectivo S/.<span class="text-danger">*</span></label>
                                    <input id="DlgIngreso_txt_efectivo" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                    <div id="error_DlgIngreso_txt_efectivo" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div id="fp_2" class="col-md-6 mb-3" style="display: none">
                                    <label class="form-label" for="DlgIngreso_txt_tarjeta">monto Tarjeta S/.<span class="text-danger">*</span></label>
                                    <input id="DlgIngreso_txt_tarjeta" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                    <div id="error_DlgIngreso_txt_tarjeta" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div id="fp_3" class="col-md-6 mb-3" style="display: none">
                                    <label class="form-label" for="DlgIngreso_txt_yape">monto Yape S/.<span class="text-danger">*</span></label>
                                    <input id="DlgIngreso_txt_yape" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                    <div id="error_DlgIngreso_txt_yape" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div id="fp_4" class="col-md-6 mb-3" style="display: none">
                                    <label class="form-label" for="DlgIngreso_txt_transferencia">monto Transferencia S/.<span class="text-danger">*</span></label>
                                    <input id="DlgIngreso_txt_transferencia" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                    <div id="error_DlgIngreso_txt_transferencia" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div id="fp_5" class="col-md-6 mb-3" style="display: none">
                                    <label class="form-label" for="DlgIngreso_txt_credito">monto Credito S/.<span class="text-danger">*</span></label>
                                    <input id="DlgIngreso_txt_credito" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                    <div id="error_DlgIngreso_txt_credito" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div id="fp_6" class="form-row col-md-12 mb-3" style="display: none">
                                    <div class="col-md-6">
                                        <label class="form-label" for="DlgIngreso_txt_efectivo2">monto Efectivo S/.<span class="text-danger">*</span></label>
                                        <input id="DlgIngreso_txt_efectivo2" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                        <div id="error_DlgIngreso_txt_efectivo" class="error_msg text-danger d-none"> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="DlgIngreso_txt_tarjeta2">monto Tarjeta S/.<span class="text-danger">*</span></label>
                                        <input id="DlgIngreso_txt_tarjeta2" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                        <div id="error_DlgIngreso_txt_tarjeta" class="error_msg text-danger d-none"> </div>
                                    </div>
                                </div>
                                <div id="fp_7" class="form-row col-md-12 mb-3" style="display: none">
                                    <div class="col-md-6">
                                        <label class="form-label" for="DlgIngreso_txt_efectivo3">monto Efectivo S/.<span class="text-danger">*</span></label>
                                        <input id="DlgIngreso_txt_efectivo3" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                        <div id="error_DlgIngreso_txt_efectivo" class="error_msg text-danger d-none"> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="DlgIngreso_txt_yape2">monto Yape S/.<span class="text-danger">*</span></label>
                                        <input id="DlgIngreso_txt_yape2" type="text" class="form-control text-uppercase">
                                        <div id="error_DlgIngreso_txt_yape" class="error_msg text-danger d-none"> </div>
                                    </div>
                                </div>
                                <div id="fp_8" class="form-row col-md-12 mb-3" style="display: none">
                                    <div class="col-md-6">
                                        <label class="form-label" for="DlgIngreso_txt_efectivo4">monto Efectivo S/.<span class="text-danger">*</span></label>
                                        <input id="DlgIngreso_txt_efectivo4" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                        <div id="error_DlgIngreso_txt_efectivo" class="error_msg text-danger d-none"> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="DlgIngreso_txt_transferencia2">monto Transferencia S/.<span class="text-danger">*</span></label>
                                        <input id="DlgIngreso_txt_transferencia2" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                        <div id="error_DlgIngreso_txt_transferencia" class="error_msg text-danger d-none"> </div>
                                    </div>
                                </div>
                                <div id="fp_9" class="form-row col-md-12 mb-3" style="display: none">
                                    <div class="col-md-6">
                                        <label class="form-label" for="DlgIngreso_txt_efectivo5">monto Efectivo S/.<span class="text-danger">*</span></label>
                                        <input id="DlgIngreso_txt_efectivo5" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                        <div id="error_DlgIngreso_txt_efectivo" class="error_msg text-danger d-none"> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="DlgIngreso_txt_credito2">monto Credito S/.<span class="text-danger">*</span></label>
                                        <input id="DlgIngreso_txt_credito2" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                        <div id="error_DlgIngreso_txt_credito" class="error_msg text-danger d-none"> </div>
                                    </div>
                                </div>
                                <div id="fp_10" class="col-md-6 mb-3" style="display: none">
                                    <label class="form-label" for="DlgIngreso_txt_cupon">monto Cupón S/.<span class="text-danger">*</span></label>
                                    <input id="DlgIngreso_txt_cupon" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                    <div id="error_DlgIngreso_txt_cupon" class="error_msg text-danger d-none"> </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button onclick="closeModalIngresos();" type="button" class="btn btn-secondary">Cerrar</button>
                    <button onclick="guardar_Ingreso();" id="dlgIngreso_btn_guardar" type="button" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade default-example-modal-right" id="DldModalEgreso" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-right">
        <div class="modal-content">
            <form id="DlgEgreso_form">
                <div class="modal-header">
                    <h4 class="modal-title text-primary">.: EGRESOS :.</h4>
                    <button onclick="closeModalEgresos();" type="button" class="close" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card mb-g">                        
                        <div class="card-body p-3">
                            <div class="form-row">
                                <input type="hidden" id="DlgEgreso_txt_id">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="DlgEgreso_txt_caja">Caja: <span class="text-danger">*</span> </label>
                                    <select id="DlgEgreso_txt_caja" class="form-control jquery_field text-uppercase" required>
                                        <option value="">Selecciona</option>
                                        <option value="1">CAJA_1</option>
                                        <option value="2">CAJA_2</option>
                                        <option value="3">CAJA_3</option>
                                    </select>
                                    <div id="error_DlgEgreso_txt_caja" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="DlgEgreso_txt_razon_social">Razon Social: <span class="text-danger">*</span> </label>
                                    <input id="DlgEgreso_txt_razon_social" type="text" class="form-control jquery_field text-uppercase" placeholder="Se le dará a ..." required>
                                    <div id="error_DlgEgreso_txt_razon_social" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="DlgEgreso_txt_descripcion">Descripcion: <span class="text-danger">*</span> </label>
                                    <input id="DlgEgreso_txt_descripcion" type="text" class="form-control jquery_field text-uppercase" required>
                                    <div id="error_DlgEgreso_txt_descripcion" class="error_msg text-danger d-none"> </div>
                                </div>                                
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="DlgEgreso_txt_id_egre_cat">Categoria Egreso: <span class="text-danger">*</span> </label>
                                    <select id="DlgEgreso_txt_id_egre_cat" class="form-control jquery_field text-uppercase" required>
                                        <option value="">Selecciona</option>
                                        @foreach ($categorias_eg as $cat)
                                            <option value="{{$cat->id_egre_cat}}">{{$cat->desc_egre_cat}}</option>
                                        @endforeach
                                    </select>
                                    <div id="error_DlgEgreso_txt_id_egre_cat" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div class="col-md-7 mb-3">
                                    <label class="form-label" for="DlgEgreso_txt_id_forma_pago">Forma Pago: <span class="text-danger">*</span> </label>
                                    <select id="DlgEgreso_txt_id_forma_pago" onchange="forma_pago(this.value)" class="form-control jquery_field text-uppercase" required>
                                        <option value="">Selecciona</option>
                                        @foreach ($formapagos as $formapago)
                                            <option value="{{$formapago->id}}">{{$formapago->descripcion}}</option>
                                        @endforeach
                                    </select>
                                    <div id="error_DlgEgreso_txt_id_forma_pago" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label class="form-label" for="DlgEgreso_txt_fch_emi">Fecha-Hora Emision: <span class="text-danger">*</span> </label>
                                    <input id="DlgEgreso_txt_fch_emi" class="form-control jquery_field" type="text" placeholder="" data-inputmask="'mask': '99-99-9999 99:99'" value="{{ date('d-m-Y H:i') }}">
                                    <span class="help-block">Ejemplo: 17-04-2100 09:45</span>
                                    <div id="error_DlgEgreso_txt_fch_emi" class="error_msg text-danger d-none"> </div>
                                </div>                                                         
                                <div id="fp_1" class="col-md-6 mb-3" style="display: none">
                                    <label class="form-label" for="DlgEgreso_txt_efectivo">monto Efectivo S/.<span class="text-danger">*</span></label>
                                    <input id="DlgEgreso_txt_efectivo" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                    <div id="error_DlgEgreso_txt_efectivo" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div id="fp_2" class="col-md-6 mb-3" style="display: none">
                                    <label class="form-label" for="DlgEgreso_txt_tarjeta">monto Tarjeta S/.<span class="text-danger">*</span></label>
                                    <input id="DlgEgreso_txt_tarjeta" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                    <div id="error_DlgEgreso_txt_tarjeta" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div id="fp_3" class="col-md-6 mb-3" style="display: none">
                                    <label class="form-label" for="DlgEgreso_txt_yape">monto Yape S/.<span class="text-danger">*</span></label>
                                    <input id="DlgEgreso_txt_yape" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                    <div id="error_DlgEgreso_txt_yape" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div id="fp_4" class="col-md-6 mb-3" style="display: none">
                                    <label class="form-label" for="DlgEgreso_txt_transferencia">monto Transferencia S/.<span class="text-danger">*</span></label>
                                    <input id="DlgEgreso_txt_transferencia" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                    <div id="error_DlgEgreso_txt_transferencia" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div id="fp_5" class="col-md-6 mb-3" style="display: none">
                                    <label class="form-label" for="DlgEgreso_txt_credito">monto Credito S/.<span class="text-danger">*</span></label>
                                    <input id="DlgEgreso_txt_credito" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                    <div id="error_DlgEgreso_txt_credito" class="error_msg text-danger d-none"> </div>
                                </div>
                                <div id="fp_6" class="form-row col-md-12 mb-3" style="display: none">
                                    <div class="col-md-6">
                                        <label class="form-label" for="DlgEgreso_txt_efectivo2">monto Efectivo S/.<span class="text-danger">*</span></label>
                                        <input id="DlgEgreso_txt_efectivo2" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                        <div id="error_DlgEgreso_txt_efectivo" class="error_msg text-danger d-none"> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="DlgEgreso_txt_tarjeta2">monto Tarjeta S/.<span class="text-danger">*</span></label>
                                        <input id="DlgEgreso_txt_tarjeta2" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                        <div id="error_DlgEgreso_txt_tarjeta" class="error_msg text-danger d-none"> </div>
                                    </div>
                                </div>
                                <div id="fp_7" class="form-row col-md-12 mb-3" style="display: none">
                                    <div class="col-md-6">
                                        <label class="form-label" for="DlgEgreso_txt_efectivo3">monto Efectivo S/.<span class="text-danger">*</span></label>
                                        <input id="DlgEgreso_txt_efectivo3" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                        <div id="error_DlgEgreso_txt_efectivo" class="error_msg text-danger d-none"> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="DlgEgreso_txt_yape2">monto Yape S/.<span class="text-danger">*</span></label>
                                        <input id="DlgEgreso_txt_yape2" type="text" class="form-control text-uppercase">
                                        <div id="error_DlgEgreso_txt_yape" class="error_msg text-danger d-none"> </div>
                                    </div>
                                </div>
                                <div id="fp_8" class="form-row col-md-12 mb-3" style="display: none">
                                    <div class="col-md-6">
                                        <label class="form-label" for="DlgEgreso_txt_efectivo4">monto Efectivo S/.<span class="text-danger">*</span></label>
                                        <input id="DlgEgreso_txt_efectivo4" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                        <div id="error_DlgEgreso_txt_efectivo" class="error_msg text-danger d-none"> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="DlgEgreso_txt_transferencia2">monto Transferencia S/.<span class="text-danger">*</span></label>
                                        <input id="DlgEgreso_txt_transferencia2" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                        <div id="error_DlgEgreso_txt_transferencia" class="error_msg text-danger d-none"> </div>
                                    </div>
                                </div>
                                <div id="fp_9" class="form-row col-md-12 mb-3" style="display: none">
                                    <div class="col-md-6">
                                        <label class="form-label" for="DlgEgreso_txt_efectivo5">monto Efectivo S/.<span class="text-danger">*</span></label>
                                        <input id="DlgEgreso_txt_efectivo5" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                        <div id="error_DlgEgreso_txt_efectivo" class="error_msg text-danger d-none"> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="DlgEgreso_txt_credito2">monto Credito S/.<span class="text-danger">*</span></label>
                                        <input id="DlgEgreso_txt_credito2" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                        <div id="error_DlgEgreso_txt_credito" class="error_msg text-danger d-none"> </div>
                                    </div>
                                </div>
                                <div id="fp_10" class="col-md-6 mb-3" style="display: none">
                                    <label class="form-label" for="DlgEgreso_txt_cupon">monto Cupón S/.<span class="text-danger">*</span></label>
                                    <input id="DlgEgreso_txt_cupon" type="text" class="form-control text-uppercase" onkeypress="return isNumberKey(event)">
                                    <div id="error_DlgEgreso_txt_cupon" class="error_msg text-danger d-none"> </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button onclick="closeModalEgresos();" type="button" class="btn btn-secondary">Cerrar</button>
                    <button onclick="guardar_Egreso();" id="dlgEgreso_btn_guardar" type="button" class="btn btn-primary">Guardar</button>
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
    $('#fchselect').datepicker({
                    todayHighlight: true,
                    orientation: "bottom left",
                    templates: controls,
                    format: 'dd-mm-yyyy'
                }); 
    $('#tableIngresos').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "{!! route('ingresos.list') !!}",
        columns: [
            {data: 'id', name: 'id', visible: false, orderable: false, searchable: false},
            {data: 'estado', name: 'estado',className:"text-center", width: '20px'},
            {data: 'caja', name: 'caja',className: 'text-center'},
            {data: 'desc_forma_pago', name: 'categoria'},
            {data: 'categoria', name: 'categoria'},
            {data: 'id_mesa', name: 'id_mesa',className: 'text-center'},
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
                columns: [1,2,3,4,5,6,7,8,9]
            }
        },{
            extend: 'excelHtml5',
            text: 'Excel',
            titleAttr: 'Generate Excel',
            className: 'btn-outline-success btn-sm mr-1',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9]
            }
        }],     
        language: espanol,
        ordering: false,
    });
   
});

function OpenModalIngreso(){
    var user_rol = "{!! Auth::user()->rol !!}";
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
                $("#dlgIngreso_btn_guardar").prop("disabled",false);
                $('input[type="text"], select, textarea').prop("disabled",false);                
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
    $("#DlgIngreso_txt_efectivo,#DlgIngreso_txt_tarjeta,#DlgIngreso_txt_yape,#DlgIngreso_txt_transferencia,#DlgIngreso_txt_credito,#DlgIngreso_txt_cupon").val('');
    $("#DlgIngreso_txt_efectivo2,#DlgIngreso_txt_tarjeta2,#DlgIngreso_txt_yape2,#DlgIngreso_txt_transferencia2,#DlgIngreso_txt_credito2").val('');
    $("#DlgIngreso_txt_efectivo3,#DlgIngreso_txt_efectivo4,#DlgIngreso_txt_efectivo5").val('');
    switch (id_forma_pago) {
        case '1': $("#fp_1").show(); $("#DlgIngreso_txt_efectivo").val($("#DlgOrdenPedido_txt_ttotal").text()); break;
        case '2': $("#fp_2").show(); $("#DlgIngreso_txt_tarjeta").val($("#DlgOrdenPedido_txt_ttotal").text()); break;
        case '3': $("#fp_3").show(); $("#DlgIngreso_txt_yape").val($("#DlgOrdenPedido_txt_ttotal").text()); break;
        case '4': $("#fp_4").show(); $("#DlgIngreso_txt_transferencia").val($("#DlgOrdenPedido_txt_ttotal").text()); break;
        case '5': $("#fp_5").show(); $("#DlgIngreso_txt_credito").val($("#DlgOrdenPedido_txt_ttotal").text()); break;
        case '6': $("#fp_6").show(); break;
        case '7': $("#fp_7").show(); break;
        case '8': $("#fp_8").show(); break;
        case '9': $("#fp_9").show(); break;
        case '10': $("#fp_10").show(); $("#DlgIngreso_txt_cupon").val($("#DlgOrdenPedido_txt_ttotal").text()); break;
        default:  
            return false;
    }
}

function getDataIngreso(id, type){    
    MsgDlgLoadAjaxForm("DlgIngreso_form");    
    $.ajax({        
        url: 'ingresosctrl/'+id+'/edit',
        type: 'GET',        
    }).done(function(data){
        $("#DlgIngreso_txt_id").val(data[0].id);  
        $("#DlgIngreso_txt_caja").val(data[0].caja);      
        $("#DlgIngreso_txt_razon_social").val(data[0].razon_social);
        $("#DlgIngreso_txt_descripcion").val(data[0].descripcion);
        $("#DlgIngreso_txt_id_ingre_cat").val(data[0].id_ingre_cat);
        $("#DlgIngreso_txt_id_forma_pago").val(data[0].id_forma_pago);        
        $("#DlgIngreso_txt_fch_emi").val(data[0].fch_emi);

        idd_forma_pago = data[0].id_forma_pago;
       
        switch (idd_forma_pago) {
            case 1: $("#fp_1").show(); $("#DlgIngreso_txt_efectivo").val(data[0].efectivo); break;
            case 2: $("#fp_2").show(); $("#DlgIngreso_txt_tarjeta").val(data[0].tarjeta); break;
            case 3: $("#fp_3").show(); $("#DlgIngreso_txt_yape").val(data[0].yape); break;
            case 4: $("#fp_4").show(); $("#DlgIngreso_txt_transferencia").val(data[0].transferencia); break;
            case 5: $("#fp_5").show(); $("#DlgIngreso_txt_credito").val(data[0].credito); break;
            case 6: $("#fp_6").show(); 
                $("#DlgIngreso_txt_efectivo2").val(data[0].efectivo);
                $("#DlgIngreso_txt_tarjeta2").val(data[0].tarjeta);
                break;
            case 7: $("#fp_7").show(); 
                $("#DlgIngreso_txt_efectivo3").val(data[0].efectivo);
                $("#DlgIngreso_txt_yape2").val(data[0].yape);
                break;
            case 8: $("#fp_8").show(); 
                $("#DlgIngreso_txt_efectivo4").val(data[0].efectivo);
                $("#DlgIngreso_txt_transferencia2").val(data[0].transferencia);
                break;
            case 9: $("#fp_9").show(); 
                $("#DlgIngreso_txt_efectivo5").val(data[0].efectivo);
                $("#DlgIngreso_txt_credito2").val(data[0].credito);
                break;
            case 10: $("#fp_10").show(); $("#DlgIngreso_txt_cupon").val(data[0].cupon); break;            
        }

        setTimeout(function(){
            MsgDlgLoadAjaxFinish("DlgIngreso_form"); 
        }, 500);
    }).fail( function(error, jqXHR, textStatus, errorThrown ) {
        var errors = error.responseJSON;                        
            if (error.status === 500) {
                maquinge.notificaciones(errors.msg, 'Maquingenieros', 'error');  }
        MsgDlgLoadAjaxFinish("DlgIngreso_form"); 
    });

    if(type=="view"){
        $('input[type="text"], select, textarea').prop("disabled",true);
        $("#dlgIngreso_btn_guardar").prop("disabled",true);
    }else{
        $('input[type="text"], select, textarea').prop("disabled",false);
        $("#dlgIngreso_btn_guardar").prop("disabled",false);
    }
}

function guardar_Ingreso(){
    $('.error_msg').addClass('d-none').text('');

    var fp = $('#DlgIngreso_txt_id_forma_pago').val();
    
    var formDataPago = new FormData($("#DlgIngreso_form")[0]);
    formDataPago.append('_token', $('input[name=_token]').val());
    formDataPago.append('id',$("#DlgIngreso_txt_id").val());
    formDataPago.append('caja',$("#DlgIngreso_txt_caja").val());    
    formDataPago.append('razon_social',($("#DlgIngreso_txt_razon_social").val()).toUpperCase());
    formDataPago.append('descripcion',($("#DlgIngreso_txt_descripcion").val()).toUpperCase());
    formDataPago.append('id_forma_pago',$('#DlgIngreso_txt_id_forma_pago').val());
    formDataPago.append('id_ingre_cat',$('#DlgIngreso_txt_id_ingre_cat').val());
    formDataPago.append('fch_emi',$('#DlgIngreso_txt_fch_emi').val());   

    if(fp==6){
        formDataPago.append('efectivo',$('#DlgIngreso_txt_efectivo2').val());
        formDataPago.append('tarjeta',$('#DlgIngreso_txt_tarjeta2').val());
    }else if(fp==7){
        formDataPago.append('efectivo',$('#DlgIngreso_txt_efectivo3').val());
        formDataPago.append('yape',$('#DlgIngreso_txt_yape2').val()); 
    }else if(fp==8){  
        formDataPago.append('efectivo',$('#DlgIngreso_txt_efectivo4').val());
        formDataPago.append('transferencia',$('#DlgIngreso_txt_transferencia2').val());
    }else if(fp==9){
        formDataPago.append('efectivo',$('#DlgIngreso_txt_efectivo5').val());
        formDataPago.append('credito',$('#DlgIngreso_txt_credito2').val());    
    }else{
        formDataPago.append('efectivo',$('#DlgIngreso_txt_efectivo').val());
        formDataPago.append('tarjeta',$('#DlgIngreso_txt_tarjeta').val());
        formDataPago.append('yape',$('#DlgIngreso_txt_yape').val());
        formDataPago.append('transferencia',$('#DlgIngreso_txt_transferencia').val());
        formDataPago.append('credito',$('#DlgIngreso_txt_credito').val());
        formDataPago.append('cupon',$('#DlgIngreso_txt_cupon').val()); 
    }

    MsgDlgLoadAjaxForm("DlgIngreso_form");
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        url: 'insert-ingreso',
        type: 'POST',
        data: formDataPago,
        cache:false,
        contentType: false,
        processData: false,
    }).done(function (data) {  
        setTimeout(function(){    
            MsgDlgLoadAjaxFinish("DlgIngreso_form");
            closeModalIngresos();
        }, 1000);      
        $('#tableIngresos').DataTable().ajax.url("{!! route('ingresos.list') !!}").load();
        maquinge.notificaciones(data.msg, 'Sistema', 'success');        
    }).fail(function (data, jqXHR, textStatus) {
        var response = JSON.parse(data.responseText);   
        $.each( response.errors, function( key, value) {
            $('#error_DlgIngreso_txt_' + key).removeClass('d-none').text(value);
        });
        if (data.status === 500) {
            maquinge.notificaciones('Error interno comun&iacute;quese con el &aacute;rea de sistemas', 'Maquingenieros', 'error');
        } 
        initApp.playSound(asset+'smartadmin/dist/media/sound', 'voice_alert');
        MsgDlgLoadAjaxFinish("DlgIngreso_form");
    });
}

function anular_Ingreso(id){ 
    initApp.playSound(asset+'smartadmin/dist/media/sound', 'bigbox'); 
    bootbox.confirm({
        title: "<i class='fal fa-times-circle text-danger mr-2'></i> ¿ Está seguro que desea Anular el recibo ?",
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
                    url: 'ingresosctrl/'+id,
                    type: 'PUT',
                    data:{
                        '_token': $('input[name=_token]').val(),
                    }       
                }).done(function (data) {  
                    $('#tableIngresos').DataTable().ajax.url("{!! route('ingresos.list') !!}").load();
                }).fail(function (jqXHR, textStatus) {
                    maquinge.notificaciones(textStatus+" <br>* Base de Datos", 'OceanClub', 'error');
                    initApp.playSound(asset+'smartadmin/dist/media/sound', 'voice_alert');
                });
                
            }            
        }
    });
}

function eliminar_Ingreso(id){ 
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
                    url: 'ingresosctrl/'+id,
                    type: 'DELETE',
                    data:{
                        '_token': $('input[name=_token]').val(),
                    }       
                }).done(function (data) {  
                    $('#tableIngresos').DataTable().ajax.url("{!! route('ingresos.list') !!}").load();
                }).fail(function (jqXHR, textStatus) {
                    maquinge.notificaciones(textStatus+" <br>* Base de Datos", 'OceanClub', 'error');
                    initApp.playSound(asset+'smartadmin/dist/media/sound', 'voice_alert');
                });
                
            }            
        }
    });
}

function closeModalIngresos(){
    $("#DldModalIngreso").modal('hide');
    $('.error_msg').addClass('d-none').text('');
    $("#DlgIngreso_txt_id").val('');
    $("#DlgIngreso_form")[0].reset();
    $("#fp_1, #fp_2, #fp_3, #fp_4, #fp_5, #fp_6, #fp_7, #fp_8, #fp_9, #fp_10").hide();
    $("#DlgIngreso_txt_efectivo,#DlgIngreso_txt_tarjeta,#DlgIngreso_txt_yape,#DlgIngreso_txt_transferencia,#DlgIngreso_txt_credito,#DlgIngreso_txt_cupon").val('');
    $("#DlgIngreso_txt_efectivo2,#DlgIngreso_txt_tarjeta2,#DlgIngreso_txt_yape2,#DlgIngreso_txt_transferencia2,#DlgIngreso_txt_credito2").val('');
    $("#DlgIngreso_txt_efectivo3,#DlgIngreso_txt_efectivo4,#DlgIngreso_txt_efectivo5").val('');
}

function print_ticket(id_ped_temp){
    window.open('print_ticket/'+id_ped_temp,"width=400,height=500,scrollbars=NO");
}

 
</script>
@endpush