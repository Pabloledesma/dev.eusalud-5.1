@extends('eusalud2')

@section('content')


<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Crear nuevo Permiso</div>
					<div class="panel-body">
					
					@include('partials.errors')
					
					{!! Form::open(['method' => 'POST', 'url' => 'permisos/create', 'class' => 'form-horizontal']) !!}
					
							{!! csrf_field() !!}
						<div class="form-group">
							{!! Form::label('permission_title', 'Titulo', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::text('permission_title', null, ['class' => 'form-control']) !!}
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('permission_slug', 'Alias', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::text('permission_slug', null, ['class' => 'form-control']) !!}
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('permission_url', 'Url', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::text('permission_url', null, ['class' => 'form-control']) !!}
							</div>
						</div>


						<div class="form-group">
							{!! Form::label('permission_description', 'Descripción', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::textarea('permission_description', null, ['class' => 'form-control']) !!}
							</div>
						</div>
					
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								{!! Form::submit('Crear', ['class' => 'btn btn-green']) !!}
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