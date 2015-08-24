@extends('eusalud_pdf')
@section('content')

    <table style="width: 900px; margin: 0 auto; font-size:1em">
        <tr>
            <td colspan="2"><img src="{{ public_path('img/logo_colores.png') }}" width="300"></td>
            <td colspan="2" style="text-align: center; padding: 20px">
                <h2>{{ $headerTitle }}</h2>
                <h4>NIT  800227072-8</h4>
                <h4>CARRERA 9. N0. 66-10</h4>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width:70%"><b>Contribuyente:</b> {{ $info[0]->TrcRazSoc }}</td>
            <td colspan="2" style="width:30%"><b>Nit:</b> {{ $info[0]->TrcCod }}</td>
        </tr>
        <tr>
            <td style="text-align: center; width: 25%">CONCEPTO</td>
            <td style="text-align: center; width: 25%">NOMBRE DEL CONCEPTO</td>
            <td style="text-align: center; width: 25%">VALOR RETENIDO</td>
            <td style="text-align: center; width: 25%">VALOR BASE</td>
        </tr>
        <tr>
            <td style="text-align: center; width: 25%">{{ $info[0]->CntCod }}</td>
            <td style="text-align: center; width: 25%">{{ $info[0]->CntDsc }}</td>
            <td style="text-align: center; width: 25%"><b>{{ '$' . number_format($valor_retenido) }}</b></td>
            <td style="text-align: center; width: 25%"><b>{{ '$' . number_format($valor_base) }}</b></td>
        </tr>
        <tr>
            <td colspan="4"><p><b>VALOR RETENIDO EN LETRAS:</b> {{ $valor_en_letras }}</p></td>
        </tr>
        <tr>
            <td colspan="4">
                <p>LOS CERTIFICADOS EXPEDIDOS EN FORMA CONTINUA IMPRESA EN COMPUTADOR, 
                NO NECESITAN FIRMA AUTÓGRAFA. (ART 10 D.R. 836/91)</p>
                <p>Informe generado el día {{ date('Y-m-d h:i:s A') }} para el periodo comprendido entre 
                {{ $input['fecha_inicio'] }} y {{ $input['fecha_final'] }}.</p>
            </td>
        </tr>
    </table>
  

@stop
