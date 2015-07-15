@extends('eusalud2')

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Crear nuevo Rol</div>
					<div class="panel-body">
					{!! Form::open(['class' => 'form-horizontal']) !!}
					
						<div class="form-group">
							{!! Form::label('title', 'Titulo', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::text('title', null, ['class' => 'form-control']) !!}
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('slug', 'Alias', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::text('slug', null, ['class' => 'form-control']) !!}
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

@stop