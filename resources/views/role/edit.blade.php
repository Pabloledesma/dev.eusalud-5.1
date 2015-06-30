@extends('eusalud2')
@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading"><h1>Edición del Rol {{ $role->role_title }}</h1></div>
					<div class="panel-body">

						@include('partials.error')

						{!! Form::model($role, ['method' => 'PATCH', 'action' => ['RoleController@update', $role->id]]) !!}
						
							<div class="form-group">
								{!! Form::label('title', 'Titulo') !!}
								{!! Form::text('role_title', null, ['class' => 'form-control']) !!}
							</div>

							<div class="form-group">
								{!! Form::label('slug', 'Alias') !!}
								{!! Form::text('role_slug', null, ['class' => 'form-control']) !!}
							</div>
							
							@foreach($all_permissions as $perm)

								<div class="checkbox">
					    			<label>
					    				{{ $perm->permission_slug }}
					    				<input type="checkbox" value="{{ $perm->id }}" 
					    						name="{{ $perm->permission_slug }}" 
					    						{{ array_search( $perm->permission_slug, $perm_role ) ? 'checked' : '' }}>
					    			</label>
					    		</div>

							@endforeach

							<div class="form-group">
								{!! Form::submit('Editar', ['class' => 'btn btn-green']) !!}
							</div>
							
						{!! Form::close() !!}

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@stop
