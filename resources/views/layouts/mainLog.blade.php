<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="{{ asset('img/icon.png') }}">
        <meta name="author" content="Deivis Henriquez deivis(at)vozip.net and Braian Jaimes braian.jaimes(at)directagroup.net"/>
        <meta name="copyright" content="Powered by Deivis Henriquez and Braian Jaimes. <?php echo date('Y'); ?>">
        <!-- CSRF Token -->
        <meta name="csrf-token" id="_token" content="{{ csrf_token() }}">
        <title> {{env('APP_NAME')}} - Platform | Log del Sistema</title>
        {!!Html::style('css/adminlte.css')!!} 
        @stack('styles')    
    </head>
    <body class="hold-transition">
        <div class="content">

            <!-- Preloader -->      
            <div class="preloader flex-column justify-content-center align-items-center">
                <img class="animation__shake" src="{{asset('img/logo directa.png')}}" alt="DirectaGroupLogo" height="50" width="100">
            </div>
           <nav class="navbar navbar-expand-md navbar-light navbar-white">@include('partials.headers')</nav>      
            <section class="content">               
            @yield('content')                
            </section>   
            @include('partials.footer')
        </div>
    </body>
    {!! Html::script('js/adminlte.js') !!}
@stack('scripts')
</html>
