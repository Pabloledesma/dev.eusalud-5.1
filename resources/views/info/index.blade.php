@extends('eusalud3')
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Aplicativo de Eusalud</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-file-text-o fa-3"></i> Informes
                    <div class="panel-body">    
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach( $menu_info as $key => $val )
                                    <tr>
                                        <td>{{ $key }}</td>
                                    </tr>
                                @endforeach 
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
