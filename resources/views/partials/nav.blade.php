    <div class="row">
        <div class="col-md-12">
            <nav class="navbar navbar-inverse navbar-static-top">


                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="http://www.eusalud.com">Inicio</a></li>
                        
                        @if( Auth::guest() )
                        <li><a href="{{ url('/auth/login') }}">Iniciar Sesión</a></li>

                        @else
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Informes <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                              
                                <!-- Los recursos quedan disponibles para todos los usuarios y su uso se administrará con los middlewares -->
                                <li><a href="{{ url('form_certificado_pagos_profesionales') }}">Certificado de pagos a profesionales de la salud</a></li>
                                <li><a href="{{ url('form_certificado_ica') }}">Certificado de retención industria y comercio (ICA)</a></li>
                                <li><a href="{{ url('form_pago_proveedores') }}">Informe de pago a proveedores</a></li>
                                <li><a href="{{ url('censo') }}">Censo</a></li>
                            </ul>
                        </li>

                        <li class='user-menu'>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ \Auth::user()->name }}</a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ url('usuarios') }}">Usuarios</a>             
                                    <a href="{{ url('roles') }}">Roles</a>             
                                </li>
                                <li><a href="{{ url('/auth/logout') }}">Cerrar Sesión</a></li>
                            </ul>
                        </li>    

                        @endif

                    </ul>
                </div>
            </nav>
        </div>
    </div>
