 $(function () {
    $('.duallistbox').bootstrapDualListbox({
        nonSelectedListLabel: 'Non-selected',
        selectedListLabel: 'Selected',
        preserveSelectionOnMove: 'moved',
        moveOnSelect: false,
    });
 });
 
 $('#permisos').on('change', function () {
        $(this).bootstrapDualListbox('refresh',true);
});
 
 
    $(function () {
     if ($('#roles_table').length != 0) {
        $("#roles_table").DataTable({
            "lengthMenu": [10, 20,15,30,50,60],
            "responsive": true,
            "lengthChange":true,
            "autoWidth": false,
            "ordering": true,
            //"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        });
    }
 });
 