$(document).ready(function () {
    /* ===================================================
        REFRESCAR LA PÁGINA
    ===================================================*/
    var timeout = 60*60*1000;
    setInterval(() => {
        window.location.href = window.location.href;
    }, timeout);

    /* ===================================================
          DATATABLE
        ===================================================*/
    $('.tablaTV').DataTable({
        order: [],
        searching: false,
        paging: false,
        bInfo : false
    });
});