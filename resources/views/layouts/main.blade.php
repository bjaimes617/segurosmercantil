<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="{{ asset('img/icon.png') }}">
        <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
        <meta name="author" content="Deivis Henriquez deivis(at)vozip.net and Braian Jaimes braian.jaimes(at)directagroup.net"/>
        <meta name="copyright" content="Powered by Deivis Henriquez and Braian Jaimes. <?php echo date('Y'); ?>">
        <!-- CSRF Token -->
        <meta name="csrf-token" id="_token" content="{{ csrf_token() }}">
        <title>{{env('APP_NAME')}} - Platform | @yield('title')</title>
        <!-- CCS -->
        {!!Html::style('plugins/fontawesome-free/css/all.min.css')!!}                 
        {!!Html::style('plugins/jquery-ui/jquery-ui.min.css') !!}
        {!!Html::style('plugins/bootstrap/css/bootstrap.css')!!}  
        {!!Html::style('plugins/jqvmap/jqvmap.min.css')!!}          
        {!!Html::style('plugins/icheck-bootstrap/icheck-bootstrap.min.css')!!}          
        {!!Html::style('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')!!}  
        {!!Html::style('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')!!}       
        {!!Html::style('plugins/toastr/toastr.min.css')!!}
        @stack('styles')
        {!!Html::style('css/adminlte.css')!!}         
    </head>
    <body class="hold-transition sidebar-mini text-sm">
        <div class="wrapper">            
            <!-- Preloader -->
            <div class="preloader flex-column justify-content-center align-items-center">
                <img class="animation__shake" src="{{asset('img/logo directa.png')}}" alt="DirectaGroupLogo" height="50" width="90">
            </div>

            <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">@include('partials.headers')</nav>
            <!-- /.navbar -->
            <aside class="main-sidebar sidebar-dark-primary elevation-3">
                <!-- Brand Logo -->
                <a href="{{route('home')}}" class="brand-link">
                    <img src="{{asset('img/LOGO DG DIAPO.png')}}" alt="DirectaGroupLogo Logo"  height="55" width="210" style="opacity: .8">                    
                </a>
                <!-- Sidebar -->
                <div class="sidebar"> @include('partials.menu') </div>
            </aside>  
            @yield('content') 
           <!-- el contect tiene la finalizacion del content wrapper -->
            @include('partials.footer')
        </div>
    </body>        
    <!-- Scripts -->
    {!! Html::script('plugins/jquery/jquery.min.js') !!}    
    {!! Html::script('plugins/jquery-ui/jquery-ui.min.js') !!}
    {!! Html::script('plugins/bootstrap/js/bootstrap.js') !!}
    {!! Html::script('plugins/bootstrap/js/bootstrap.bundle.min.js') !!}      
    {!! Html::script('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') !!}    
    {!! Html::script('plugins/jquery-validation/jquery.validate.js') !!}
    {!! Html::script('plugins/jquery-validation/localization/messages_es.js') !!}    
    {!! Html::script('js/adminlte.js') !!}   
    @include('notifications.index')      
    @stack('scripts')    
    
    
</html>