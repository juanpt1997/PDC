<?php

# CONFIGURACION DE LA SESION
session_start();
# Si no existe una sesion se redireciona directamente al inicio
$fullurl = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$strpos = strpos($fullurl, "pdf/");
$url = substr($fullurl, 0, $strpos);
if (!isset($_SESSION["logged_in"])) {
    header("Location: $url");
}

# BOL REFERENCE
if (isset($_REQUEST['bol'])) {
    $id_bol = $_REQUEST['bol'];
} else {
    header("Location: $url");
}

#SE ESTABLECE EL HORARIO 
date_default_timezone_set('America/Bogota');

# SE REQUIERE EL AUTOLOAD
require '../vendor/autoload.php';

# REQUERIMOS EL CONTROLADOR Y EL MODELO PARA HACER USO DE LA INFORMACIÓN
require '../controllers/operations.controller.php';
require '../models/operations.model.php';


$resultado = BOLController::ctrBOLPosicion($id_bol);

/* ===================== 
  SI LA INFORMACIÓN VIENE FALSA SE REDIRECCIONA A LA PÁGINA DE BOL
========================= */

if ($resultado === false) {
    $redireccion = $url . "bol";
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
        $info = BOLController::ctrBOLPosicion($_REQUEST['bol']);

        // Logo
        $image_file =  '../views/dist/img/logo_intro.png';

        $this->Image($image_file, 15, 10, 80, 30,  'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // Set font
        $this->SetFont('helvetica', 'B', 10);

        # POSICION DEL EJE X & Y
        $this->SetXY(120, 15);
        $this->SetFont('helvetica', 'B', '12');

        # TABLA Cabecera BOL
        $tablaInfoCabecera = '
                <table cellspacing="0" cellpadding="2" border="1">
                    
                    <tr>
                        <th style="color:#000 ;font-weight:bold;">BOL #</th>
                        <th colspan="2">' . $info['PO_Reference'] . '</th>
                    </tr>
                    <tr>
                        <th style="color:#000 ;font-weight:bold;">PO. REF #</th>
                        <th colspan="2">' . $info['Customer_PO'] . '</th>
                    </tr>
                    <tr>
                        <th style="color:#000 ;font-weight:bold;">LOT #</th>
                        <th>' . $info['Lot'] . '</th>
                        <th></th>
                    </tr>
                    <tr>
                        <th style="color:#000 ;font-weight:bold;">REF C#</th>
                        <th>' . $info['RefC'] . '</th>
                        <th></th>
                    </tr>
                </table>
        ';

        # IMPRIMIMOS EL HTML DE LA TABLA
        $this->SetFont('helvetica', '', '10');
        $this->writeHTML($tablaInfoCabecera);
    }

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-10);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}


class PdfBOL
{

    /* ===================== 
      GENERACION DE ARCHIVOS PDF DE LA PETICION DE OFERTA 
    ========================= */
    static public function makePDF($info)
    {

        /* ===================== 
            UTILIZANDO LA VERSION DE TCPDF PARA GENERAR EL ARCHIVO 
        ========================= */
        # orientacion => p || unidade medida => cm
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);


        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('PDC');
        $pdf->SetTitle($info['PO_Reference']);
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        /* $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128)); */

        // set header and footer fonts
        // $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        // $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, 25, PDF_MARGIN_RIGHT);
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
        // $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));


        /* ===================================================
            ? CONTENIDO DEL PDF
        ===================================================*/
        /* ===================================================
            TO
        ===================================================*/
        // 'TO' DATA COMPANY
        $companyTO = CompaniesController::ctrCompanyInfo("id_companies", $info['To']);
        # POSICION DEL EJE X & Y
        $pdf->SetXY(15, 55);
        $pdf->SetFont('helvetica', 'B', '12');

        // concatenar address
        $addressTO = $companyTO['Address_Line1'];
        if ($companyTO['Address_Line2'] != "") {
            $addressTO .= ", " . $companyTO['Address_Line1'];
        }
        // Concatenar datos como ciudad, state y zip code
        $TOcityStateZip = $companyTO['City'] . ", " . $companyTO['State_Province_Region'] . ", " . $companyTO['Zip_Code'];

