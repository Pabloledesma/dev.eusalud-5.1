@extends('login_eusalud')

@section('content')
 <div class="container">

        <div class="card card-container">
            <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
            <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
            <p id="profile-name" class="profile-name-card"></p>
            <form id="login_form" class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
                        {!! csrf_field() !!}
                <span id="reauth-email" class="reauth-email"></span>
                <input type="email" id="email" name="email" class="form-control" placeholder="Email" required autofocus>
                <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" required>
                <div id="remember" class="checkbox">
                    <label>
                        <input type="checkbox" name="remember" value="remember-me"> Recordar
                    </label>
                </div>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Iniciar Sesión</button>
            </form><!-- /form -->
            <a href="{{ url('/password/email') }}" class="forgot-password">
                Olvidó su clave?
            </a>
        </div><!-- /card-container -->
        <div class="logo">
            <img src="/img/logo_colores.png">
        </div>
    </div><!-- /container -->

@endsection
