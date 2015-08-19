@extends('eusalud2')
@section('content')

	{{ $user }}
    
    @include('partials.carrousel')
   
    @include('partials.nuestras_clinicas')
    
    @include('partials.clientes')

@stop