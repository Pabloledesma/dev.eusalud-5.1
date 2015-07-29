@if (count($errors) > 0)
	<div class="alert alert-danger">
		<strong>UPS! </strong> Hay problemas con los datos ingresados por favor verifique.<br><br>
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif