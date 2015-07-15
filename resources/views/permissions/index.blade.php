@extends('eusalud2')

@section('content')

<div class="container container-fluid">
    <h1>Usuarios</h1>
    <hr/>
        <a class="btn btn-green" href="{{ url('permisos/crear') }}">Crear permiso</a>
    <hr/>            
    <div class="row">
        <table class="table-striped green usuarios">
        	<tr>
        		<th>Titulo</th>
        		<th>Slug</th>
        		<th>Descripción</th>
        		<th></th>
        	</tr>

    	</table>
   	</div>
</div>

@stop