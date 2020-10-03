/* ===================================================
  * COMPANIES
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
                        $("#idcompany").val(response.id_companies);
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

/* ===================================================
  * PRODUCTS
===================================================*/
if (window.location.href.includes("operations-products")) {
    $(document).ready(function () {
        /* ===================================================
        DATATABLE
        ===================================================*/
        $('.tablaProducts').DataTable({
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
        });

        /* ===================================================
          VISUALIZAR DATOS DE UN PRODUCT
        ===================================================*/
        $(document).on("click", ".productInfo", function () {
            $(".editProduct").val("");
            $(".productTitle").html("");
            $("#Image").attr("src", ``);
            
            var idproduct = $(this).attr("idproduct");
            
            var datos = new FormData();
            datos.append('ProductInfo', "ok");
            datos.append('idproduct', idproduct);
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
                        $(".productTitle").html(response.Name);
                        // Inputs de la modal
                        $("#idproduct").val(response.id_products);
                        $("#Name").val(response.Name);
                        $("#Reference").val(response.Reference);
                        $("#Weight").val(response.Weight);
                        $("#Unit").val(response.Unit);
                        $("#Price").val(response.Price);
                        $("#Description").val(response.Description);
                        $("#Image").attr("src", `./${response.Image}`);

                    }
                }
            });
        });
        
    });
}