var Edad = function () {
    var Calcular = function () {
        if ($('#edad').length > 0) {
            
            var campoedad = $('#edad');
            //var edad = calculateAge(fechacliente);      
            var partes      = $('#fecha_de_nacimiento').val().split("/");
            var dia         = parseInt(partes[0], 10);
            var mes         = parseInt(partes[1], 10) - 1; // Los meses en JavaScript son 0-11
            var anio        = parseInt(partes[2], 10); 
                  
            var fechaNac = new Date(anio, mes, dia);
            
            var fechaActual = new Date();
            
            var edad = fechaActual.getFullYear() - fechaNac.getFullYear();
            var mesActual = fechaActual.getMonth();
            var diaActual = fechaActual.getDate();

            // Ajustar la edad si aún no ha cumplido años este año
            if (mesActual < mes || (mesActual === mes && diaActual < dia)) {
                edad--;
            }
            
            campoedad.val(edad);
        }
    };
    return {
        // public functions
        init: function () {
            Calcular();
        }
    };
}();

$(document).ready(function () {

    if ($('.calendarfecha').length != 0) {
        $(function () {
            $('.calendarfecha').datetimepicker({
                format: 'DD/MM/YYYY'
            });
        });
    }
    
    if ($('.calendartxt').length != 0) {
        console.log("active");
        $(function () {
            $('.calendartxt').daterangepicker({     
                  singleDatePicker: true,
                format: 'DD/MM/YYYY',             
                maxDate: moment(),
            });
        });
    }

        if ($('.calendar').length != 0) {
        console.log("active");
        $(function () {
            $('.calendar').daterangepicker({     
                format: 'DD/MM/YYYY',             
                maxDate: moment(),
            });
        });
    }
    
    if ($('.calendarangofecha').length != 0) {
        
        $(function () {
            $('.calendarangofecha').daterangepicker({                      
                format: 'DD/MM/YYYY',             
                maxDate: moment(),
            });
        });
    }
    
    if ($('#fecha_de_nacimiento').length != 0) {
        $(function () {
            $('#fecha_de_nacimiento').datetimepicker({
                format: 'DD/MM/YYYY'
            });
        });
    }
    
    if ($('#fechavencedula').length != 0) {
        $(function () {
            $('#fechavencedula').datetimepicker({
                format: 'MM/YYYY'
            });
        });
    }
    
    if ($('#agendamiento').length != 0) {
        $(function () {
            $('#agendamiento').datetimepicker({
                format: 'DD/MM/YYYY',
                minDate: moment()                
            });
        });
    }

    ///instancia la edad actual del cliente al desplegar el formulario
    Edad.init();

    $('#cd_edo_civil').on('change', function () {
        console.log("ejecuta", $(this).val());
        $(this).val() === "C" ? $('#apellcasada').removeAttr('readonly') : $('#apellcasada').attr('readonly', 'readonly');
    });

    window.onload = maskAllInputs(), CalculoPrimasInputs();


});

