
$(document).ready(function () {
    
    $.validator.addMethod("alMenosUnoSeleccionado", function (value, element) {
        return $('.check:checked').length > 0;
    }, "Se debe seleccionar al menos una opción de activación");
    
    $("#venta-polizas").validate({
        lang: 'es',
        errorElement: 'span',
        ignore: [],
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
        highlight: function (element) {
            $(element).closest('.form-control').addClass('is-invalid');
            $('.nav-tabs').find('small.required').remove();
            var validatePane = $('.tab-content .tab-pane:has(.is-invalid)').each(function () {
                var id = $(this).attr('id');
                $('.nav-tabs').find('a.nav-link[aria-controls=' + id + ']').append(' <small class="required" style="color:red;"> <b>*</b></small>');
            });
        },
        unhighlight: function (element) {
            $(element).closest('.form-control').removeClass('is-invalid');
            $(element).closest('.form-control').addClass('is-valid');
        },
        submitHandler: function (form) {
            event.preventDefault();
                      
            Swal.fire({
                title: "CONFIRMACION",
                html:"¿Esta de Acuerdo con la información proporcionada?",
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: "Procesar",
                denyButtonText: "Regresar",
                cancelButtonText: "Cancelar",
              /*  preConfirm: (login) => {
                        $('#FinishVenta').prop('disabled',true);
                        return new Promise((resolve) => {

                            // Simulamos una llamada AJAX o una operación de base de datos
                            // Esto podría ser tu $.ajax() o fetch()
                            setTimeout(() => {
                                const exitoSimulado = Math.random() > 0.3; // 70% de éxito

                                if (exitoSimulado) {
                                    
                                    $('#buttonModalConfirm').text('Enviando...'); 
                                    $('#buttonModalConfirm').prop('disabled', true);
                                    resolve(true); // Puedes pasar cualquier valor que luego uses en .then()
                                } else {

                                    // Opción 1: Mostrar un error dentro del mismo SweetAlert
                                    Swal.update({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'No se pudo enviar la información.',
                                        showConfirmButton: true, // Asegura que el botón de confirmación esté visible de nuevo
                                        showCancelButton: false, // Oculta el cancelar si solo hay una opción
                                        confirmButtonText: 'Entendido',
                                        showLoaderOnConfirm: false // Oculta el loader
                                    });
                                    $('#FinishVenta').prop('disabled',false);
                                }
                            }, 2000); // Simula un retardo de 3 segundos para la operación
                        });
                    },*/
                }).then((result) => {
                if (result.isConfirmed) {
                    $('#buttonModalConfirm').text('Enviando...'); 
                    $('#buttonModalConfirm').prop('disabled', true);
                    $('.readonly').removeAttr('disabled', 'disabled'); 
                    $('.readonly').attr('readonly', 'readonly'); 
                    $('#FinishVenta').prop('disabled',true);
                     form.submit();
                    
                }
            });

        }
    });
    
     $("#venta-polizas-manual").validate({
        lang: 'es',
        errorElement: 'span',
        ignore: [],
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
        highlight: function (element) {
            $(element).closest('.form-control').addClass('is-invalid');
            $('.nav-tabs').find('small.required').remove();
            var validatePane = $('.tab-content .tab-pane:has(.is-invalid)').each(function () {
                var id = $(this).attr('id');
                $('.nav-tabs').find('a.nav-link[aria-controls=' + id + ']').append(' <small class="required" style="color:red;"> <b>*</b></small>');
            });
        },
        unhighlight: function (element) {
            $(element).closest('.form-control').removeClass('is-invalid');
            $(element).closest('.form-control').addClass('is-valid');
        },
        submitHandler: function (form) {
            event.preventDefault();
                      
            Swal.fire({
                title: "CONFIRMACION",
                html:"Una Vez registrada, los datos del cliente no podran ser modificados, ¿Esta de Acuerdo con la información proporcionada?",
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: "Procesar",
                denyButtonText: "Regresar",
                cancelButtonText: "Cancelar",
              /*  preConfirm: (login) => {
                        $('#FinishVenta').prop('disabled',true);
                        return new Promise((resolve) => {

                            // Simulamos una llamada AJAX o una operación de base de datos
                            // Esto podría ser tu $.ajax() o fetch()
                            setTimeout(() => {
                                const exitoSimulado = Math.random() > 0.3; // 70% de éxito

                                if (exitoSimulado) {
                                    
                                    $('#buttonModalConfirm').text('Enviando...'); 
                                    $('#buttonModalConfirm').prop('disabled', true);
                                    resolve(true); // Puedes pasar cualquier valor que luego uses en .then()
                                } else {

                                    // Opción 1: Mostrar un error dentro del mismo SweetAlert
                                    Swal.update({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'No se pudo enviar la información.',
                                        showConfirmButton: true, // Asegura que el botón de confirmación esté visible de nuevo
                                        showCancelButton: false, // Oculta el cancelar si solo hay una opción
                                        confirmButtonText: 'Entendido',
                                        showLoaderOnConfirm: false // Oculta el loader
                                    });
                                    $('#FinishVenta').prop('disabled',false);
                                }
                            }, 2000); // Simula un retardo de 3 segundos para la operación
                        });
                    },*/
                }).then((result) => {
                if (result.isConfirmed) {
                    $('#buttonModalConfirm').text('Enviando...'); 
                    $('#buttonModalConfirm').prop('disabled', true);
                    $('.readonly').removeAttr('disabled', 'disabled'); 
                    $('.readonly').attr('readonly', 'readonly'); 
                    $('#FinishVenta').prop('disabled',true);
                    form.submit();
                    
                }
            });

        }
    });
    
    $("#incidencias").validate({
        lang: 'es',
        errorElement: 'span',
        ignore: [],
        errorPlacement: function (error, element) {
             // Para otros elementos, lo colocamos normalmente
                error.addClass('is-invalid text-sm');
                element.closest('.form-group').append(error);
                           
        },
        highlight: function (element) {
            $(element).closest('.form-control').addClass('is-invalid');           
        },
        unhighlight: function (element) {
            $(element).closest('.form-control').removeClass('is-invalid');
            $(element).closest('.form-control').addClass('is-valid');
        },
        submitHandler: function (form) {
            // event.preventDefault();
            // $(':input[type="submit"]').prop('disabled', true);
            form.submit();
        }
    });
    
    $("#AsignarClientes").validate({
        lang: 'es',
        errorElement: 'span',
        ignore: [],
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
        highlight: function (element) {
            $(element).closest('.form-control').addClass('is-invalid');           
        },
        unhighlight: function (element) {
            $(element).closest('.form-control').removeClass('is-invalid');
            $(element).closest('.form-control').addClass('is-valid');
        },
        submitHandler: function (form) {
            // event.preventDefault();
           
            form.submit();
        }
    });
    
     $("#DescargarReportes").validate({
        lang: 'es',
        errorElement: 'span',
        ignore: [],
        errorPlacement: function (error, element) {
             // Para otros elementos, lo colocamos normalmente
                error.addClass('is-invalid text-sm');
                element.closest('.form-group').append(error);
                           
        },
        highlight: function (element) {
            $(element).closest('.form-control').addClass('is-invalid');           
        },
        unhighlight: function (element) {
            $(element).closest('.form-control').removeClass('is-invalid');
            $(element).closest('.form-control').addClass('is-valid');
        },
        submitHandler: function (form) {
            // event.preventDefault();
            // $(':input[type="submit"]').prop('disabled', true);
            form.submit();
        }
    });
});


