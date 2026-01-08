$(function () {
  bsCustomFileInput.init();   
});

$(function () {
    if ($('#datatables').length != 0) {
        $("#datatables").DataTable({
            "lengthMenu": [10, 20, 15, 30, 50, 60],
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "ordering": true,
            //"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        });
    }    
    $('.check').rules('add', {
        alMenosUnoSeleccionado: true
    });

});

$("#select_all").on('change', function () {
    $("input:checkbox").prop('checked', $(this).prop("checked"));
});

$.validator.addMethod("validateExtention", function (value, element) {
    $(element).closest('.form-group').addClass('is-invalid');
    var ext = value.split('.').pop();
    if (!['csv'].includes(ext)) {
        return false;
    } else {
        return true;
    }
}, "No se permite archivos con esta Extensión, Use Solo  CSV ");

$.validator.addMethod("alMenosUnoSeleccionado", function (value, element) {
    return $('.check:checked').length > 0;
}, "Se debe seleccionar al menos una opción de activación");
    
$('#uploadFile').validate({  
    lang: 'es', 
    rules:{
        archivo: {
            validateExtention:true
        }, 
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
        error.addClass('is-invalid text-sm');
        element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
    },
    submitHandler: function (form) {
    form.submit();
    }
});

$('#DeletedFiles').validate({  
    lang: 'es',     
    errorElement: 'span',
    errorPlacement: function (error, element) {
        if (element.is(':checkbox')) {
                // Si es un checkbox, lo colocamos después del grupo de checkboxes              
                var Toastr = main();
                Toastr.fire({icon: 'error', title: error});
            } else {
                // Para otros elementos, lo colocamos normalmente
                error.addClass('is-invalid text-sm');
                element.closest('.form-group').append(error);
            }
    },
    highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
    },
    submitHandler: function (form) {
    event.preventDefault();                      
            Swal.fire({
                title: "¿Esta seguro en eliminar este Lote de registros?, esta acción no puede ser revertida y eliminara el historico generado de cada cliente.",
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: "Procesar",
                denyButtonText: "Regresar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {                   
                   form.submit();
                }
            });
    }
});