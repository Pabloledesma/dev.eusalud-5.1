@extends('eusalud2')

@section('content')

<div class="container container-fluid">
    <h1>Roles</h1>
    <hr/>
        <a class="btn btn-green" href="{{ url('roles/create') }}">Crear Rol</a>
    <hr/>            
    <div class="row">
        <table class="table-striped green usuarios">
        	<tr>
        		<th>Titulo</th>
        		<th>Slug</th>
        		<th>Descripción</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
        	</tr>
            @foreach( $roles as $r )
            <tr>
                <td>{{ $r->role_title }}</td>
                <td>{{ $r->role_slug }}</td>
                <td>{{ $r->role_description }}</td>
                <td><a href="{{ url('roles/'.$r->id.'/edit' ) }}">Editar</a></td>
                <td><a href="{{ url('roles/'.$r->id.'/delete' ) }}" class="delete">Eliminar</a></td>
            </tr>
            @endforeach

    	</table>
   	</div>
</div>
<script>
    $().ready(function(){
        $("a.delete").on('click', function(e){     
        
            e.preventDefault();
            var c = confirm("Esta seguro de que quiere eliminar el rol?");
            if( c ){
                location.replace($(this).attr('href'));
            }
        });
    });
    
</script>

@stop