$(function () {

    $('.input-number').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    
     $('.input-text').on('input', function () {
        this.value = this.value.replace(/[^A-Za-z\s]/g,'');
    });
    ///añadimos validaciones de los checkbox
    $('.check').rules('add', {
        alMenosUnoSeleccionado: true
    });

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
});
///tabla principal de planes
$(function () {
    if ($('#tableproductos').length != 0) {
        $("#tableproductos").DataTable({
            "lengthMenu": [5],
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "ordering": false,
            "bFilter": false
                    //"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        });
    }
});

function calculateAge(campo1) {
    var FechaNac_a = campo1.split("/");
    var diaCumple_a = FechaNac_a[0];
    var mmCumple_a = FechaNac_a[1];
    var yyyyCumple_a = FechaNac_a[2];
    var fechaCumpleano = diaCumple_a + '-' + mmCumple_a + '-' + yyyyCumple_a;
    var fechaActual = new Date();
    var fechaDiatemp = fechaActual.getDate();
    var fechaDiaActual = (fechaDiatemp < 10) ? '0' + fechaDiatemp : fechaDiatemp;
    var fechaMestemp = (fechaActual.getMonth() + 1);
    var fechaMesActual = (fechaMestemp < 10) ? '0' + fechaMestemp : fechaMestemp;
    var fechaAnioActual = fechaActual.getFullYear();

    var fechaHoy = fechaDiaActual + "-" + fechaMesActual + "-" + fechaAnioActual;

    //alert('FECHA_HOY->'+fechaHoy)
    //alert('FECHA_NACIMIENTO->'+fechaCumpleano)

    var aFecha1 = fechaCumpleano.split('-');
    var aFecha2 = fechaHoy.split('-');
    var fFecha1 = Date.UTC(aFecha1[2], aFecha1[1] - 1, aFecha1[0]);
    var fFecha2 = Date.UTC(aFecha2[2], aFecha2[1] - 1, aFecha2[0]);
    var dif = fFecha2 - fFecha1;
    var dias = Math.floor(dif / (1000 * 60 * 60 * 24));
    //alert (dias);

    var diferencia = Math.round(dias / 365);

    return diferencia;

}

function CalcularEdad() {    
        var campoedad = $('#edad');
        //var edad = calculateAge(fechacliente);      
        var partes      = $('#fecha_de_nacimiento').val().split("/");
        var dia         = parseInt(partes[0], 10);
        var mes         = parseInt(partes[1], 10) - 1; // Los meses en JavaScript son 0-11
        var anio        = parseInt(partes[2], 10); 

        var fechaNac = new Date(anio, mes, dia);

        var fechaActual = new Date();

        var edad = fechaActual.getFullYear() - fechaNac.getFullYear();
        var mesActual = fechaActual.getMonth();
        var diaActual = fechaActual.getDate();

        // Ajustar la edad si aún no ha cumplido años este año
        if (mesActual < mes || (mesActual === mes && diaActual < dia)) {
            edad--;
        }

        campoedad.val(edad);
}

function EstadosChange() {

    var data = {
        tipo: "estado",
        estado: $('#estado_id').val(),
        _token: $("input[name='_token']").val()
    }
    var url = $('#estado_id').data('href');
    
    $('#ciudad_id').empty();
    $('#municipio_id').empty();
    $('#parroquia_id').empty();
    $('#urbanizacion_id').empty();
    
    $.ajax({
        url: url,
        method: "POST",
        data: data,
        dataType: "JSON",
        cache: "false",
        success: function (data)
        {
            var Seleccioneact = "[Seleccione]";
            $('#ciudad_id').append($("<option></option>").attr("value", "").text(Seleccioneact));
            for (i = 0; i < data.length; i++)
            {
                $('#ciudad_id').append($("<option></option>").attr("value", data[i].id).text(data[i].nombre_ciudad));
            }
            ;
        }
    });


}

function CiudadChange() {

    var data = {
        tipo: "ciudad",
        ciudad: $('#ciudad_id').val(),
        estado: $('#estado_id').val(),
        _token: $("input[name='_token']").val()
    }
    var url = $('#estado_id').data('href');
    $('#municipio_id').empty();     
    $('#parroquia_id').empty();
    $('#urbanizacion_id').empty();
    $.ajax({
        url: url,
        method: "POST",
        data: data,
        dataType: "JSON",
        cache: "false",
        success: function (data)
        {
            var Seleccioneact = "[Seleccione]";
            $('#municipio_id').append($("<option></option>").attr("value", "").text(Seleccioneact));
            for (i = 0; i < data.length; i++)
            {
                $('#municipio_id').append($("<option></option>").attr("value", data[i].id).text(data[i].nombre_municipio));
            }
            ;
        }
    });


}

function MunicipioChange() {

    var data = {
        tipo: "municipio",
        ciudad: $('#ciudad_id').val(),
        estado: $('#estado_id').val(),
        municipio: $('#municipio_id').val(),
        _token: $("input[name='_token']").val()
    }
    var url = $('#estado_id').data('href');
    $('#parroquia_id').empty();
    $('#urbanizacion_id').empty();
    $.ajax({
        url: url,
        method: "POST",
        data: data,
        dataType: "JSON",
        cache: "false",
        success: function (data)
        {
            var Seleccioneact = "[Seleccione]";
            $('#parroquia_id').append($("<option></option>").attr("value", "").text(Seleccioneact));
            for (i = 0; i < data.length; i++)
            {
                $('#parroquia_id').append($("<option></option>").attr("value", data[i].id).text(data[i].nombre_parroquia));
            }
            ;
        }
    });


}

function ParroquiaChange() {

    var data = {
        tipo: "parroquia",
        ciudad: $('#ciudad_id').val(),
        estado: $('#estado_id').val(),
        municipio: $('#municipio_id').val(),
        parroquia: $('#parroquia_id').val(),
        _token: $("input[name='_token']").val()
    }
    var url = $('#estado_id').data('href');
    $('#urbanizacion_id').empty();
    $.ajax({
        url: url,
        method: "POST",
        data: data,
        dataType: "JSON",
        cache: "false",
        success: function (data)
        {
            var Seleccioneact = "[Seleccione]";
            $('#urbanizacion_id').append($("<option></option>").attr("value", "").text(Seleccioneact));
            for (i = 0; i < data.length; i++)
            {
                $('#urbanizacion_id').append($("<option></option>").attr("value", data[i].id).text(data[i].nombre_urbanizacion).attr('data-codigo',data[i].codigo_postal));
            }
            ;
        }
    });


}

function UrbanizacionChange() {
   
    $('#codigo_postal_hab').val($('#urbanizacion_id option:selected').data('codigo'));
    
}

///enmascara todos los inputs de cuenta bancaria
function maskAllInputs() {

    const inputs = document.querySelectorAll('.confidential');
    inputs.forEach(input => {
        maskInput(input); // Llama a la función para cada input
    });
}
///enmascara un input de cuenta bancaria
function maskInput(input) {

    const masked = input.value.length > 4 ? '**' + '*'.repeat(input.value.length - 4) + input.value.slice(-4) : input.value;
    const identdisplay = $('#' + input.id).data('plan'); // Selecciona el siguiente elemento <p>
    const displayElement = $('#textdisplay' + identdisplay);
    displayElement.empty();
    displayElement.append(masked); // Muestra el texto enmascarado    
    //console.log(displayElement);
}

function CalculoPrimasInputs() {

    const inputs = document.querySelectorAll('.PrimasAll');
    inputs.forEach(input => {
        CalculoPrimas(input); // Llama a la función para cada input
    });
}

function ChangePrimas(value) {
    var input = document.querySelector('#prima' + value);
    CalculoPrimas(input);
}

function CalculoPrimas(input) {

    var plan = $('#' + input.id).data('plan');
    var recargo = plan;
         
    var data = {
        campoedad: $('#edad').val(),
        _token: $("input[name='_token']").val(),
        plan: plan,
        sumaasegurada: $('#suma_asegurada' + plan).val(),
        tipodePago: $('#tipo_de_pago' + plan).val()
    };

    var url = $('#' + input.id).data('href');

    $.ajax({
        url: url,
        method: "POST",
        data: data,
        dataType: "JSON",
        cache: "false",
        success: function (data)
        {
            //console.log(recargo);
            if([1,2,5].includes(recargo)){
                var monto = 0.33;
            } else {
                 var monto = 0;
            }
            $('#' + input.id).val(data+monto);
            const Primas = document.querySelectorAll('#' + input.id);
            SelectActivePlan(Primas);
        }
    });
}

///imprimir el estado actual de a domiciliacion de pago al abrir el modal
function EditDomicilio(idplan) {

    var nombre_plan = $('#plan' + idplan).val();
    $('#buttonModalConfirm').attr('Onclick', 'ConfirmacionCambioDomicilio('+idplan+')');
    /// ponemos nombre al modal
    $('#nombredelplanmodal').empty();
    $('#nombredelplanmodal').append("Domicilación de pagos para el Plan: " + nombre_plan);

    if ($('#tipocuenta' + idplan).val() === "C" || $('#tipocuenta' + idplan).val() === "A") {
        /// para los casos que le domiciliacion sea por cuenta bancaria
        $('#domicilioadoa').val("1").attr("selected");

        var bancoviejo = $('#banco' + idplan).val();
        $('#newbanco').val(bancoviejo).attr('selected');

        var cuenta_vieja = $('#instrumento' + idplan).data('cuenta');
        $('#instrumentonew').val(cuenta_vieja);

        var cuentas = ["C", "A"];
        var tipocuenta = $('#tipocuenta' + idplan).val();
        
        $('#tipoinstrumentonew').empty();
        $('#tipoinstrumentonew').append($("<option></option>").attr("value", "").text("[SELECCIONE]"));
        for (i = 0; i < cuentas.length; i++)
        {
            $('#tipoinstrumentonew').append($("<option></option>").attr("value", cuentas[i]).text(cuentas[i]));
        }        

        $('#tipoinstrumentonew option[value=' + tipocuenta + ']').attr("selected", true);

    } else {
        $('#domicilioadoa').val("2").attr("selected");

        var bancoviejo = $('#banco' + idplan).val();
        $('#newbanco').val(bancoviejo).attr('selected');

        var cuenta_vieja = $('#instrumento' + idplan).data('cuenta');
        $('#instrumentonew').val(cuenta_vieja);

        var cuentas = ["VISA", "MASTERCARD", "DINERCLUB"];
        var tipocuenta = $('#tipocuenta' + idplan).val();
        
        $('#tipoinstrumentonew').empty();
        $('#tipoinstrumentonew').append($("<option></option>").attr("value", "").text("[SELECCIONE]"));
        for (i = 0; i < cuentas.length; i++)
        {
            $('#tipoinstrumentonew').append($("<option></option>").attr("value", cuentas[i]).text(cuentas[i]));
        }

        $('#tipoinstrumentonew option[value=' + tipocuenta + ']').attr("selected", true);
    }
    
}

///para editar la domicialcion del modal
$('#domicilioadoa').on('change', function () {

    ///1 para cuenta bancaria
    if ($(this).val() === "1") {
        var cuentas = ["C", "A"];
        
    if ($('#instrumentonew').data('DateTimePicker')) {
        $('#instrumentonew').datetimepicker('destroy');
        $('#instrumentonew').val('');
    }
       
    } else {
        ///2 para Tarjeta
        var cuentas = ["VISA", "MASTERCARD", "DINERCLUB"];
        $('#instrumentonew').datetimepicker({
            format: 'MM/YYYY',                              
        }).val(moment().format('MM/YYYY'));
    }

    $('#newbanco').val($('#newbanco > option:first').val());
    $('#tipoinstrumentonew').empty();
    $('#tipoinstrumentonew').append($("<option></option>").attr("value", "").text("[SELECCIONE]"));

    for (i = 0; i < cuentas.length; i++) {
        $('#tipoinstrumentonew').append($("<option></option>").attr("value", cuentas[i]).text(cuentas[i]));
    }
    
});

///esto para confirmar la nueva domicilacion de pagos
function ConfirmacionCambioDomicilio(idplan) {
    
    Swal.fire({
        title: "¿Esta seguro sobre el cambio de Domicilio para el Plan: "+$('#plan'+idplan).val()+" ?",
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonText: "Procesar",
        denyButtonText: "Regresar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            /// tipo de cuenta a domicilar 
            $('#tipocuenta' + idplan).val($('#tipoinstrumentonew').val());
            
            $('#texttipocuenta'+idplan).empty();
            $('#texttipocuenta'+idplan).html($('#tipoinstrumentonew').val());
            
            $('#banco' + idplan).val($('#newbanco').val());
            
            $('#instrumento' + idplan).val($('#instrumentonew').val());
            $('#instrumento' + idplan).data('cuenta',$('#instrumentonew').val());
            
            var input = document.querySelectorAll('#instrumento'+idplan);
            ///enmascaramos el numero de instrumento a domiciliar
            maskInput(input[0]);
            ///cerramos modal
            $('#modal-default').modal('hide');            
        }   
    });
}

function SelectActivePlan(input) {

    var suma = 0, mensual = 0, trimestral = 0, anual = 0, semestral = 0;
    $('#monto_mensual').val('0');
    $('#monto_anual').val('0');
    $('#monto_trimestral').val('0');
    $('#monto_semestral').val('0');
    $('#monto_total').val('0');
    
    const Primas = document.querySelectorAll('.PrimasAll');
    Primas.forEach(input => {

        var InputNumberPrima = $("#" + input.id).data('plan');

        if ($("#activarplan" + InputNumberPrima).is(':checked')) {
            ///valor total de loas primas
            suma = suma + parseFloat($('#prima' + InputNumberPrima).val());

            ///segmentacion de primas por el tipo de pago
            switch ($('#tipo_de_pago' + InputNumberPrima).val()) {
                case "M":
                    mensual = mensual + parseFloat($('#prima' + InputNumberPrima).val());
                    
                     $('#monto_mensual').val(mensual.toFixed(2));
                    break;
                case "T":
                    trimestral = trimestral + parseFloat($('#prima' + InputNumberPrima).val());
                   
                    $('#monto_trimestral').val(trimestral.toFixed(2));
                    break;
                case "A":
                    anual = anual + parseFloat($('#prima' + InputNumberPrima).val());
                    
                    $('#monto_anual').val(anual.toFixed(2));
                    break;
                case "S":
                    semestral = semestral + parseFloat($('#prima' + InputNumberPrima).val());
                    
                    $('#monto_semestral').val(semestral.toFixed(2));
                    break;
            }
              $('#monto_total').val(suma.toFixed(2));
        } 
    }); 
    
    $('#FinishVenta').removeAttr('disabled');
}

function Incidencias(){
    $('#tipificacion1 ').val('');
    $('#tipificacion2').empty();
    $('#tipificacion3').empty();
    $('#identificador_llamada').val($('#identificador_llamada_prin').val());
    $('#comentario').val(null);
}

$('#tipificacion1').on('change', function () {

    var data = {
        tipificacion1: $(this).val(),        
        _token: $("input[name='_token']").val()
    };
    var url = $(this).data('href');
             
    $('#tipificacion2').empty();
    $('#tipificacion3').empty();
    $('#displayagendamiento').fadeOut();
    $('#agendamiento').removeAttr('required','required'); 
    $.ajax({
        url: url,
        method: "POST",
        data: data,
        dataType: "JSON",
        cache: "false",
        success: function (data)
        {
            var Seleccioneact = "[Seleccione]";
            $('#tipificacion2').append($("<option></option>").attr("value", "").text(Seleccioneact));
            for (i = 0; i < data.length; i++)
            {
                $('#tipificacion2').append($("<option></option>").attr("value", data[i].id).text(data[i].descripcion));
            }
            ;
        }
    });

});

$('#tipificacion2').on('change', function () {

    var data = {
        tipificacion1: $(this).val(), 
        tipificacion2: $(this).val(),      
        _token: $("input[name='_token']").val()
    };
    var url = $(this).data('href');
       
    if($(this).val() === "4" || $(this).val() === "18" ){
       $('#displayagendamiento').fadeIn();
       $('#agendamiento').attr('required','required');
    }else {
       $('#displayagendamiento').fadeOut();
       $('#agendamiento').removeAttr('required','required'); 
    }

    $('#tipificacion3').empty();
     $.ajax({
        url: url,
        method: "POST",
        data: data,
        dataType: "JSON",
        cache: "false",
        success: function (data)
        {
            var Seleccioneact = "[Seleccione]";
            $('#tipificacion3').append($("<option></option>").attr("value", "").text(Seleccioneact));
            for (i = 0; i < data.length; i++)
            {
                $('#tipificacion3').append($("<option></option>").attr("value", data[i].id).text(data[i].descripcion.toUpperCase()));
            }
            ;
        }
    });
});

$('#searchAgendados').on('click', function () {
    var data = {
        fecha: $('#fecha').val(),
        _token: $("input[name='_token']").val()
    };

    var url = $(this).data('href');

    if ($.fn.dataTable.isDataTable('#datatables')) {
        $('#displaytable').hide();
        $('#datatables').DataTable().destroy();
    }
    $('#datatables').DataTable({
        "initComplete": function (settings, json) {
            $('#displaytable').show();
        },
        "responsive": true,
        "ordering": true,
        "ajax": {
            "url": url,
            error: function (jqXHR, ajaxOptions, thrownError) {
                var Toastr = main();
                Toastr.fire({
                    icon: 'error',
                    title: "Lo sentimos, Ocurrio un problema durante la Consulta." + jqXHR.responseText,
                });
            },
            "dataType": "json",
            "type": "POST",
            "data": data,
            dataSrc: ""
        },
        "lengthMenu": [10, 20, 50, 75, 100, 200, 300],
        processing: true,
        "bPaginate": true,
        "bProcessing": true,
        "autoWidth": false,
        "columns": [
            {mData: "num"},
            {mData: "cedula"},
            {mData: "nombres"},
            {mData: "nacimiento"},
            {mData: "comentario"},
            {mData: "acciones"},
        ]
    });
});

$('#consolidadoSearch').on('click', function () {

    var data, url;

    url = $(this).data('href');
    data = {
        fecha: $('#rango_fecha').val(),
        _token: $("input[name='_token']").val()
    }

    if ($.fn.dataTable.isDataTable('#datatables')) {
       
        $('#datatables').DataTable().destroy();
    }
    $('#datatables').DataTable({        
        "responsive": true,
        "ordering": true,
        "ajax": {
            "url": url,
            error: function (jqXHR, ajaxOptions, thrownError) {
                var Toastr = main();
                Toastr.fire({
                    icon: 'error',
                    title: "Lo sentimos, Ocurrio un problema durante la Consulta." + jqXHR.responseText,
                });
            },
            "dataType": "json",
            "type": "POST",
            "data": data,
            dataSrc: ""
        },
        "lengthMenu": [10, 20, 50],
        processing: true,
        "bPaginate": true,
        "bProcessing": true,
        "autoWidth": false,
        "columns": [
            {mData: "nro"},
            {mData: "nombre"},
            {mData: "generadas"},
            {mData: "globales"},          
        ]
    });
});

function deletedVentas(id){
    
    $("#modal-deleted").modal('show');
    
    var ruta = $('#ruta'+id).val();
    var form = $("#deleted");     
    form.attr('action', ruta);
    
    $('#razones').val('');
}
 
$("#deleted").validate({
        lang: 'es',
        errorElement: 'span',
        ignore: [],
        errorPlacement: function (error, element) {
            $(element).closest('.form-control').addClass('is-invalid');       
        },
        highlight: function (element) {
            $(element).closest('.form-control').addClass('is-invalid');            
        },
        unhighlight: function (element) {
            $(element).closest('.form-control').removeClass('is-invalid');
            $(element).closest('.form-control').addClass('is-valid');
        },
        submitHandler: function (form) {
            event.preventDefault();
                      
            Swal.fire({
                title: "¿Esta de acuerdo con procesar esta eliminación?",
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: "Procesar",
                denyButtonText: "Regresar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    $(':input[type="submit"]').prop('disabled', true);                   
                   form.submit();
                }
            });

        }
    });

