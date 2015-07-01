@extends('eusalud2')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading"><h1>Resolución 4505</h1></div>
					<div class="panel-body">
					{!! Form::open(['method'=>'post', 'action'=>'InfoController@post4505', 'files'=>true]) !!}

						<div class="form-group">
							{!! Form::label('file', 'Archivo') !!}
							{!! Form::file('file') !!}
						</div>

						<div class="form-group">
							{!! Form::submit('Submit', ['class' => 'btn btn-primary form-control']) !!}
						</div>

					{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@stop