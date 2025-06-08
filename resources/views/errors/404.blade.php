@extends('layouts.app')
@section('titulo') Error 404 @endsection


@section('contenido')
<div class="h-alt-hf d-flex flex-column align-items-center justify-content-center text-center">
    <h1 class="page-error color-fusion-500">
        ERROR <span class="text-gradient">404</span>
        <small class="fw-500">
            ¡Algo <u>sali&oacute;</u> mal!
        </small>
    </h1>
    <h3 class="fw-500 mb-5">
        Ha experimentado un error t&eacute;cnico. Pedimos disculpas.
    </h3>
    <h4>
        Trabajamos arduamente para corregir este problema. Espere unos momentos y vuelva a intentar.
        <br>Mientras tanto, <a href="/dashboard">puede hacer click aqu&iacute; para regresar al incio</a>.
    </h4>
</div>

@endsection
