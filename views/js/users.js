if (window.location.href.includes("users")) {
    $(document).ready(function () {
        /* ===================================================
          DATATABLE
        ===================================================*/
        $('.tablaUsuarios').DataTable({
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
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

                    if (response.id_companies != 0) {
                        $('#editarPerfil').val(4);
                        $('#editCompany').val(response.id_companies);

                        $(".selectCompany").removeAttr("readonly");
                        $(".selectCompany").attr("required", "required");
                    }
                    else {
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
                            confirmButtonText: 'Close',
                        });
                    }
                    else {
                        Swal.fire({
                            icon: 'error',
                            title: '¡There was a problem, please try again!',
                            showConfirmButton: true,
                            confirmButtonText: 'Close',
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

            if (perfil == 4) {
                $(".selectCompany").removeAttr("readonly");
                $(".selectCompany").attr("required", "required");
            }
            else {
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


        /* ===================== 
        ACTIVAR USUARIO 
    ========================= */
        $(document).on("click", ".btnActivar", function () {
            var iduser = $(this).attr("iduser");
            var estadoUsuario = $(this).attr("estadoUsuario");

            console.log("iduser => " + iduser);
            console.log("estadoUsuario => " + estadoUsuario);

            var datos = new FormData();
            datos.append("iduser", iduser);
            datos.append("activarUsuario", estadoUsuario);

            $.ajax({
                url: "ajax/users.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response == "ok") {
                        Swal.fire({
                            icon: 'success',
                            showConfirmButton: true,
                            title: "User status updated",
                            confirmButtonText: "Close!",
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.value) {
                                window.location = 'users';
                            }

                        });
                    }
                }
            });
        });
    });
}