        // Data que va en el campo
        $TOdata = "<p>" . $companyTO['Name'];
        $TOdata .= "<br>" . $addressTO;
        $TOdata .= "<br>" . $TOcityStateZip . "</p>";

        # TABLA 'TO' DATA
        $tablaInfoTO = '
                <table cellspacing="0" cellpadding="2" border="1" style="width: 40%;">
                    
                    <tr>
                        <th style="color:#000 ;font-weight:bold;">TO</th>
                    </tr>
                    <tr>
                        <th>' . $TOdata . '</th>
                    </tr>
                </table>
        ';

        # IMPRIMIMOS EL HTML DE LA TABLA
        $pdf->SetFont('helvetica', '', '10');
        $pdf->writeHTML($tablaInfoTO);

        /* ===================================================
            FROM
        ===================================================*/
        // 'FROM' DATA COMPANY
        $companyFROM = CompaniesController::ctrCompanyInfo("id_companies", $info['From']);
        # POSICION DEL EJE X & Y
        $pdf->SetXY(120, 55);
        $pdf->SetFont('helvetica', 'B', '12');

        // concatenar address
        $addressFROM = $companyFROM['Address_Line1'];
        if ($companyFROM['Address_Line2'] != "") {
            $addressFROM .= ", " . $companyFROM['Address_Line1'];
        }
        // Concatenar datos como ciudad, state y zip code
        $FROMcityStateZip = $companyFROM['City'] . ", " . $companyFROM['State_Province_Region'] . ", " . $companyFROM['Zip_Code'];

        // Data que va en el campo
        $FROMdata = "<p>" . $companyFROM['Name'];
        $FROMdata .= "<br>" . $addressFROM;
        $FROMdata .= "<br>" . $FROMcityStateZip . "</p>";

        # TABLA 'FROM' DATA
        $tablaInfoFROM = '
                <table cellspacing="0" cellpadding="2" border="1" style="width: 100%;">
                    
                    <tr>
                        <th style="color:#000 ;font-weight:bold;">FROM</th>
                    </tr>
                    <tr>
                        <th>' . $FROMdata . '</th>
                    </tr>
                </table>
        ';

        # IMPRIMIMOS EL HTML DE LA TABLA
        $pdf->SetFont('helvetica', '', '10');
        $pdf->writeHTML($tablaInfoFROM);

        /* ===================================================
            SHIPPING DATE, APPOINTMENT
        ===================================================*/
        # POSICION DEL EJE X & Y
        $pdf->SetXY(15, 85);
        $pdf->SetFont('helvetica', 'B', '12');

        # TABLA SHIPPING DATE, APPOINTMENT
        $tablaShippingdate = '
                <table cellspacing="0" cellpadding="2" border="1" style="width: 40%;">
                    
                    <tr>
                        <th style="color:#000 ;font-weight:bold;">SHIPPING DATE</th>
                        <th>' . $info['ShippingdateFormat'] . '</th>
                    </tr>
                    <tr>
                        <th style="color:#000 ;font-weight:bold;">APPOINTMENT</th>
                        <th></th>
                    </tr>
                </table>
        ';

        # IMPRIMIMOS EL HTML DE LA TABLA
        $pdf->SetFont('helvetica', '', '10');
        $pdf->writeHTML($tablaShippingdate);

        /* ===================================================
            SEAL CARRIER
        ===================================================*/
        # POSICION DEL EJE X & Y
        $pdf->SetXY(120, 85);
        $pdf->SetFont('helvetica', 'B', '12');

        # TABLA SEAL CARRIER
        $tablaCarrier = '
                <table cellspacing="0" cellpadding="2" border="1" style="width: 100%;">
                    
                    <tr>
                        <th style="color:#000 ;font-weight:bold;">SEAL</th>
                        <th></th>
                    </tr>
                    <tr>
                        <th style="color:#000 ;font-weight:bold;">CARRIER</th>
                        <th>' . $info['Carrier'] . '</th>
                    </tr>
                </table>
        ';

        # IMPRIMIMOS EL HTML DE LA TABLA
        $pdf->SetFont('helvetica', '', '10');
        $pdf->writeHTML($tablaCarrier);

