@extends('eusalud2')

@section('content')

<div class="container">
	<h1>Roles</h1>
	<hr>
		<a class="btn btn-green" href="{{ url('/roles/create') }}">Nuevo Rol</a>
    <hr/>       
	<table class="table table-triped">
		<thead>
			<tr>
				<th>Id</th>
				<th>Titulo</th>
				<th>Slug</th>
				<th>&nbsp;</th>
	            <th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		@foreach($roles as $role)

			<tr>
				<td>{{$role->id}}</td>
				<td>{{$role->role_title}}</td>
				<td>{{$role->role_slug}}</td>
				<td><a href="{{ url('roles/'.$role->id.'/edit' ) }}">Editar</a></td>
            	<td><a href="{{ url('roles/'.$role->id.'/delete' ) }}" class="delete">Eliminar</a></td>
			</tr>

		@endforeach
			
		</tbody>

	</table>
</div>
	

@stop