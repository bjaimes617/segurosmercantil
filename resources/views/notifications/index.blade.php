{!! Html::script('plugins/sweetalert2/sweetalert2.min.js') !!}      
{!! Html::script('plugins/toastr/toastr.min.js') !!} 
<script>
function main() {
    return Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 10000
    });
};

function mainconfirms() {
    return Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: true,
      confirmButtonText: "OK",
      //timer: 10000
    });
};
</script>

@if(Session('success'))
<script>   
    var Toastr = main();  
    $(function () {
        Toastr.fire({
            icon: 'success',
            title: "&nbsp;{{ Session::get('success')}}",
        }); 
    });
</script>
@endif
@if(Session('error'))
<script>
    var Toastr = main();    
        Toastr.fire({
        icon: 'error',
        title: "&nbsp; {{Session::get('error')}}",
      });
</script>
@endif
@if(Session('info'))
<script>
    var Toastr = main();    
        Toastr.fire({
        icon: 'info',
        title: "&nbsp; {{Session::get('info')}}",
      });
</script>
@endif
@if(Session('warning'))
<script>
    var Toastr = main();    
        Toastr.fire({
        icon: 'warning',
        title: "&nbsp; {{Session::get('warning')}}",
      });
</script>
@endif
@if(Session('question'))
<script>
    var Toastr = main();    
        Toastr.fire({
        icon: 'question',
        title: "&nbsp; {{Session::get('question')}}",
      });
</script>
@endif

@if(count($errors) > 0)
<script>
    var msg = ""; 
    @foreach($errors->all() as $error)
        msg += "&nbsp; {!!$error!!} <br />"
    @endforeach
 

    var Toastr = main();    
        Toastr.fire({
        icon: 'error',
        title: msg,
      });
</script>
@endif
@if(Session('uploadserror'))
<script>   
    var Toastr = mainconfirms();  
    $(function () {
        Toastr.fire({
            icon: 'error',
            title: "&nbsp;{{ Session::get('uploadserror')}}",
        }); 
    });
</script>
@endif