        /* ===================================================
           TABLA PALLETS
        ===================================================*/
        # POSICION DEL EJE X & Y
        $pdf->SetXY(15, 102);
        $pdf->SetFont('helvetica', 'B', '12');

        # TABLA SEAL PALLETS
        $tablaPallets = '
                <table cellspacing="0" cellpadding="2" border="1" >
                    
                    <tr align="center">
                        <th style="color:#000 ;font-weight:bold; width: 10%;">PALLETS</th>
                        <th style="color:#000 ;font-weight:bold; width: 15%">CS/BAGS</th>
                        <th style="color:#000 ;font-weight:bold; width: 60%">DESCRIPTION</th>
                        <th style="color:#000 ;font-weight:bold; width: 15%;">WEIGHT/LB</th>
                    </tr>
                    <tr align="center">
                        <td>' . $info['Pallets'] . '</td>
                        <td>' . $info['Bags'] . '</td>
                        <td>' . $info['Description'] . '</td>
                        <td>' . $info['Weight'] . '</td>
                    </tr>
                    <tr align="center">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr align="center">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr align="center">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr align="center">
                        <td>' . $info['Pallets'] . '</td>
                        <td>' . $info['Bags'] . '</td>
                        <td></td>
                        <td>' . $info['Weight'] . '</td>
                    </tr>
                </table>
        ';

        # IMPRIMIMOS EL HTML DE LA TABLA
        $pdf->SetFont('helvetica', '', '10');
        $pdf->writeHTML($tablaPallets);

        /* ===================================================
            CARRIER SIG, NAME, DATE
        ===================================================*/
        # POSICION DEL EJE X & Y 
        $pdf->SetXY(15, 140);
        $pdf->SetFont('helvetica', 'B', '12');

        # TABLA
        $tabla = '
                <table cellspacing="0" cellpadding="2" border="1" style="width: 30%;">
                    
                    <tr>
                        <th style="color:#000 ;font-weight:bold;">CARRIER SIG</th>
                        <th></th>
                    </tr>
                    <tr>
                        <th style="color:#000 ;font-weight:bold;">NAME</th>
                        <th></th>
                    </tr>
                    <tr>
                        <th style="color:#000 ;font-weight:bold;">DATE</th>
                        <th></th>
                    </tr>
                </table>
        ';

        # IMPRIMIMOS EL HTML DE LA TABLA
        $pdf->SetFont('helvetica', '', '10');
        $pdf->writeHTML($tabla);

        /* ===================================================
            CUSTOMER SIG, NAME, DATE
        ===================================================*/
        # POSICION DEL EJE X & Y 
        $pdf->SetXY(90, 140);
        $pdf->SetFont('helvetica', 'B', '12');

        # TABLA
        $tabla = '
                <table cellspacing="0" cellpadding="2" border="1" style="width: 100%;">
                    
                    <tr>
                        <th style="color:#000 ;font-weight:bold;">CUSTOMER SIG</th>
                        <th></th>
                    </tr>
                    <tr>
                        <th style="color:#000 ;font-weight:bold;">NAME</th>
                        <th></th>
                    </tr>
                    <tr>
                        <th style="color:#000 ;font-weight:bold;">DATE</th>
                        <th></th>
                    </tr>
                </table>
        ';

        # IMPRIMIMOS EL HTML DE LA TABLA
        $pdf->SetFont('helvetica', '', '10');
        $pdf->writeHTML($tabla);

        /* ===================================================
           NOTES
        ===================================================*/
        $AllBorders = array(
            'T' => array('width' => 0.4, 'color' => array(0, 0, 0), 'dash' => 0, 'cap' => 'butt'),
            'R' => array('width' => 0.4, 'color' => array(0, 0, 0), 'dash' => 0, 'cap' => 'butt'),
            'B' => array('width' => 0.4, 'color' => array(0, 0, 0), 'dash' => 0, 'cap' => 'butt'),
            'L' => array('width' => 0.4, 'color' => array(0, 0, 0), 'dash' => 0, 'cap' => 'butt'),
        );
        $pdf->SetX(15);
        $pdf->SetFont('helvetica', 'B', '12');
        $pdf->Ln();
        $pdf->Cell(180, 5, 'MANDATORY', 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('helvetica', '', '10');
        $notas = "NOTES:\n\n" . "Effective today the carrier must send a picture of the bill of landing signed by the recipient at the moment of the delivery.\n" . "Please send the picture to your broker and a copy to Alex Tobon phone number # (305) 528 4903\n\n" . "Please attach picture of any damaged product in order to file any claims, send pictures to (305) 528 4903.";
        $pdf->MultiCell(180, 15, $notas, $AllBorders, 'L', 0, 1, '', '', true);
        $x = $pdf->GetX();
        $y = $pdf->GetY();

        # Flechas
        $image_flecha1 =  '../views/dist/img/flecha1.png';
        $pdf->Image($image_flecha1, 15, 160, 10, 10,  'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $image_flecha2 =  '../views/dist/img/flecha2.png';
        $pdf->Image($image_flecha2, 180, 160, 10, 10,  'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        /* ===================================================
           FOR INTERNAL USE ONLY
        ===================================================*/
        $pdf->SetXY(15, $y + 5);
        $pdf->Cell(180, 5, 'FOR INTERNAL USE ONLY', $AllBorders, 0, 'L');

        // ONLY BOTTOM BORDER
        $complex_cell_border = array(
            'T' => array('width' => 0, 'color' => array(255, 255, 255), 'dash' => 0, 'cap' => 'butt'),
            'R' => array('width' => 0, 'color' => array(255, 255, 255), 'dash' => 0, 'cap' => 'butt'),
            'B' => array('width' => 0.4, 'color' => array(0, 0, 0), 'dash' => 0, 'cap' => 'butt'),
            'L' => array('width' => 0, 'color' => array(255, 255, 255), 'dash' => 0, 'cap' => 'butt'),
        );

        $pdf->Ln();
        $pdf->Ln();
        //WAREHOUSE
        $pdf->SetX(15);
        $pdf->SetFont('helvetica', 'B', '10');
        $pdf->Cell(30, 5, 'WAREHOUSE', 0, 0, 'R');
        $pdf->SetFont('helvetica', '', '10');
        $pdf->Cell(50, 5, "", $complex_cell_border);
        //DATE
        $pdf->SetX(100);
        $pdf->SetFont('helvetica', 'B', '10');
        $pdf->Cell(30, 5, 'DATE', 0, 0, 'R');
        $pdf->SetFont('helvetica', '', '10');
        $pdf->Cell(50, 5, "", $complex_cell_border);
        
        $pdf->Ln();
        $pdf->Ln();

        //LOADING TIME
        $pdf->SetX(15);
        $pdf->SetFont('helvetica', 'B', '10');
        $pdf->Cell(30, 5, 'LOADING TIME', 0, 0, 'R');
        $pdf->SetFont('helvetica', '', '10');
        $pdf->Cell(50, 5, "", $complex_cell_border);
        //WH SIGNATURE
        $pdf->SetX(100);
        $pdf->SetFont('helvetica', 'B', '10');
        $pdf->Cell(30, 5, 'WH SIGNATURE', 0, 0, 'R');
        $pdf->SetFont('helvetica', '', '10');
        $pdf->Cell(50, 5, "", $complex_cell_border);
        $pdf->Ln();

        /* ===================================================
           SELLO
        ===================================================*/
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $image_sello =  '../views/dist/img/STAMP.jpg';
        $pdf->Image($image_sello, 140, $y + 5, 65, 25,  'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);


        // Set some content to print
        /* $html = '<h1>Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;</a>!</h1>
            <i>This is the first example of TCPDF library.</i>
            <p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
            <p>Please check the source code documentation and other examples for further information.</p>
            <p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>
            '; */

        // Print text using writeHTMLCell()
        //$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        // ---------------------------------------------------------

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output($info['PO_Reference'], 'I');

        //============================================================+
        // END OF FILE
        //============================================================+
    }
}

# SE INSTANCIA LA CLASE PARA LA GENERACION DEL ARCHIVO PDF
PdfBOL::makePDF($resultado);
