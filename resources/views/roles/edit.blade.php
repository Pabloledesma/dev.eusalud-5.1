@extends('eusalud2')

@section('content')


<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Editar Rol</div>
					<div class="panel-body">
					
						@include('partials.errors')
					
						{!! Form::model($role, ['method' => 'POST', 'url' => 'roles/' . $role->id . '/update', 'class' => 'form-horizontal']) !!}
						
								{!! csrf_field() !!}

							<div class="form-group">
								{!! Form::label('role_title', 'Titulo', ['class' => 'col-md-4 control-label']) !!}
								<div class="col-md-6">
									{!! Form::text('role_title', null, ['class' => 'form-control']) !!}
								</div>
							</div>

							<div class="form-group">
								{!! Form::label('role_slug', 'Alias', ['class' => 'col-md-4 control-label']) !!}
								<div class="col-md-6">
									{!! Form::text('role_slug', null, ['class' => 'form-control']) !!}
								</div>
							</div>

							<div class="form-group">
								{!! Form::label(null, 'Permisos', ['class' => 'col-md-4 control-label']) !!}
								<div class="col-md-6">
									@foreach($all_permissions as $perm)

									<input type="checkbox" 
										name="{{$perm['permission_slug']}}" 
										value="{{$perm['id']}}" 
										{{ array_key_exists($perm['permission_slug'], $role_perms) ? 'checked' : '' }}>

									{{ $perm['permission_title'] }}<br>

									@endforeach
								</div>
							</div>
						
							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									{!! Form::submit('Editar', ['class' => 'btn btn-green']) !!}
								</div>
							</div>
						
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="/js/main.js"></script>
@stop