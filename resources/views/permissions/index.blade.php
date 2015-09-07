@extends('eusalud3')

@section('content')

    <div class="row">
        <h1 class="page-header"><i class="fa fa-unlock fa-4"></i> Permisos</h1>
          
    </div>
          
    <div class="row">
        <div class="col-lg-12">
            <a class="btn btn-green" href="{{ url('permisos/create') }}"><i class="fa fa-plus"></i> Crear permiso</a>
            <hr/>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                	<tr>
                		<th>Titulo</th>
                		<th>Slug</th>
                		<th>Descripción</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                	</tr>
                    @foreach( $permisos as $p )
                    <tr>
                        <td>{{ $p->permission_title }}</td>
                        <td>{{ $p->permission_slug }}</td>
                        <td>{{ $p->permission_description }}</td>
                        <td><a href="{{ url('permisos/'.$p->id.'/edit' ) }}"><i class="fa fa-pencil-square-o fa-2"></i></a></td>
                        <td><a href="{{ url('permisos/'.$p->id.'/delete' ) }}" class="delete"><i class="fa fa-trash fa-2"></i></a></td>
                    </tr>
                    @endforeach

            	</table>
            </div>     
            
        </div>
   	</div>

<script>
    $(document).ready(function(){
        $("a.delete").on('click', function(e){     
        
            e.preventDefault();
            var href = $(this).attr('href');
            swal({   
                title: "Esta seguro/a?",   
                text: "El permiso ser&aacute; eliminado de la base de datos",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Si, eliminelo!",   
                cancelButtonText: "No, cancelar por favor!",   
                closeOnConfirm: false,   
                closeOnCancel: false,
                html: true 
                }, 
                function(isConfirm){   
                    if (isConfirm) {     
                        location.replace(href);   
                    } else {     
                        swal({
                            title: "Cancelado", 
                            text: "El permiso est&aacute; a salvo <i class='fa fa-smile-o'></i>",
                            type: "error",
                            html: true 
                        });     
                    } 
                }
            );

        });
        
    });
    
</script>

@stop