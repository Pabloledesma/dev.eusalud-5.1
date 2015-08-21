@extends('eusalud_pdf')
@section('content')
    
    <table>
        <tr>
            <td><img src="{{ public_path() }}/img/logo_colores.png" width="250" /></td>
            <td><h1 style="text-align: center">{{ $headerTitle }}</h1></td>
        </tr>
    </table>
    <br>
    <table class="principal">
        <tr>
            <th>Tercero</th>
            <th>Nombre del Tercero</th>
            <th>Documento Contable</th>
        </tr>
        <tr>
            <td>{{ $info[0]->TrcCod }}</td>
            <td>{{ $info[0]->TrcRazSoc }}</td>
            <td>{{ $info[0]->MvCNro }}</td>
        </tr>

    </table>
    <br><br>
    <table>
        <thead>
            <tr>        
                <th style="width:10%">Fecha</th>
                <th style="width:8%">Naturaleza</th>
                <th style="width:8%">Tipo de Cuenta</th>
                <th style="width:10%">Cuenta</th>
                <th style="width:10%">Nombre de cuenta</th>
                <th style="width:8%">Valor</th>
                <th style="width:30%">Detalle</th>
                <th style="width:6%">Base</th>
                <th style="width:10%">Impuesto</th>
            </tr> 
        </thead>
        <tbody class="contenido">
            @foreach($info as $row)
            <tr>            
                <td>{{ substr( $row->MvCFch, 0, 10) }}</td>
                <td>{{ $row->MvCNat }}</td>
                <td>{{ $row->CntInt }}</td>
                <td>{{ $row->CntCod }}</td>
                <td>{{ $row->CntDsc }}</td>
                <td>{{ '$' . number_format( $row->MvCVlr ) }}</td>
                <td>{{ $row->MvCDet }}</td>
                <td>{{ '$' . number_format( $row->MvCBse ) }}</td>
                <td>{{ $row->MvCImpCod }}</td>
            </tr>
            @endforeach
        </tbody>

    </table>

    <div class="footer">
        <p>Informe generado el día {{ date('Y-m-d h:i:s A') }} para el periodo comprendido entre {{ $input['fecha_inicio'] }} y {{ $input['fecha_final'] }}.</p>
    </div>

@stop
