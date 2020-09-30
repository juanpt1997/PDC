/* ===================================================
  COMPANIES
===================================================*/
if (window.location.href.includes("operations-companies")) {
    $(document).ready(function () {
        /* ===================================================
        DATATABLE
        ===================================================*/
        $('.tablaCompanies').DataTable({
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
        });

        /* ===================================================
          VISUALIZAR DATOS DE UNA COMPANY
        ===================================================*/
        $(document).on("click", ".companyInfo", function () {
            $(".editCompany").val("");
            $(".companyTitle").html("");
            
            var idcompany = $(this).attr("idcompany");
            
            var datos = new FormData();
            datos.append('CompanyInfo', "ok");
            datos.append('idcompany', idcompany);
            $.ajax({
                type: 'post',
                url: 'ajax/operations.ajax.php',
                data: datos,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response != ""){
                        // Titulo modal
                        $(".companyTitle").html(response.Name);
                        // Inputs de la modal
                        $("#country").val(response.Country);
                        $("#company").val(response.Name);
                        $("#ID").val(response.ID);
                        $("#addrLine1").val(response.Address_Line1);
                        $("#addrLine2").val(response.Address_Line2);
                        $("#city").val(response.City);
                        $("#state").val(response.State_Province_Region);
                        $("#zipcode").val(response.Zip_Code);
                        $("#contact").val(response.Contact_Name);
                        $("#phone").val(response.Phone_Number);
                        $("#email").val(response.Email);
                        $("#comments").val(response.Comments);
                    }
                }
            });
        });
    });
}