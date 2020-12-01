<?php
# CONFIGURACION DE LA SESION
include '../session-config.php';
$url = $_SERVER['REQUEST_SCHEME'] . '://' .  $_SERVER['HTTP_HOST'] . "/cac/crm ";
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

// var_dump($_SESSION);die();

#SE ESTABLECE EL HORARIO 
date_default_timezone_set('America/Bogota');

# SE REQUIERE EL AUTOLOAD
require $_SERVER['DOCUMENT_ROOT'] . '/cac/crm/vendor/autoload.php';

# REQUERIMOS EL CONTROLADOR Y EL MODELO PARA HACER USO DE LA INFORMACIÓN
require '../controllers/peticion-oferta.controlador.php';
require '../models/peticion-oferta.modelo.php';

$resultado = ControladorPeticionOferta::ctrInfoPO($idOferta);
$informacion = $resultado['informacion'];
$cotizacion = $resultado['cotizacion'];

/* ===================== 
  SI LA INFORMACIÓN VIENE FALSA SE REDIRECCIONA A LA PETICION DE OFEERTAS 
========================= */
if ($informacion === false) {
    $redireccion = $url . "/c-leads";
    header("Location: $redireccion");
}

/*     
    var_dump($resultado);
    die();
*/
# Espacio de trabajo
use Fpdf\Fpdf;

class PDF extends FPDF
{

    //la cabecera de nuestro reporte
    function Header()
    {

        $ofertaNo = ControladorPeticionOferta::ctrInfoPO($_REQUEST['idOferta'])['informacion']['idOferta'];

        // Logo X,Y, MEDIDA
        $this->Image('../views/img/logos/logo_coytex.png', 1, 0.8, 4, 3);
        // Arial bold 15
        $this->SetFont('Arial', '', 10);
        $this->Cell(4); //CORREMOS LA CELDA 4 CM
        $this->MultiCell(7, 0.5, "CO & TEX S.A.S \nNIT 800122420-6 \nCALLE 11 No. 17 # 27 LOS CAMBULOS \nTEL : (576) 3301036 \nDOSQUEBRADAS/RLDA, COLOMBIA", 0, 'L');
        $this->Cell(15);
        $this->SetXY(15, 1.5);
        $this->SetFont('Arial', 'B', 12);
        $this->MultiCell(4, 0.5, "OFERTA No. \n$ofertaNo", 0, 'C');
        $this->Ln(2);
    }

    //pie de pagina de nuestro reporte
    function Footer()
    {
        //posicion del pie de pagina
        $this->SetY(-2.5);
        //establecemos fuente(tipo de letra,estilo y tamaño)
        #$this->SetFont('Arial','I',7);
        //funcion para saber el numero de paginas que se tiene en el reporte
        //cuando colocamos 0 indicamos que este ocupa el centro de nuestra hoja
        #$this->Cell(0,28, utf8_decode('Página').$this->PageNo().'/{nb}',0,0,'C');      
    }


    #  https://gist.github.com/johnballantyne/4089627
    // Funcion para multilinea fpdf

    function GetMultiCellHeight($w, $h, $txt, $border = null, $align = 'J')
    {
        // Calculate MultiCell with automatic or explicit line breaks height
        // $border is un-used, but I kept it in the parameters to keep the call
        //   to this function consistent with MultiCell()
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $ns = 0;
        $height = 0;
        while ($i < $nb) {
            // Get next character
            $c = $s[$i];
            if ($c == "\n") {
                // Explicit line break
                if ($this->ws > 0) {
                    $this->ws = 0;
                    $this->_out('0 Tw');
                }
                //Increase Height
                $height += $h;
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
                $ls = $l;
                $ns++;
            }
            $l += $cw[$c];
            if ($l > $wmax) {
                // Automatic line break
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                    if ($this->ws > 0) {
                        $this->ws = 0;
                        $this->_out('0 Tw');
                    }
                    //Increase Height
                    $height += $h;
                } else {
                    if ($align == 'J') {
                        $this->ws = ($ns > 1) ? ($wmax - $ls) / 1000 * $this->FontSize / ($ns - 1) : 0;
                        $this->_out(sprintf('%.3F Tw', $this->ws * $this->k));
                    }
                    //Increase Height
                    $height += $h;
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
            } else
                $i++;
        }
        // Last chunk
        if ($this->ws > 0) {
            $this->ws = 0;
            $this->_out('0 Tw');
        }
        //Increase Height
        $height += $h;

        return $height;
    }
}


