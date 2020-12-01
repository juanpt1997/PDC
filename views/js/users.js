if (window.location.href.includes("users")) {
    $(document).ready(function () {
        /* ===================================================
          DATATABLE
        ===================================================*/
        $('.tablaUsuarios').DataTable({

            "language": {

                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
                "sInfoFiltered": "<div class='small'>(filtrado de un total de _MAX_ registros)</div>",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }

            },
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todo"]]


        });

        /*================================================ 
            EDITAR USUARIO   
        ================================================*/
        $(document).on("click", ".btnEditarUsuario", function () {

            var idUser = $(this).attr("idUser");

            var datos = new FormData();
            datos.append("item", "idUser");
            datos.append("value", idUser);
            datos.append("editarUsuario", "ok");

            $.ajax({
                type: "POST",
                url: "ajax/users.ajax.php",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (response) {
                    $("#editarIdentificacion").val(response.dni);
                    $("#editarNombre").val(response.name);
                    $("#editarEmail").val(response.email);
                    $("#editarCelular").val(response.phone);

                    if (response.id_companies != 0){
                        $('#editarPerfil').val(4);
                        $('#editCompany').val(response.id_companies);

                        $(".selectCompany").removeAttr("readonly");
                        $(".selectCompany").attr("required", "required");
                    }
                    else{
                        $('#editarPerfil').val("");
                        $('#editCompany').val("");

                        $(".selectCompany").attr("readonly", "readonly");
                        $(".selectCompany").removeAttr("required");
                    }

                }
            });
        });

        /* ===================================================
          RESTABLECER CONTRASEÑA
        ===================================================*/
        $(document).on("click", "#restablecerPswd", function () {
            datos = new FormData();
            datos.append('RestablecerPswd', "ok");
            datos.append('idUsuario', $("#editarIdentificacion").val());
            $.ajax({
                type: 'post',
                url: 'ajax/users.ajax.php',
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response == "ok") {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Password has been reseted successfully!',
                            showConfirmButton: true,
                            confirmButtonText: 'Cerrar',
                        });
                    }
                    else {
                        Swal.fire({
                            icon: 'error',
                            title: '¡There was a problem, please try again!',
                            showConfirmButton: true,
                            confirmButtonText: 'Cerrar',
                        });
                    }
                }
            });
        });

        /* ===================================================
          CUANDO SELECCIONE UN PERFIL DE CLIENTE
        ===================================================*/
        $(document).on("change", ".selectProfile", function () {
            var perfil = $(this).val();

            if (perfil == 4){
                $(".selectCompany").removeAttr("readonly");
                $(".selectCompany").attr("required", "required");
            }
            else{
                $(".selectCompany").attr("readonly", "readonly");
                $(".selectCompany").removeAttr("required");
                $(".selectCompany").val("");
            }
        });

        /* ===================================================
          ABRA LA MODAL DE AGREGAR UN NUEVO USUARIO
        ===================================================*/
        $('#agregarUsuarioModal').on('shown.bs.modal', function () {
            $(".selectProfile").val("");
            $(".selectCompany").attr("readonly", "readonly");
            $(".selectCompany").removeAttr("required");
            $(".selectCompany").val("");
        })
        
    });
}