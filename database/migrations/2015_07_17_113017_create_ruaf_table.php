<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRuafTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ruaf', function (Blueprint $table) {
            $table->primary('id');
            $table->integer('numero_certificado');
            $table->string('departamento');
            $table->string('municipio');
            $table->string('area_nacimiento');
            $table->string('inspeccion_corregimiento_o_caserio_nacimiento')->nullable();
            $table->string('sitio_nacimiento');
            $table->string('codigo_institucion');
            $table->string('nombre_institucion');
            $table->string('sexo');
            $table->integer('peso_gramos');
            $table->integer('talla_centimetros');
            $table->date('fecha_nacimiento');
            $table->time('hora_nacimiento');
            $table->string('parto_atendido_por');
            $table->integer('tiempo_de_gestacion');
            $table->integer('numero_consultas_prenatales');
            $table->string('tipo_parto');
            $table->string('multiplicidad_embarazo');
            $table->integer('apgar1');
            $table->integer('apgar2');
            $table->string('grupo_sanguineo');
            $table->string('factor_rh');
            $table->string('pertenencia_etnica');
            $table->string('grupo_indigena')->nullable();
            $table->string('nombres_madre');
            $table->string('apellidos_madre');
            $table->string('apellidos_madre');
            $table->string('tipo_documento_madre');
            $table->string('numero_documento_madre');
            $table->string('edad_madre');
            $table->string('estado_conyugal_madre');
            $table->string('nive_educativo_madre');
            $table->integer('ultimo_año_aprovado_madre');
            $table->string('pais_residencia');
            $table->string('departamento_residencia');
            $table->string('municipio_residencia');
            $table->string('area_residencia');
            $table->string('localidad');
            $table->string('barrio');
            $table->string('direccion');
            $table->string('centro_poblado')->nullable();
            $table->string('rural_disperso')->nullable();
            $table->integer('numero_hijos_nacidos_vivos');
            $table->date('fecha_anterior_hijo_nacido_vivo')->nullable();
            $table->integer('numero_embarazos');
            $table->string('regimen_seguridad');
            $table->string('tipo_administradora');
            $table->string('nombre_administradora');
            $table->string('edad_padre');
            $table->string('nivel_educativo_padre');
            $table->string('ultimo_ano_aprovado_padre');
            $table->string('nombres_y_apellidos_certificador');
            $table->string('numero_documento_certificador');
            $table->string('departamento_expedicion');
            $table->string('municipio_expedicion');
            $table->date('fecha_expedicion');
            $table->string('estado_certificado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ruaf');
    }
}
