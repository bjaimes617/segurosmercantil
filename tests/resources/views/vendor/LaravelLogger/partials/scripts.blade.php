 @if(config('LaravelLogger.enablejQueryCDN'))
    <script type="text/javascript" src="{{ config('LaravelLogger.JQueryCDN') }}"></script>
    @endif
@if(config('LaravelLogger.enableBootstrapJsCDN'))
    <script type="text/javascript" src="{{ config('LaravelLogger.bootstrapJsCDN') }}"></script>
@endif  
{!! Html::script('plugins/bootstrap/js/bootstrap.bundle.min.js') !!}  
@if(config('LaravelLogger.enablePopperJsCDN'))
    <script type="text/javascript" src="{{ config('LaravelLogger.popperJsCDN') }}"></script>
@endif
{!! Html::script('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') !!}
{!! Html::script('plugins/jqvmap/jquery.vmap.min.js') !!} 

@if(config('LaravelLogger.loggerDatatables'))
    @include('LaravelLogger::scripts.datatables')    
@endif

@include('LaravelLogger::scripts.add-title-attribute')