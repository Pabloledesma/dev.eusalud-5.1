@extends('eusalud2')

@section('content')

<div class="container container-fluid">
    <h1>Permisos</h1>
    <hr/>
        <a class="btn btn-green" href="{{ url('permisos/create') }}">Crear permiso</a>
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
            @foreach( $permisos as $p )
            <tr>
                <td>{{ $p->permission_title }}</td>
                <td>{{ $p->permission_slug }}</td>
                <td>{{ $p->permission_description }}</td>
                <td><a href="{{ url('permisos/'.$p->id.'/edit' ) }}">Editar</a></td>
                <td><a href="{{ url('permisos/'.$p->id.'/delete' ) }}" class="delete">Eliminar</a></td>
            </tr>
            @endforeach

    	</table>
   	</div>
</div>
<script>
    $().ready(function(){
        $("a.delete").on('click', function(e){     
        
            e.preventDefault();
            var c = confirm("Esta seguro de que quiere eliminar el permiso?");
            if( c ){
                location.replace($(this).attr('href'));
            }
        });
    });
    
</script>

@stop