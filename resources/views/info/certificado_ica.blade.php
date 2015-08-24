@extends('eusalud2')
@section('content')

<div class="container container-fluid">
    <h1>Certificado de Retención, Industria y Comercio (ICA)</h1>
    <hr/>
    <div class="row">
        <form class="form-horizontal" role="form" method="post" id="form_cert_pag" action="{{ url('certificado_ica') }}">
        	{!! csrf_field() !!}
        @include('partials.form_pagos_profesionales')    
@stop