$("#tipificacionSearch").click(function () {

    if($('#n_cedula').val() == "" && $('#telefono').val() == ""){

    var Toastr = main();
        Toastr.fire({
            icon: 'error',
            title: 'Por favor introduzca el numero de cedula o telefono del cliente',
        });

    }else if($('#n_cedula').val() != "" && $('#telefono').val() != ""){
            
            var Toastr = main();
        Toastr.fire({
            icon: 'error',
            title: 'Solo puedes buscar por cedula o telefono',
        });

    }else{

    var url = $(this).data('href');
    var data = {
        n_cedula: $('#n_cedula').val(),
        telefono: $('#telefono').val(),
        rango_fecha: $('#rango_fecha').val(),
        _token: $("input[name='_token']").val()
    };
   
        if ($.fn.dataTable.isDataTable('#datatable-tipificaciones')) {
            $('#displaytable_tipificacion').fadeOut();
            $('#datatable-tipificaciones').DataTable().destroy();
        }
        $('#datatable-tipificaciones').DataTable({
            "initComplete": function (settings, json) {
                $('#displaytable_tipificacion').fadeIn();
            },
            "responsive": true,
            "ordering": true,
            "autoWidth": false,
            "ajax": {
                "url": url,
                "dataType": "json",
                "type": "POST",
                "data": data,
                dataSrc: ""
            },
            "lengthMenu": [10, 20, 50, 75],
            "bPaginate": true,
            "bProcessing": true,
            "columns": [                           
                {mData: 'fecha_llamada'},
                {mData: 'cedula'},              
                {mData: 'nombres'},  
                {mData: 'fecha_nac'},
                {mData: 'email'},
                {mData: 'telefonos'},
                {mData: 'operador'},
                {mData: 'info_cuenta'},
                {mData: 'primas_montos'},
                {mData: 'tipi1'},
                {mData: 'tipi2'},
                {mData: 'tipi3'},
                {mData: 'observaciones'}
            ]
        }); 
        }   
});


