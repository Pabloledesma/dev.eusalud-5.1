@extends('eusalud3')
@section('content')

	<div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Informe de pago a proveedores</h1>
        </div>
        <hr/>
    </div>

    <div class="row">
    	<div class="col-lg-12">
        <form class="form-horizontal" role="form" method="post" id="form_cert_pag" action="{{ url('pago_proveedores') }}">
        	{!! csrf_field() !!}
        @include('partials.form_profesionales_proveedores_admin')    
@stop

