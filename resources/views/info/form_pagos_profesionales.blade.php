@extends('eusalud3')
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Certificado de pagos a profesionales de la salud</h1>
        </div>
        <hr/>
    </div>
    <div class="row">
        <div class="col-lg-12">
        <form class="form-horizontal" 
        	role="form" 
        	method="post" 
        	id="form_cert_pag" 
        	action="{{ url('certificado_pagos_profesionales') }}"
        >
        	{!! csrf_field() !!}
        @include('partials.form_pagos_profesionales')    
@stop