///para editar la domicialcion del modal
$('#domicilioadomanual').on('change', function () {

    ///1 para cuenta bancaria
    if ($(this).val() === "1") {
        var cuentas = ["C", "A"];
        
    if ($('#instrumentonewmanual').data('DateTimePicker')) {
        $('#instrumentonewmanual').datetimepicker('destroy');
        $('#instrumentonewmanual').val('');
    }
       
    } else {
        ///2 para Tarjeta
        var cuentas = ["VISA", "MASTERCARD", "DINERCLUB"];
        $('#instrumentonewmanual').datetimepicker({
            format: 'MM/YYYY',                              
        }).val(moment().format('MM/YYYY'));
    }

    $('#newbancomanual').val($('#newbancomanual > option:first').val());
    $('#tipoinstrumentonewmanual').empty();
    $('#tipoinstrumentonewmanual').append($("<option></option>").attr("value", "").text("[SELECCIONE]"));

    for (i = 0; i < cuentas.length; i++) {
        $('#tipoinstrumentonewmanual').append($("<option></option>").attr("value", cuentas[i]).text(cuentas[i]));
    }
    
});

$('#instrumentonewmanual').on('change', function () {

    var selector = document.querySelectorAll('#instrumentonewmanual');
    var input = selector[0];
    
    const masked = input.value.length > 4 ? '**' + '*'.repeat(input.value.length - 4) + input.value.slice(-4) : input.value;
 
    $('.texttipocuenta').empty();
    $('.texttipocuenta').html($('#tipoinstrumentonewmanual').val());
    $('.nuevosbancos').val($('#newbancomanual').val()).attr('selected');
            
    const displayElement = $('.textdisplay');
    displayElement.empty();
    displayElement.append(masked); // Muestra el texto enmascarado    
});


$('#newbancomanual').on('change', function () {

     $('.nuevosbancos').val($(this).val()).attr('selected');
});

$('#n_cedula_manual').on('blur', function () {

    var url = $(this).data('href');
    var data = {
        cedula: $(this).val(),
        _token: $("input[name='_token']").val()
    };    
    if ($('#n_cedula_manual').val() === '') {
        var Toastr = main();
        Toastr.fire({
            icon: 'info',
            title: "Se require Verificar la Cedula de Identidad.",
        });
        $('#FinishVenta').prop('disabled', true);
    } else{
      $.ajax({
        url: url,
        method: "POST",
        data: data,
        dataType: "JSON",
        cache: "false",
        success: function (data)
        {
            if (data) {               
                var Toastr = main();
                Toastr.fire({
                    icon: 'error',
                    title: "Lo sentimos, la cedula ingresada ya se encuentra registrada",
                });
                $('#FinishVenta').prop('disabled', true);
            } else {
                var Toastr = main();
                Toastr.fire({
                    icon: 'info',
                    title: "Cliente no registrado, se puede Vender.",
                });
                $('#FinishVenta').prop('disabled', false);
            }

        }, error: function (jqXHR, ajaxOptions, thrownError) {
                var Toastr = main();
                Toastr.fire({
                    icon: 'error',
                    title: "Lo sentimos, Ocurrio un problema durante la Consulta." + jqXHR.responseText,
                });
            }
    });
    }
});

