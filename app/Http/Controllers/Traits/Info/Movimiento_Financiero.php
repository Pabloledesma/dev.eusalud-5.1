<?php namespace App\Http\Controllers\Traits\Info;

use App\Http\Requests\Certificado_de_pagos;
use DB;

trait Movimiento_Financiero {

	public function movimiento_financiero_all( Certificado_de_pagos $request )
	{
		$input = $request->all();

		$query = "SELECT count(*) FROM ((dbo.MOVCONT3 INNER JOIN dbo.MOVCONT2 ON "
			."(dbo.MOVCONT3.MCDpto = dbo.MOVCONT2.MCDpto) AND (dbo.MOVCONT3.MvCNro = dbo.MOVCONT2.MvCNro) AND "
			."(dbo.MOVCONT3.DOCCOD = dbo.MOVCONT2.DOCCOD) AND (dbo.MOVCONT3.EMPCOD = dbo.MOVCONT2.EMPCOD)) "
			."LEFT JOIN dbo.CUENTAS ON (dbo.MOVCONT2.CntCod = dbo.CUENTAS.CntCod) AND "
			."(dbo.MOVCONT2.CntVig = dbo.CUENTAS.CntVig)) LEFT JOIN dbo.TERCEROS ON "
			."dbo.MOVCONT2.TrcCod = dbo.TERCEROS.TrcCod WHERE (((dbo.MOVCONT3.EMPCOD)='01') AND "
			."((dbo.MOVCONT3.MvCFch) Between convert(datetime, :fecha_inicio , 101) And "
	        ."convert(datetime, :fecha_final , 101)) AND ((dbo.MOVCONT3.MvCEst)<>'N'))";

		$binds = array( 'fecha_inicio' => $input['fecha_inicio'], 'fecha_final' => $input['fecha_final'] );

		$all = DB::connection('sqlsrv_info')->selectOne( $query, $binds );
	}
}
