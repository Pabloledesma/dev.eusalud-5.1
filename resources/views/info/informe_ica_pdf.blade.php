@extends('eusalud_pdf')
@section('content')
<style>
    #head {
        line-height: 1;
    }
    
    #tr_top {border-bottom: 1px solid black}
    
    .total { font-weight: bold; font-size: 1.2em }
    th { padding: 10px }
</style>
    <div class="container">
        <div class="row">
            <div class="col-md-12"><h2>{{ $headerTitle }}<h2></div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <img src="{{ asset('img/logo_colores.png') }}" width="300">
            </div>
            <div class="col-md-4">
                NIT  800227072-8 <br>
                CARRERA 9. N0. 66-10
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <p>CONTRIBUYENTE: {{ $info[0]->TrcRazSoc }}</p>
            </div>
            <div class="col-md-4">
                <p>NIT: {{ $info[0]->TrcCod }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">CONCEPTO</div>
            <div class="col-md-3">NOMBRE CONCEPTO</div>
            <div class="col-md-3">VALOR RETENIDO</div>
            <div class="col-md-3">VALOR BASE</div>
        </div>            
        <div class="row">
            <div class="col-md-3">{{ $info[0]->CntCod }}</div>
            <div class="col-md-3">{{ $info[0]->CntDsc }}</div>
            <div class="col-md-3"></div>
            <div class="col-md-3"></div>
        </div>       
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-3"><p style="text-align:right; font-weight: bold">TOTALES</p></div>
            <div class="col-md-3 total">{{ '$' . number_format($valor_retenido) }}</div>
            <div class="col-md-3 total">{{ '$' . number_format($valor_base) }}</div>
        </div>
     
        <div class="row">
            <div class="col-md-12">
                <h4>VALOR RETENIDO EN LETRAS</h4>
                <p>{{ $valor_en_letras }}</p>
                <br>
                <h4>CIUDAD DONDE SE CONSIGNO LA RETENCIÓN: Bogotá D.C</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <hr>
                <p>LOS CERTIFICADOS EXPEDIDOS EN FORMA CONTINUA IMPRESA EN COMPUTADOR, 
                NO NECESITAN FIRMA AUTÓGRAFA. (ART 10 D.R. 836/91)</p>
                <p>Informe generado el día {{ date('Y-m-d h:i:s A') }} para el periodo comprendido entre 
                {{ $input['fecha_inicio'] }} y {{ $input['fecha_final'] }}.</p>
            </div>
        </div>
    </div>

<script>
    $().ready(function(){
        alert("Para imprimir presione Ctrl + p");
    });
</script>
    
    

@stop
