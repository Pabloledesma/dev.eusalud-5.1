@extends('eusalud3')
@section('content')

<div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Certificado de Retención, Industria y Comercio (ICA)</h1>
        </div>
        <hr/>
    </div>
    <div class="row">
        <div class="col-lg-12">

        <form class="form-horizontal" role="form" method="post" id="form_cert_pag" action="{{ url('certificado_ica') }}">
        	{!! csrf_field() !!}
        @include('partials.form_pagos_profesionales')    
@stop