class ControladorPdf
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
      CONTROLADOR PARA LA GENERACIÓN DE ARCHIVO  PDF DE LA PETICION DE OFERTA
    ========================= */
    static public function pdfPO($informacion, $cotizacion)
    {
        //creamos objeto de la libreria fpdf
        $pdf = new PDF('P', 'cm', 'Letter');
        //variable aliaspages para indicar el numero de paginas
        $pdf->AliasNbPages();

        //la funcion addpage crea una pagina
        $pdf->AddPage('P', 'Letter');

        $pdf->SetY(4);
        //titulo => ancho, alto, stingn, border, salto de linea , centrado
        $pdf->SetFont('Arial', '', 12);
        // $pdf->Cell(20, 1, 'Dosquebradas, 5 de Agosto del 2020', 0, 1, 'L');
        $pdf->Cell(20, 1, 'Dosquebradas, ' . date('d') . ' de ' . self::mesNombre(date('m')) . ' del ' . date('Y'), 0, 1, 'L');
        $pdf->Ln();


        $pdf->Cell(20, 0.5, utf8_decode($informacion['tratoCont']), 0, 1, 'L');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20, 0.5, utf8_decode($informacion['nombreCont']), 0, 1, 'L');

        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(20, 0.5, utf8_decode($informacion['razonSocial']), 0, 1, 'L');

        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20, 0.5, 'ASUNTO: ' . utf8_decode($informacion['asunto']), 0, 1, 'L');

        $pdf->Ln();

        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(20, 0.5, "Reciba un cordial saludo, de acuerdo a su solicitud estamos enviando la \ncotizacion correspondiente: ", 0, 'L');

        $pdf->Ln();

        #TABLA 
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(3.5, 0.7, 'IMAGEN', 1, 0, 'C');
        $pdf->Cell(2.5, 0.7, 'MODELO', 1, 0, 'C');
        $pdf->Cell(8, 0.7, utf8_decode('DESCRIPCIÓN'), 1, 0, 'C');
        $pdf->Cell(2.5, 0.7, 'CANTIDAD', 1, 0, 'C');
        $pdf->Cell(2, 0.7, 'PRECIO', 1, 1, 'C');


        $pdf->SetFont('Arial', '', 10);


        $columnaX = 15;
        $columnaY = 11.2;

        foreach ($cotizacion as $key => $value) {
            $imagen = $_SESSION['dominio'] . "/" . $value['rutaImg'];

            $pdf->Cell(3.5, 2, $pdf->Image($imagen, $pdf->GetX(), $pdf->GetY(), 3, 2), 1, 0, 'C');

            $pdf->Cell(2.5, 2, utf8_decode($value['modelo']), 1, 0, 'C');

            
            $pdf->MultiCell(8,2,utf8_decode($value['descripcion']),1,'C');
            
            # SE ASIGNA NUEVA POSICIÓN
            $pdf->SetXY($columnaX, $columnaY);

            $pdf->Cell(2.5, 2, utf8_decode($value['cantidad']), 1, 0, 'C');
            $pdf->Cell(2, 2, utf8_decode($value['precio']), 1, 1, 'C');

            # SE REASIGNA DE ACUREDO A Y SU VALOR
            $columnaY += 2;
        }


        /* for ($i = 0; $i < 10; $i++) {
            $pdf->Cell(4, 0.5, '', 1, 0, 'C');
            $pdf->Cell(4, 0.5, '', 1, 0, 'C');
            $pdf->Cell(4, 0.5, '', 1, 0, 'C');
            $pdf->Cell(4, 0.5, '', 1, 0, 'C');
            $pdf->Cell(4, 0.5, '', 1, 1, 'C');
        } */

        $pdf->Ln(0.5);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20, 0.5, 'LOS PRECIOS NO INCLUYEN I.V.A.', 0, 1, 'L');

        $pdf->Ln();

        $pdf->SetFont('Arial', '', 10);
        // $pdf->MultiCell(20,1,utf8_decode("OBSERVACIÓN: "),1,'L');
        $pdf->MultiCell(18.5, 0.5, utf8_decode("OBSERVACIÓN: " . $informacion['observacion']), 1, 'L');




        $pdf->Ln(2);

        // $pdf->SetY(22);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(10, 0.5, 'Atentamente,', 0, 1);

        $pdf->Ln(2);


        $pdf->Cell(10, 0.5, 'DIEGO PINEDA JIMENEZ', 0, 1);
        $pdf->Cell(10, 0.5, 'PRESIDENTE CO & TEX S.A.S', 0, 1);


        $nombrePdf = $informacion['idOferta'] . '_' . date('Y-m-d') . '_' . date('His') . '.pdf';

        # SALIDA DEL DOCUMENTO
        $pdf->Output('I', $nombrePdf);
    }
}

# GENERO EL DOCUEMENTO PDF
ControladorPdf::pdfPO($informacion, $cotizacion);
