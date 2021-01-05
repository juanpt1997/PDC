/* ===================================================
  PAGE DOMAIN
===================================================*/

var urlActual = window.location.href;
var arrayUrlApp = urlActual.split('/');
var protocoloArray = urlActual.split(':');
var protocolo = protocoloArray[0];
var dominioApp = protocolo + "://" + window.document.domain;

console.log(dominioApp);


/* ===================================================
      FUNCION PARA VISUALIZAR UN PDF
    ===================================================*/
function VisualizarPDF(ruta) {

    $(".loadingPDF").removeClass("d-none");
    $("#canvasPDF").html(`
                            <canvas class="w-100"></canvas>
                            <div class="text-center ">
                                <button id="prevPagePDf" class="btn btn-sm btn-info mr-1">Prev</button>
                                <span class="font-weight-bold">Página: <span id="pagePDF_num"></span> / <span id="pagePDF_count"></span></span>
                                <button id="nextPagePDF" class="btn btn-sm btn-info ml-1">Next</button>
                            </div>
                            `);
    var url =
        "." + ruta;


    // Loaded via <script> tag, create shortcut to access PDF.js exports.
    var pdfjsLib = window["pdfjs-dist/build/pdf"];

    // The workerSrc property shall be specified.
    /* pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js'; */
    pdfjsLib.GlobalWorkerOptions.workerSrc =
        "views/plugins/pdf-js/pdf.worker.js";

    var pdfDoc = null,
        pageNum = 1,
        pageRendering = false,
        pageNumPending = null,
        scale = 3,
        canvas = document.getElementById("canvasPDF").getElementsByTagName('canvas')[0],
        ctx = canvas.getContext("2d");

    /**
     * Get page info from document, resize canvas accordingly, and render page.
     * @param num Page number.
     */
    function renderPage(num) {
        $(".loadingPDF").addClass("d-none");
        pageRendering = true;
        // Using promise to fetch the page
        pdfDoc.getPage(num).then(function (page) {
            var viewport = page.getViewport({ scale: scale });
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            // Render PDF page into canvas context
            var renderContext = {
                canvasContext: ctx,
                viewport: viewport
            };
            var renderTask = page.render(renderContext);

            // Wait for rendering to finish
            renderTask.promise.then(function () {
                pageRendering = false;
                if (pageNumPending !== null) {
                    // New page rendering is pending
                    renderPage(pageNumPending);
                    pageNumPending = null;
                }
            });
        });

        // Update page counters
        document.getElementById("pagePDF_num").textContent = num;
    }

    /**
     * If another page rendering in progress, waits until the rendering is
     * finised. Otherwise, executes rendering immediately.
     */
    function queueRenderPage(num) {
        if (pageRendering) {
            pageNumPending = num;
        } else {
            renderPage(num);
        }
    }

    /**
     * Displays previous page.
     */
    function onPrevPage() {
        if (pageNum <= 1) {
            return;
        }
        pageNum--;
        queueRenderPage(pageNum);
    }
    document.getElementById("prevPagePDf").addEventListener("click", onPrevPage);

    /**
     * Displays next page.
     */
    function onNextPage() {
        if (pageNum >= pdfDoc.numPages) {
            return;
        }
        pageNum++;
        queueRenderPage(pageNum);
    }
    document.getElementById("nextPagePDF").addEventListener("click", onNextPage);

    /**
     * Asynchronously downloads PDF.
     */
    pdfjsLib.getDocument(url).promise.then(function (pdfDoc_) {
        pdfDoc = pdfDoc_;
        document.getElementById("pagePDF_count").textContent = pdfDoc.numPages;

        // Initial/first page rendering
        renderPage(pageNum);
    }, function (reason) {
        console.log(reason);
        $(".loadingPDF").addClass("d-none");
        // PDF loading error
        Swal.fire({
            icon: 'warning',
            showConfirmButton: true,
            text: 'There was a problem trying to read the document',
            confirmButtonText: 'Cerrar',
            allowOutsideClick: false,
        }).then((result) => {
            if (result.value) {
                //Esconder otros modals
                $('.modal').modal('hide') // closes all active pop ups.
            }
        });
    });

}

/* ===================================================
            CLICK EN EL BOTON PARA VISUALIZAR/SUBIR ARCHIVOS COA O POD
        ===================================================*/
$(document).on("click", ".btn-docs", function () {
    var idorder = $(this).attr("idorder");
    var tipodoc = $(this).attr("tipodoc");

    //Titulo del tipo de documento
    if (tipodoc == "COA") {
        $(".docTitle").html("Certicate Of Analysis");
    }
    else {
        $(".docTitle").html("Proof of Delivery");
    }

    $("#canvasPDF").addClass("d-none");
    $("#containerImgDoc").addClass("d-none");
    $("#frmSubirDocumento").addClass("d-none");
    $("#btnGuardarArchivo").addClass("d-none");
    $("#btnDescargarArchivo").addClass("d-none");


    // Cambiar valor de hidden input
    $(".idorder").val(idorder);
    $(".tipodoc").val(tipodoc);

    // Despues de conocer el tipo de documento, consultamos si tiene correctamente subido el documento
    var datos = new FormData();
    datos.append('ExisteDoc', "ok");
    datos.append('idorder', idorder);
    datos.append('tipodoc', tipodoc);
    $.ajax({
        type: 'post',
        url: 'ajax/operations.ajax.php',
        data: datos,
        cache: false,
        dataType: "json",
        contentType: false,
        processData: false,
        success: function (response) {
            if (response != null) {
                // EL DOC ES UN PDF
                if (response.tipoArchivo == "PDF") {
                    $("#canvasPDF").removeClass("d-none");
                    VisualizarPDF(response.rutaDoc);
                }
                // EL DOC ES UNA IMAGEN
                else {
                    $("#containerImgDoc").removeClass("d-none");
                    $("#imgDoc").attr("src", "." + response.rutaDoc);
                }
                // Mostrar boton para descargar el archivo
                $("#btnDescargarArchivo").removeClass("d-none");
            }
            // NO HAY DOCUMENTO, POR TANTO SE MUESTRA EL FORMULARIO PARA SUBIR UNO
            else {
                $("#frmSubirDocumento").removeClass("d-none");
                $("#btnGuardarArchivo").removeClass("d-none");
            }
        }
    });
});

/* ===================================================
  CLICK EN DESCARGAR ARCHIVO
===================================================*/
$(document).on("click", "#btnDescargarArchivo", function () {
    var idorder = $(".idorder").first().val();
    var tipodoc = $(".tipodoc").first().val();
    
    var datos = new FormData();
    datos.append('DownloadFile', "ok");
    datos.append('idorder', idorder);
    datos.append('tipodoc', tipodoc);
    $.ajax({
        type: 'post',
        url: 'ajax/operations.ajax.php',
        data: datos,
        cache: false,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function (response) {
            var url = response.url;
            url = url.substring(1);
            window.open(url, '_blank');
        }
    });
    
});