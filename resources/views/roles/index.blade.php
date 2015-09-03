@extends('eusalud3')

@section('content')

<div class="row">
    <h1 class="page-header"><i class="fa fa-users fa-4"></i> Roles</h1>
    
</div>
          
    <div class="row">

        <div class="col-lg-12">
            <a class="btn btn-green" href="{{ url('roles/create') }}"><i class="fa fa-plus"></i> Crear Rol</a>
            <hr/>     
            <table class="table table-striped table-bordered table-hover green">
                <tr>
                    <th>Titulo</th>
                    <th>Slug</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
                @foreach( $roles as $r )
                <tr>
                    <td>{{ $r->role_title }}</td>
                    <td>{{ $r->role_slug }}</td>
                    <td><a href="{{ url('roles/'.$r->id.'/edit' ) }}"><i class="fa fa-pencil-square-o fa-2"></i></a></td>
                    <td><a href="{{ url('roles/'.$r->id.'/delete' ) }}" class="delete"><i class="fa fa-trash fa-2"></i></a></td>
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