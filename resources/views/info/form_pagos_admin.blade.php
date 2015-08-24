@extends('eusalud2')
@section('content')

<div class="container container-fluid">
    <h1>Certificado de pagos a profesionales de la salud</h1>
    <hr/>
    <div class="row">
        <form 
        	class="form-horizontal" 
        	role="form" 
        	method="post" 
        	id="form_cert_pag" 
        	action="{{ url('certificado_pagos_profesionales') }}"
        >
        	{!! csrf_field() !!}
        @include('partials.form_profesionales_proveedores_admin')    
@stop
