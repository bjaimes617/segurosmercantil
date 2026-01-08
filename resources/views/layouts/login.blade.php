<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="{{ asset('img/icon.png') }}">
        <meta name="author" content="Deivis Henriquez deivis(at)vozip.net and Braian Jaimes braian.jaimes(at)directagroup.net"/>
        <meta name="copyright" content="Powered by Deivis Henriquez and Braian Jaimes. <?php echo date('Y'); ?>">
        <title>{{env('APP_NAME')}} Platform | @yield('title')</title>
        {!!Html::style('plugins/icheck-bootstrap/icheck-bootstrap.min.css')!!}          
        {!!Html::style('plugins/jqvmap/jqvmap.min.css')!!}
        {!!Html::style('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')!!}  
        {!!Html::style('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')!!} 
        {!!Html::style('plugins/toastr/toastr.min.css')!!}          
        {!!Html::style('css/adminlte.css')!!}   
        {!!Html::style('plugins/fontawesome-free/css/all.css')!!}  
    </head>
    <body class="hold-transition login">
            <div class="login-page">  
            @yield('content')
            </div>            
        <footer class="main-footer float-right" style="background: transparent; border-top-color: transparent; float: center">
            <small>&copy; {{date('Y',strtotime(now()))}} <a href="http://directagroup.net" target="_blank">Directa Group</a>. | Inifity is Powered by Gerencia Ingeniería de Software. Para Soporte Escribanos a <a href="mailto:innovacion@directagroup.net?subject=Soporte Unity DG%20">Innovacion@directagroup.net</a></small>
        </footer>
    </body>
   
    {!! Html::script('plugins/jquery/jquery.min.js') !!}
    {!! Html::script('plugins/jquery-ui/jquery-ui.min.js') !!}  
    {!! Html::script('plugins/bootstrap/js/bootstrap.js') !!}
    {!! Html::script('plugins/bootstrap/js/bootstrap.bundle.min.js') !!}
    {!! Html::script('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') !!}
    {!! Html::script('plugins/jqvmap/jquery.vmap.min.js') !!}
    {!! Html::script('plugins/jquery-validation/jquery.validate.js') !!}
    {!! Html::script('plugins/jquery-validation/localization/messages_es.js') !!}
    {!! Html::script('js/adminlte.js') !!}
    @include('notifications.index')
    @stack('scripts')
</html>