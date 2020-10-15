<?php

/* ===================================================
       CONTROLADOR PARA GESTIONAR EL ALMACENAMIENTO DE ARCHIVOS
    ===================================================*/
class FilesController
{
    public $file;
    public $ruta;

    /* ===================================================
           CONTROLADOR PARA LAS IMAGENES
        ===================================================*/
    public function ctrImages($nuevoAncho, $nuevoAlto)
    {
        $response = "";
        $imagen = $this->file;
        $ruta = $this->ruta;

        /* ===================== 
            ? VALIDAR LA IMAGEN 
        ========================= */
        if (is_array($imagen) && $imagen['tmp_name'] != "") {
            /* list nos permite crear un nuevo array con los indices que se le asignen */
            list($ancho, $alto) = getimagesize($imagen['tmp_name']);

            # Esto es en caso de que queramos un tamaño en especial para guardar las imagenes o guardar asi por defecto
            if ($nuevoAncho == null || $nuevoAlto == null){
                $nuevoAncho = $ancho;
                $nuevoAlto = $alto;
            }
            
            /* ===================== 
            DE ACUERDO AL TIPO DE IMAGEN SE APLICA UNA FUNCION POR DEFECTO DE PHP 
        ========================= */
            if ($imagen['type'] == "image/jpeg") {
                /* ===================== 
                GUARDAMOS LA IMAGEN EN EL DIRECTORIO 
            ========================= */
                $ruta .= ".jpg";

                $origen = imagecreatefromjpeg($imagen['tmp_name']);
                $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                imagejpeg($destino, $ruta);
                $response = $ruta;
            }

            if ($imagen['type'] == "image/png") {
                /* ===================== 
                GUARDAMOS LA IMAGEN EN EL DIRECTORIO 
            ========================= */
                $ruta .= ".png";

                $origen = imagecreatefrompng($imagen['tmp_name']);
                $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                imagepng($destino, $ruta);
                $response = $ruta;
            }
        }

        return $response;
    }

    /* ===================================================
       CONTROLADOR PARA ARCHIVOS PDF
    ===================================================*/
    public function ctrPDFFiles()
    {
        $response = "";
        $pdf = $this->file;
        $ruta = $this->ruta . ".pdf";
        $source_file = $pdf['tmp_name'];

        if (file_exists($ruta)) {
            print "The file name already exists!!";
        } else {
            move_uploaded_file($source_file, $ruta)
                or die("Error!!");
            if ($pdf['error'] == 0) {
                $response = $ruta;
            }
        }
        return $response;
    }
}
