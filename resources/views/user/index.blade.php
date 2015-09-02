@extends('eusalud3')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Usuarios</h1>
        </div>
        <hr/>

        <a class="btn btn-green" href="{{ url('registrar') }}">Nuevo usuario</a>
    </div>
    <hr/>            
    <div class="row">
        <div class="col-lg-12">
        <table class="table table-striped table-bordered table-hover">
            <tr>               
                <th>Nombre</th>
                <th>Correo</th>
                <th>Cedula</th>
                <th>Rol</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        
        @foreach( $usuarios as $u )
        <tr>
            <td>{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td>{{ $u->num_id }}</td>
            <td>{{ $u->role ? $u->role->role_title : '' }}</td>
            <td><a href="{{ url('usuarios/'.$u->id.'/edit' ) }}"><i class="fa fa-pencil-square-o fa-2"></i></a></td>
            <td><a href="{{ url('usuarios/'.$u->id.'/delete' ) }}" class="delete"><i class="fa fa-trash fa-2"></i></a></td>
        </tr>
        @endforeach
        </table>
        </div>
    </div>
</div>
<script>
    $().ready(function(){
        $("a.delete").on('click', function(e){     
        
            e.preventDefault();
            var c = confirm("Esta seguro de que quiere eliminar el usuario?");
            if( c ){
                location.replace($(this).attr('href'));
            }
        });
    });
    
</script>
@stop

