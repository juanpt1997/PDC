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

# SE VALIDA DE QUE EL ID SEA DE TIPO INT 
if (isset($_REQUEST['order']) && preg_match('/^[0-9]+$/', $_REQUEST['order'])) {
    $idOrder = $_REQUEST['order'];
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


$resultado = OrdersController::ctrOrderInfo($idOrder);

/* ===================== 
  SI LA INFORMACIÓN VIENE FALSA SE REDIRECCIONA A LAS ORDERS
========================= */

if ($resultado === false) {
    $redireccion = $url . "orders";
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
        $this->SetFont('helvetica', 'B', '14');
        $this->Ln();
        $this->Cell(0, 0, "", 0, 0, 'C', 0, '', 0);
        $this->Ln();
        $this->Cell(0, 0, "PURCHASE ORDER", 0, 0, 'C', 0, '', 0);
        $this->Ln();

        $this->SetFont('helvetica', 'B', '9');
        $this->Cell(0, 0, "", 0, 0, 'C', 0, '', 0);
        $this->Ln();
        $this->Ln();
       
        /* $this->SetFont('helvetica', 'B', '9');
        $this->Cell(0, 0, "PHONE: (561) 998-0904 FACSIMILE: (561) 998-1878", 0, 0, 'C', 0, '', 0);
        $this->Ln(); */

        $this->writeHTML("<hr>");
        $this->Ln();
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


class PdfOrder
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
        $pdf->SetTitle('Order # ' . $info['id_orders']);
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

        # POSICION DEL EJE X & Y de la fecha
        $pdf->SetXY(150, 30);
        $pdf->SetFont('helvetica', '', '10');
        $pdf->MultiCell(40, 10, "DATE:   " . date('m-d-Y'), 0, 'C');

        # Cliente
        $pdf->SetFont('helvetica', 'B', '12');
        $pdf->Cell(0, 0, '"' . $info['Company'] . '"', 0, 0, 'C', 0, '', 0);
        $pdf->Ln();
        $pdf->Ln();

        # TABLA Info del producto
        $tablaInfoProducto = '
                <table cellspacing="0" cellpadding="2" border="1">
                <tbody>
                    <tr>
                        <th style="color:#000 ;font-weight:bold;">ELABORATED BY</th>
                        <td>' . $info['audituser'] . '</td>
                    </tr> 
                    <tr>
                        <th style="color:#000 ;font-weight:bold;">PRODUCT</th>
                        <td>' . $info['Product'] . '</td>
                    </tr> 
                    <tr>
                        <th style="color:#000 ;font-weight:bold;">WEIGHT OF EACH BAG</th>
                        <td>' . $info['Weight_Each_Bag'] . '</td>
                    </tr> 
                    <tr>
                        <th style="color:#000 ;font-weight:bold;">TOTAL BAGS</th>
                        <td>' . $info['Total_Bags'] . '</td>
                    </tr> 
                    <tr>
                        <th style="color:#000 ;font-weight:bold;">TOTAL SKIDS</th>
                        <td>' . $info['Total_Skids'] . '</td>
                    </tr> 
                    <tr>
                        <th style="color:#000 ;font-weight:bold;">CUSTOMER PO#</th>
                        <td>' . $info['Customer_PO'] . '</td>
                    </tr>
                    <tr>
                        <th style="color:#000 ;font-weight:bold;">ILF #</th>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
        ';
        # IMPRIMIMOS EL HTML DE LA TABLA
        $pdf->SetFont('helvetica', '', '10');
        $pdf->writeHTML($tablaInfoProducto);
        $pdf->Ln();

        # ARRANGE PICKUP AND DROM RELEASE
        // set color for background
        $pdf->SetFillColor(255, 255, 255);
        // ONLY BOTTOM BORDER
        $complex_cell_border = array(
            'T' => array('width' => 0, 'color' => array(255, 255, 255), 'dash' => 0, 'cap' => 'butt'),
            'R' => array('width' => 0, 'color' => array(255, 255, 255), 'dash' => 0, 'cap' => 'butt'),
            'B' => array('width' => 0.4, 'color' => array(0, 0, 0), 'dash' => 0, 'cap' => 'butt'),
            'L' => array('width' => 0, 'color' => array(255, 255, 255), 'dash' => 0, 'cap' => 'butt'),
        );
        $pdf->SetFont('helvetica', '', '10');
        $pdf->MultiCell(65, 5, "PLEASE ARRANGE THE PICKUP OF: ", 0, 'L', 0, 0, '', '', true);
        $pdf->SetFont('helvetica', 'B', '10');
        $pdf->MultiCell(40, 5, $info['Arrange_Pickup'], $complex_cell_border, 'L', 0, 0, '', '', true);
        $pdf->SetFont('helvetica', '', '10');
        $pdf->MultiCell(35, 5, "FROM RELEASE #", 0, 'L', 0, 0, '', '', true);
        $pdf->SetFont('helvetica', 'B', '10');
        $pdf->MultiCell(35, 5, $info['From_Release'], $complex_cell_border, 'L', 0, 0, '', '', true);
        $pdf->Ln();
        $pdf->Ln();

        # PICKUPDATE AND PO REFERENCE NUMBER
        /* $pdf->SetFont('helvetica', '', '10');
        $pdf->MultiCell(30, 5, "PICK UP DATE: ", 0, 'L', 0, 0, '', '', true);
        $pdf->SetFont('helvetica', 'B', '10');
        $pdf->MultiCell(35, 5, $info['Pickup_Date'], $complex_cell_border, 'L', 0, 0, '', '', true); */
        $pdf->SetFont('helvetica', '', '10');
        $pdf->MultiCell(50, 5, "P.O. REFERENCE NUMBER: ", 0, 'L', 0, 0, '', '', true);
        $pdf->SetFont('helvetica', 'B', '10');
        $pdf->MultiCell(30, 5, $info['PO_Reference'], $complex_cell_border, 'L', 0, 0, '', '', true);
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();

        # FROM: NAME, ADDRESS, ADDRESS, PHONE, CONTACT
        // 
        $pdf->SetX(60);
        $pdf->SetFont('helvetica', '', '10');
        $pdf->Cell(30, 5, 'FROM:');
        $pdf->Ln();
        //Name
        $pdf->SetX(60);
        $pdf->SetFont('helvetica', 'B', '10');
        $pdf->Cell(30, 5, 'NAME:');
        $pdf->SetFont('helvetica', '', '10');
        $pdf->Cell(105, 5, $info['Delivery_From_Name'], $complex_cell_border);
        $pdf->Ln();

        //Address
        $pdf->SetX(60);
        $pdf->SetFont('helvetica', 'B', '10');
        $pdf->Cell(30, 5, 'ADDRESS:');
        $pdf->SetFont('helvetica', '', '10');
        $pdf->Cell(105, 5, $info['Delivery_Address'], $complex_cell_border);
        $pdf->Ln();
        
        //Address
        $pdf->SetX(60);
        $pdf->SetFont('helvetica', 'B', '10');
        $pdf->Cell(30, 5, 'ADDRESS:');
        $pdf->SetFont('helvetica', '', '10');
        $pdf->Cell(105, 5, $info['Delivery_Address2'], $complex_cell_border);
        $pdf->Ln();

        //Phone
        $pdf->SetX(60);
        $pdf->SetFont('helvetica', 'B', '10');
        $pdf->Cell(30, 5, 'PHONE:');
        $pdf->SetFont('helvetica', '', '10');
        $pdf->Cell(105, 5, $info['Delivery_Phone'], $complex_cell_border);
        $pdf->Ln();

        //City
        $pdf->SetX(60);
        $pdf->SetFont('helvetica', 'B', '10');
        $pdf->Cell(30, 5, 'CITY:');
        $pdf->SetFont('helvetica', '', '10');
        $pdf->Cell(105, 5, $info['Delivery_City'], $complex_cell_border);
        $pdf->Ln();

        //Zip Code
        $pdf->SetX(60);
        $pdf->SetFont('helvetica', 'B', '10');
        $pdf->Cell(30, 5, 'ZIP CODE:');
        $pdf->SetFont('helvetica', '', '10');
        $pdf->Cell(105, 5, $info['Delivery_ZipCode'], $complex_cell_border);
        $pdf->Ln();

        //Contact
        $pdf->SetX(60);
        $pdf->SetFont('helvetica', 'B', '10');
        $pdf->Cell(30, 5, 'CONTACT:');
        $pdf->SetFont('helvetica', '', '10');
        $pdf->Cell(105, 5, $info['Delivery_Contact'], $complex_cell_border);
        $pdf->Ln();
        $pdf->Ln();

        # DELIVERY DATE
        $pdf->SetX(35);
        $pdf->SetFont('helvetica', '', '10');
        $pdf->Cell(35, 5, 'DELIVERY DATE:');
        $pdf->SetFont('helvetica', 'B', '10');
        $pdf->Cell(30, 5, $info['Delivery_DateF'], $complex_cell_border);
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();

        # DELIVERY DESTINATION
        //
        $pdf->SetX(40);
        $pdf->SetFont('helvetica', '', '10');
        $pdf->Cell(30, 5, 'DELIVERY DESTINATION:');
        $pdf->Ln();
        
        //NAME
        $pdf->SetX(60);
        $pdf->SetFont('helvetica', 'B', '10');
        $pdf->Cell(30, 5, 'NAME:');
        $pdf->SetFont('helvetica', '', '10');
        $pdf->Cell(105, 5, $info['Delivery_Destination_Name'], $complex_cell_border);
        $pdf->Ln();

        # MUST CALL TO SCHEDULE A DROP OFF
        $AllBorders = array(
            'T' => array('width' => 0.4, 'color' => array(0, 0, 0), 'dash' => 0, 'cap' => 'butt'),
            'R' => array('width' => 0.4, 'color' => array(0, 0, 0), 'dash' => 0, 'cap' => 'butt'),
            'B' => array('width' => 0.4, 'color' => array(0, 0, 0), 'dash' => 0, 'cap' => 'butt'),
            'L' => array('width' => 0.4, 'color' => array(0, 0, 0), 'dash' => 0, 'cap' => 'butt'),
        );
        $pdf->SetFont('helvetica', 'B', '10');
        $pdf->MultiCell(35, 15, 'MUST CALL TO SCHEDULE A DROP OFF', $AllBorders, 'C', 0, 0, '', '', true);

        //ADDRESS
        $pdf->SetX(60);
        $pdf->SetFont('helvetica', 'B', '10');
        $pdf->Cell(30, 5, 'ADDRESS:');
        $pdf->SetFont('helvetica', '', '10');
        $pdf->Cell(105, 5, $info['Delivery_Destination_Address'], $complex_cell_border);
        $pdf->Ln();

        //ADDRESS
        $pdf->SetX(60);
        $pdf->SetFont('helvetica', 'B', '10');
        $pdf->Cell(30, 5, 'ADDRESS:');
        $pdf->SetFont('helvetica', '', '10');
        $pdf->Cell(105, 5, $info['Delivery_Destination_Address2'], $complex_cell_border);
        $pdf->Ln();

        //PHONE
        $pdf->SetX(60);
        $pdf->SetFont('helvetica', 'B', '10');
        $pdf->Cell(30, 5, 'PHONE:');
        $pdf->SetFont('helvetica', '', '10');
        $pdf->Cell(105, 5, $info['Delivery_Destination_Phone'], $complex_cell_border);
        $pdf->Ln();

        //CITY
        $pdf->SetX(60);
        $pdf->SetFont('helvetica', 'B', '10');
        $pdf->Cell(30, 5, 'CITY:');
        $pdf->SetFont('helvetica', '', '10');
        $pdf->Cell(105, 5, $info['Delivery_Destination_City'], $complex_cell_border);
        $pdf->Ln();

        //ZIP CODE
        $pdf->SetX(60);
        $pdf->SetFont('helvetica', 'B', '10');
        $pdf->Cell(30, 5, 'ZIP CODE:');
        $pdf->SetFont('helvetica', '', '10');
        $pdf->Cell(105, 5, $info['Delivery_Destination_ZipCode'], $complex_cell_border);
        $pdf->Ln();

        //CONTACT
        $pdf->SetX(60);
        $pdf->SetFont('helvetica', 'B', '10');
        $pdf->Cell(30, 5, 'CONTACT:');
        $pdf->SetFont('helvetica', '', '10');
        $pdf->Cell(105, 5, $info['Delivery_Destination_Contact'], $complex_cell_border);
        $pdf->Ln();
        $pdf->Ln();

        # CONFIRMED TRUCKING CHARGE
        $pdf->SetX(30);
        $pdf->SetFont('helvetica', '', '10');
        $pdf->Cell(60, 5, 'CONFIRMED TRUCKING CHARGE:');
        $pdf->SetFont('helvetica', 'B', '10');
        $pdf->Cell(100, 5, $info['Delivery_Destination_Confirmed_Trucking_Charge'], $complex_cell_border);
        $pdf->Ln();
        $pdf->Ln();

        # COMMENTS
        $pdf->SetX(30);
        $pdf->SetFont('helvetica', 'B', '10');
        $pdf->Cell(25, 5, 'COMMENTS:', 0);
        $pdf->SetX(55);
        $pdf->SetFont('helvetica', '', '10');
        $pdf->MultiCell(140, 5, $info['Delivery_Destination_Comments'], $AllBorders, 'L', 0, 0, '', '', true);
        //$pdf->MultiCell(140, 5, 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Deserunt sit corporis, temporibus nemo vitae laboriosam tempora! Quidem, odio ducimus tenetur illum ut sapiente numquam consequatur iusto, a suscipit inventore cupiditate itaque corporis commodi debitis distinctio pariatur repellendus animi sint reprehenderit. Provident tempore voluptate quia mollitia ex nostrum ab, itaque doloribus.', $AllBorders, 'L', 0, 0, '', '', true);
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        //$pdf->Cell(55, 5, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam quidem, quisquam dolor recusandae dolores animi tempore esse temporibus cumque corporis in quam at itaque doloribus. Earum esse et rem soluta ex minus numquam quod itaque cupiditate nihil consectetur hic suscipit sit sint dicta, recusandae fugiat nesciunt laudantium culpa facere libero aspernatur? Unde, pariatur. Ratione rerum, necessitatibus quae vel maxime modi quis sapiente nisi voluptas perspiciatis facere similique doloremque, dolores non minus amet beatae eum temporibus. Odit quos maxime quae. Fugit, vitae doloremque. Distinctio tempora officiis perspiciatis doloremque, corrupti, eligendi soluta officia ipsum magnam laudantium aut harum ullam nisi? Perferendis assumenda sed officiis cum a. Repudiandae tempore sunt quod culpa optio est odit! Earum doloremque optio, architecto facilis delectus qui reiciendis itaque reprehenderit. Repellendus cum quam eius doloribus reprehenderit quibusdam officia dolor fugit nihil! Nulla eligendi amet aut magnam, eos expedita et adipisci quam vitae beatae aliquid consequuntur commodi impedit quos repudiandae similique incidunt dicta ipsum nihil repellat architecto molestias vel nesciunt recusandae! Delectus quam molestiae facilis neque voluptatem magnam quisquam cum est. Quo aspernatur dolor praesentium mollitia sapiente, obcaecati harum, esse tempore, nihil delectus quibusdam provident fugit! Natus error ipsam iusto suscipit voluptatibus, aut quaerat explicabo totam, porro odio mollitia!', $complex_cell_border);
        //$comments = '<p style="text-align: justify" ><u>COMMENTS: <b>' . $info['Delivery_Destination_Comments'] . '</b></u><p>';
        // $comments = '<p style="text-align: justify" ><u><b>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam quidem, quisquam dolor recusandae dolores animi tempore esse temporibus cumque corporis in quam at itaque doloribus. Earum esse et rem soluta ex minus numquam quod itaque cupiditate nihil consectetur hic suscipit sit sint dicta, recusandae fugiat nesciunt laudantium culpa facere libero aspernatur? Unde, pariatur. Ratione rerum, necessitatibus quae vel maxime modi quis sapiente nisi voluptas perspiciatis facere similique doloremque, dolores non minus amet beatae eum temporibus. Odit quos maxime quae. Fugit, vitae doloremque. Distinctio tempora officiis perspiciatis doloremque, corrupti, eligendi soluta officia ipsum magnam laudantium aut harum ullam nisi? Perferendis assumenda sed officiis cum a. Repudiandae tempore sunt quod culpa optio est odit! Earum doloremque optio, architecto facilis delectus qui reiciendis itaque reprehenderit. Repellendus cum quam eius doloribus reprehenderit quibusdam officia dolor fugit nihil! Nulla eligendi amet aut magnam, eos expedita et adipisci quam vitae beatae aliquid consequuntur commodi impedit quos repudiandae similique incidunt dicta ipsum nihil repellat architecto molestias vel nesciunt recusandae! Delectus quam molestiae facilis neque voluptatem magnam quisquam cum est. Quo aspernatur dolor praesentium mollitia sapiente, obcaecati harum, esse tempore, nihil delectus quibusdam provident fugit! Natus error ipsam iusto suscipit voluptatibus, aut quaerat explicabo totam, porro odio mollitia!</b></u><p>';
        // $pdf->writeHTML($comments);

        # ATTENTION
        $pdf->SetFont('helvetica', 'B', '10');
        $pdf->Cell(0, 0, 'ATTENTION,  Please acknowledge the following, ', 0, 0, 'C', 0, '', 0);
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont('helvetica', '', '10');
        $attentionList = '<ul><li>TRUCKER HAS AGREED TO THE TOTAL WEIGHT ADVISED ABOVE +  PALLET WEIGHT.</li><li>IF THERE ARE ANY CHANGES TO DELIVERY, TRUCKER MUST NOTIFY.</li></ul>';
        $pdf->writeHTML($attentionList);
        


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
        $pdf->Output('PO REF ' . $info['PO_Reference'], 'I');

        //============================================================+
        // END OF FILE
        //============================================================+
    }
}

# SE INSTANCIA LA CLASE PARA LA GENERACION DEL ARCHIVO PDF
PdfOrder::makePDF($resultado);
