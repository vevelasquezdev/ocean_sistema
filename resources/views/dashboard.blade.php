@extends('layouts.app')
@section('titulo') {{ __('Dashboard') }} @endsection



@section('contenido')

<div class="row">
    <div class="col-md-12 col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <span class="fw-300"><i>PANEL</i></span>&nbsp;&nbsp;DE BIENVENIDA
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10"
                        data-original-title="Collapse"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                        data-offset="0,10" data-original-title="Fullscreen"></button>                   
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="row">
                        <div class="col-sm-6 col-xl-3">
                            <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
                                <div class="">
                                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                        20
                                        <small class="m-0 l-h-n">Usuarios registrados</small>
                                    </h3>
                                </div>
                                <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-3">
                            <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white mb-g">
                                <div class="">
                                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                        +40
                                        <small class="m-0 l-h-n">Clientes</small>
                                    </h3>
                                </div>
                                <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        
                        @if((Auth::user())->rol=='ADMINISTRADOR')
                            <div class="col-sm-6 col-xl-3">
                                <a href="{!! route('vwmesas') !!}" class="btn btn-outline-primary">
                                    <img class="img-fluid" src="{{ asset('images/icon_mesas.png') }}"alt="Card image cap" style="width: 55%">
                                </a>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <a href="{!! route('cocina.index') !!}" class="btn btn-outline-primary">
                                    <img class="img-fluid" src="{{ asset('images/cocina.png') }}"alt="Card image cap" style="width: 50%">
                                </a>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <a href="{!! route('barra.index') !!}" class="btn btn-outline-primary">
                                    <img class="img-fluid" src="{{ asset('images/barra.png') }}"alt="Card image cap" style="width: 33%">
                                </a>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <a href="{!! route('apecierrecaja.index') !!}" class="btn btn-outline-primary">
                                    <img class="img-fluid" src="{{ asset('images/caja2.png') }}"alt="Card image cap" style="width: 93%">
                                </a>
                            </div>
                        @elseif((Auth::user())->rol=='MOZO')
                            <div class="col-sm-6 col-xl-3">
                                <a href="{!! route('vwmesas') !!}" class="btn btn-outline-primary">
                                    <img class="img-fluid" src="{{ asset('images/icon_mesas.png') }}"alt="Card image cap" style="width: 55%">
                                </a>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <a href="{!! route('cocina.index') !!}" class="btn btn-outline-primary">
                                    <img class="img-fluid" src="{{ asset('images/cocina.png') }}"alt="Card image cap" style="width: 50%">
                                </a>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <a href="{!! route('barra.index') !!}" class="btn btn-outline-primary">
                                    <img class="img-fluid" src="{{ asset('images/barra.png') }}"alt="Card image cap" style="width: 33%">
                                </a>
                            </div>
                        @elseif((Auth::user())->rol=='CAJA')
                            <div class="col-sm-6 col-xl-3">
                                <a href="{!! route('vwmesas') !!}" class="btn btn-outline-primary">
                                    <img class="img-fluid" src="{{ asset('images/icon_mesas.png') }}"alt="Card image cap" style="width: 55%">
                                </a>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <a href="{!! route('cocina.index') !!}" class="btn btn-outline-primary">
                                    <img class="img-fluid" src="{{ asset('images/cocina.png') }}"alt="Card image cap" style="width: 50%">
                                </a>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <a href="{!! route('barra.index') !!}" class="btn btn-outline-primary">
                                    <img class="img-fluid" src="{{ asset('images/barra.png') }}"alt="Card image cap" style="width: 33%">
                                </a>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <a href="{!! route('apecierrecaja.index') !!}" class="btn btn-outline-primary">
                                    <img class="img-fluid" src="{{ asset('images/caja2.png') }}"alt="Card image cap" style="width: 93%">
                                </a>
                            </div>
                        @elseif((Auth::user())->rol=='BAR')
                            <div class="col-sm-6 col-xl-3">
                                <a href="{!! route('cocina.index') !!}" class="btn btn-outline-primary">
                                    <img class="img-fluid" src="{{ asset('images/cocina.png') }}"alt="Card image cap" style="width: 50%">
                                </a>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <a href="{!! route('barra.index') !!}" class="btn btn-outline-primary">
                                    <img class="img-fluid" src="{{ asset('images/barra.png') }}"alt="Card image cap" style="width: 33%">
                                </a>
                            </div>
                        @elseif((Auth::user())->rol=='COCINA')
                            <div class="col-sm-6 col-xl-3">
                                <a href="{!! route('cocina.index') !!}" class="btn btn-outline-primary">
                                    <img class="img-fluid" src="{{ asset('images/cocina.png') }}"alt="Card image cap" style="width: 50%">
                                </a>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <a href="{!! route('barra.index') !!}" class="btn btn-outline-primary">
                                    <img class="img-fluid" src="{{ asset('images/barra.png') }}"alt="Card image cap" style="width: 33%">
                                </a>
                            </div>
                        @elseif((Auth::user())->rol=='ALMACEN')
                            
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection