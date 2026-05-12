$(function () {
    if ($('#permisos_table').length != 0) {
        $("#permisos_table").DataTable({
            "lengthMenu": [10, 20,15,30,50,60],
            "responsive": true,
            "lengthChange":true,
            "autoWidth": false,
            "ordering": true,
            //"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        });
    }
}); 