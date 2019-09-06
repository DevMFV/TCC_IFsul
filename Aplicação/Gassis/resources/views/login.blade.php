<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Login | Gassis</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="{{asset('/css/login.css')}}">

    </head>
    <body>
        <div class="box">

        {!! Form::open(['class'=>'form','route' => 'auth', 'method' => 'post']) !!}

            <label class="box-legend">Login</label>
            <div class="datas">

                {!!Form::text('userlogin', null, ['class'=>'data-item','type'=>'email','placeholder'=>'Digite seu Login','required'=>'required']) !!}
                {!!Form::password('userpassword',['class'=>'data-item','placeholder'=>'Digite sua Senha','required'=>'required']) !!}

            </div>

            {!!Form::submit('Entrar',['class'=>'form-submit']) !!}

        {!! Form::close() !!}
            
            <!--
            <form class="form" action="" method="post">
                <label class="box-legend">Logar Solicitante</label>
                <div class="datas">
                    <input class="data-item" type="email" placeholder="Digite seu Login">
                    <input class="data-item" type="password" placeholder="Digite sua Senha">
                </div>
                <input class="form-submit" type="submit" value="Entrar">
            </form>]
        -->

        </div>
    </body>
</html>
