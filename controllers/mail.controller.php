<?php 
    class ControladorCorreo
    {
        static public function ctrEnviarCorreo($to, $subject, $message)
        {
            $headers = "From: operations@pdcworldwide.com" . "\r\n";
            $headers .= "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            mail($to, $subject, $message, $headers);
        }
    }