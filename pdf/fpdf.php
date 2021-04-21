<?php
# PETICION DE OFERTA NACIONAL

# CONFIGURACION DE LA SESION
include '../config.php';
$url = $_SERVER['REQUEST_SCHEME'] . '://' .  $_SERVER['HTTP_HOST'] . "/cac/crm";
# Si no existe una sesion se redireciona directamente al inicio
if (!isset($_SESSION["crm_cedula"])) {
    header("Location: $url");
}

# SE VALIDA DE QUE EL ID SEA DE TIPO INT 
if (isset($_REQUEST['idOferta']) && preg_match('/^[0-9]+$/', $_REQUEST['idOferta'])) {
    $idOferta = $_REQUEST['idOferta'];
} else {
    header("Location: $url");
}

#SE ESTABLECE EL HORARIO 
date_default_timezone_set('America/Bogota');

# SE REQUIERE EL AUTOLOAD
require $_SERVER['DOCUMENT_ROOT'] . '/cac/crm/vendor/autoload.php';

# REQUERIMOS EL CONTROLADOR Y EL MODELO PARA HACER USO DE LA INFORMACIÓN
require '../controllers/peticion-oferta.controlador.php';
require '../models/peticion-oferta.modelo.php';


$resultado = ControladorPeticionOferta::ctrInfoPO($idOferta);
// var_dump($resultado);die();
$informacion = $resultado['informacion'];
$cotizacion = $resultado['cotizacion'];

/* ===================== 
  SI LA INFORMACIÓN VIENE FALSA SE REDIRECCIONA A LA PETICION DE OFEERTAS 
========================= */

if ($informacion === false) {
    $redireccion = $url . "/c-leads";
    header("Location: $redireccion");
}


