@extends('eusalud3')

@section('content')

	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-plus"></i> Crear nuevo Permiso</div>
					<div class="panel-body">
					
					@include('partials.errors')
					
					{!! Form::open(['method' => 'POST', 'url' => 'permisos/create', 'class' => 'form-horizontal']) !!}
					
							{!! csrf_field() !!}
						<div class="form-group">
							{!! Form::label('permission_title', 'Titulo', ['class' => 'col-lg-4 control-label']) !!}
							<div class="col-lg-6">
								{!! Form::text('permission_title', null, ['class' => 'form-control']) !!}
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('permission_slug', 'Alias', ['class' => 'col-lg-4 control-label']) !!}
							<div class="col-lg-6">
								{!! Form::text('permission_slug', null, ['class' => 'form-control']) !!}
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('permission_url', 'Url', ['class' => 'col-lg-4 control-label']) !!}
							<div class="col-lg-6">
								{!! Form::text('permission_url', null, ['class' => 'form-control']) !!}
							</div>
						</div>


						<div class="form-group">
							{!! Form::label('permission_description', 'Descripción', ['class' => 'col-lg-4 control-label']) !!}
							<div class="col-lg-6">
								{!! Form::textarea('permission_description', null, ['class' => 'form-control']) !!}
							</div>
						</div>
					
						<div class="form-group">
							<div class="col-lg-6 col-lg-offset-4">
								{!! Form::submit('Crear', ['class' => 'btn btn-green']) !!}
								<a class="btn btn-primary" href="{{ url('permisos') }}">Cancelar</a>
							</div>
						</div>
					
					{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>

<script src="/js/main.js"></script>
@stop