{{-- @extends('adminlte::auth.auth-page', ['auth_type' => 'login']) --}}


@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )
@php( $password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset') )

@if (config('adminlte.use_route_url', true))
    @php( $login_url = $login_url ? route($login_url) : '' )
    @php( $register_url = $register_url ? route($register_url) : '' )
    @php( $password_reset_url = $password_reset_url ? route($password_reset_url) : '' )
@else
    @php( $login_url = $login_url ? url($login_url) : '' )
    @php( $register_url = $register_url ? url($register_url) : '' )
    @php( $password_reset_url = $password_reset_url ? url($password_reset_url) : '' )
@endif

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="img/ico.png">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/mainparallax.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
</head>

<body>
    <div id="particles-js"></div>
    <div class="container">

        <img src="img/1.png" class="object i1 " data-value="-6">
        <img src="img/2.png" class="object " data-value="8">
        <img src="img/3.png" class="object " data-value="6">
        <img src="img/4.png" class="object i1" data-value="-8">
        <img src="img/5.png" class="object" data-value="10">
        <img src="img/6.png" class="object" data-value="-5">
        <img src="img/7.png" class="object i1 " data-value="6">
        <img src="img/8.png" class="object" data-value="-9">
        <img src="img/9.png" class="object" data-value="-6">
        <img src="img/10.png" class="object" data-value="-7">
        <img src="img/11.png" class="object i1" data-value="10">
        <!-- <img src="img/12.png" class="object i1" data-value="-5"> -->
        <img src="img/13.png" class="object" data-value="9">
        <img src="img/bot1.png" class="object " data-value="8">
        <img src="img/bot2.png" class="object " data-value="-6">
        <img src="img/bot3.png" class="object " data-value="6">
        <img src="img/bot4.png" class="object " data-value="-4">
        <img src="img/footer.png" class="object">
        <!-- <img src="img/img/14.png" class="object i1" data-value="8"> -->
    </div>
    <div class="container" id="container">
        <!-- sign in page -->
        <div class="form-container sign-in-container">
            <form action="{{ $login_url }}"  method="post" class="form" id="login">
                @csrf
                <img src="img/login.png" alt=""  srcset="">
                {{-- <h1 class="form__title">Login</h1> --}}
                {{-- Email field --}}
                <div class="form_input-group">
                    <label for="email">Correo sc4ri: </label>
                    <input type="email" class="input @error('email') is-invalid @enderror" name="email" id="email" required>
                </div>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                @if (session('error'))
                    <div class="invalid-feedback" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="form_input-group">
                    <label for="password">Contraseña: </label>
                    <input type="password" class="input @error('password') is-invalid @enderror" name="password" id="password" required>
                </div>

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <button class="boton" type="submit"> Ingresar </button>
            </form>
        </div>
    </div>

    {{-- @if($register_url)
        <p class="my-0">
            <a href="{{ $register_url }}">
                Registrarse
            </a>
        </p>
    @endif --}}

    <script src="js/apparallax.js"></script>
    <script src="js/main.js"></script>
    <script src="js/plugin-particles.js"></script>
    <script src="js/plugin-app.js"></script>
</body>

</html>