/* ===================== 
  CONFIGURACIÓN DEL HEADER Y FOOTER EN EL ARCHIVO PDF 
========================= */
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF
{

    //Page header
    public function Header()
    {

        # INFORMACION DE LA DB
        $infoPO = ControladorPeticionOferta::ctrInfoPO($_REQUEST['idOferta'])['informacion'];
        $ofertaNo = $infoPO['idOferta'];

        if ($infoPO['sociedad'] == 'COYTEX') {
            // Logo
            $image_file =  '../views/img/logos/logo_coytex.png';
            $this->Image($image_file, 10, 10, 40, 30,  'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            // Set font
            $this->SetFont('helvetica', 'B', 10);
            // Title

            # POSICION DEL EJE X & Y  INFORMACIÓN DE LA SOCIEDAD
            $this->SetXY(50, 13);
            $this->MultiCell(100, 0.5, "CO & TEX S.A.S \nNIT 800122420-6 \nCALLE 11 No. 17 # 27 LOS CAMBULOS \nTEL : (576) 3301036 \nDOSQUEBRADAS/RLDA, COLOMBIA", 0, 'L');
            // $this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        } else {
            // Logo
            $image_file =  '../views/img/logos/logo_onzas.png';
            $this->Image($image_file, 15, 12.5, 25, 28,  'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            // Set font
            $this->SetFont('helvetica', 'B', 10);
            // Title

            # POSICION DEL EJE X & Y  INFORMACIÓN DE LA SOCIEDAD
            $this->SetXY(42.5, 13);
            $this->MultiCell(120, 1, "ONZAS S.A.S NIT 900676198-5 \nKM 9 VÍA CERRITOS LA VIRGINIA \nCORREGIMIENTO CAIMALITO BOD.1 ZONA FRANCA \nINTERNACIONAL DE PEREIRA \nPEREIRA/RLDA,COLOMBIA TEL : (576) 3301036, \nFACTURAS.CLIENTES@ONZAS.COM.CO", 0, 'L');
        }




        # POSICION DEL EJE X & Y INFORMACION DEL NUMERO DE LA PETICION DE OFERTA
        $this->SetXY(150, 15);
        $this->SetFont('helvetica', 'B', '12');
        $this->MultiCell(40, 50, "OFERTA No. \n$ofertaNo", 0, 'C');
    }

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-10);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}


class PdfOferta
{
    /* ===================== 
    BUSCAR EL MES Y RETORNARLO EN TEXTO 
    ========================= */
    static public function mesNombre($mes)
    {

        $meses = [
            1   =>  "Enero",
            2   =>  "Febrero",
            3   =>  "Marzo",
            4   =>  "Abril",
            5   =>  "Mayo",
            6   =>  "Junio",
            7   =>  "Julio",
            8   => "Agosto",
            9   => "Septiembre",
            10  => "Octubre",
            11  => "Noviembre",
            12  => "Diciembre"
        ];

        foreach ($meses as $key => $value) {
            if ($key == $mes) {
                return $value;
            }
        }
    }

    /* ===================== 
      GENERACION DE ARCHIVOS PDF DE LA PETICION DE OFERTA 
    ========================= */
    static public function pdfPO($informacion, $cotizacion, $archivo = '')
    {

        /* ===================== 
            UTILIZANDO LA VERSION DE TCPDF PARA GENERAR EL ARCHIVO 
        ========================= */
        # orientacion => p || unidade medida => cm
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);


        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($informacion['sociedad']);
        $pdf->SetTitle('Petición de Oferta ' . $informacion['idOferta']);
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, COYTEX, test, guide');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        // $pdf->setFooterData(array(0,64,0), array(0,64,128));

        // set header and footer fonts
        // $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        // $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 45, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('dejavusans', '', 14, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // set text shadow effect
        // $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

        # INFORMACION DE LA CIUDAD Y LA FECHA
        $pdf->SetFont('helvetica', '', '12');
        $municipio = $informacion['sociedad'] == 'COYTEX' ? 'Dosquebradas, ' : 'Pereira, ';
        $pdf->Cell(20, 1, $municipio . date('d') . ' de ' . self::mesNombre(date('m')) . ' del ' . date('Y'), 0, 1, 'L');

        $pdf->Ln();

        # INFORMACION DEL CLIENTE
        $pdf->Cell(20, 0.5, $informacion['tratoCont'], 0, 1, 'L');
        $pdf->SetFont('helvetica', 'B', '12');
        $pdf->Cell(20, 0.5, $informacion['nombreCont'], 0, 1, 'L');
        $pdf->SetFont('helvetica', '', '12');
        $pdf->Cell(20, 0.5, $informacion['razonSocial'], 0, 1, 'L');

        $pdf->Ln();

        # ASUNTO
        $pdf->SetFont('helvetica', 'B', '12');
        $pdf->Cell(20, 0.5, 'ASUNTO: ' . $informacion['asunto'], 0, 1, 'L');

        $pdf->ln();

        # SALUDO
        $pdf->SetFont('helvetica', '', '12');
        $pdf->MultiCell(170, 0.5, "Reciba un cordial saludo, de acuerdo a su solicitud estamos enviando la \ncotizacion correspondiente: ", 0, 'L');

        $pdf->Ln();

        # TABLA PAR LOS DATOS
        $tablaDatos = '
            <table cellspacing="0" cellpadding="2" border="1">
                <tr style="color:#000 ;font-weight:bold; text-align: center;">
                    <th>IMAGEN</th>
                    <th>MODELO</th>
                    <th>DESCRIPCIÓN</th>
                    <th>COMPOSICIÓN</th>
                    <th>CANTIDAD</th>
                    <th>PRECIO UNITARIO</th>
                    <th>SUBTOTAL</th>
                </tr> 
        ';

        $pdf->SetFont('helvetica', '', '9');
        # RECORRO LAS OFERTAS PARA IMPRIMIRLAS EN EL DOCUMENTO PDF
        $moneda = '';
        $total = 0;
        $contador = 0;
        foreach ($cotizacion as $value) {
            // $imagen= $_SERVER['DOCUMENT_ROOT'] . "/" . $value['rutaImg'];
            $imagen = $_SERVER['DOCUMENT_ROOT'] . "/" . $value['rutaImg'];
            $modelo = $value['modelo'];
            $descripcion = $value['descripcion'];
            $composicion = $value['composicion'];
            $cantidad = $value['cantidad'];
            $precio = $value['precioItem'];
            $subtotal = $value['subtotal'];
            $moneda = $value['moneda'];
            $precioItemNormal = $value['precioItemNormal'] * $value['cantidad'];
            $total += $precioItemNormal;


            $tablaDatos .= '
                <tr style="text-align: center;">
                    <td>
                        <img src="' . $imagen . '" width="80" height="70">
                    </td>       
                    <td>' . $modelo . '</td>       
                    <td>' . $descripcion . '</td>       
                    <td>' . $composicion . '</td>       
                    <td>' . $cantidad . '</td>       
                    <td>' . $precio . '</td>       
                    <td>' . $subtotal . '</td>       
                </tr>
            ';
            // if ($contador >= 3) {
            //     $tablaDatos .= '<br><br><br>';
            // }
            $contador += 1;
        }




        $tablaDatos .= "</table>";


        # IMPRIMIMOS EL HTML DE LA TABLA
        $pdf->writeHTML($tablaDatos);

        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(20, 0.5, 'LOS PRECIOS NO INCLUYEN I.V.A.', 0, 1, 'L');
        $pdf->Cell(20, 0.5, 'MONEDA: ' . $moneda, 0, 1, 'L');
        $totalCotizacion = number_format($total, 0);
        $pdf->Cell(20, 0.5, 'TOTAL: ' . str_replace(',', '.', $totalCotizacion), 0, 1, 'L');

        // $pdf->Ln();
        if ($pdf->GetY() > 234) {
            $pdf->AddPage();
        }

        
        // $pdf->Cell(20,1,$pdf->GetY(),0,1);

        $pdf->SetFont('helvetica', '', 12);

        // $pdf->MultiCell(180, 1, 'OBSERVACIÓN: ' . $informacion['observacion'], 0, 'L');
        $obaservacion = '<p style="text-align: justify;" ><b>OBSERVACIÓN: </b> ' . $informacion['observacion'] . '<p>';
        $pdf->writeHTML($obaservacion);


        // $pdf->SetY(235);
        $pdf->SetFont('helvetica', 'B', 12);

        $pdf->Cell(100, 0.5, 'Atentamente,', 0, 1);

        $pdf->Ln(20);
        // $pdf->SetY(261);

        // $pdf->Cell(100, 0.3, 'DIEGO PINEDA JIMENEZ', 0, 1);
        // $presidente = $informacion['sociedad'] == 'COYTEX' ? 'PRESIDENTE CO & TEX S.A.S' : 'PRESIDENTE ONZAS S.A.S';
        // $pdf->Cell(100, 0.3, $presidente, 0, 1);
        $pdf->Cell(100, 0.3, 'HECTOR FABIO GUTIERREZ', 0, 1);
        $pdf->Cell(100, 0.3, 'DIRECTOR COMERCIAL ', 0, 1);



        # EJEMPLO HTML DE LA LIBRERIA
        // Set some content to print
        /* $html = <<<EOD
            <br>
            <h1>Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;</a>!</h1>
            <i>This is the first example of TCPDF library.</i>
            <p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
            <p>Please check the source code documentation and other examples for further information.</p>
            <p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>
        EOD; */

        // Print text using writeHTMLCell()
        // $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        // ---------------------------------------------------------

        $nombrePdf = $informacion['idOferta'] . '_' . date('Y-m-d') . '_' . date('His') . '.pdf';


        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output($nombrePdf, 'I');
    }
}

# SE INSTANCIA LA CLASE PARA LA GENERACION DEL ARCHIVO PDF
PdfOferta::pdfPO($informacion, $cotizacion);
