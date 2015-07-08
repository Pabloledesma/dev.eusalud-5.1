@extends('eusalud2')

@section('content')

<div class="containter">
	
	<div class="row">

		<div class="col-md-8 col-md-offset-2">
		@if( count($filesToPrint) > 0 )
			<h1>Archivos para imprimir</h1>
			<ul>
				
			@foreach($filesToPrint as $nombre)

				<li class="toPrint">{{$nombre}}</li>

			@endforeach
			</ul>
		@endif

		@if( isset($mensaje) )
			<h2>{{ $mensaje }}</h2>
		@endif
		</div>
	</div>
</div>
<script src="/js/ejecucion_continua.js"></script>
@stop