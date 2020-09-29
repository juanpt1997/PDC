<?php
/* ===================================================
       INDEX: We will show the responses of the views to the user, also we will send the different actions that the user have to the controller

    ===================================================*/

/* ===================================================
   CONTROLLERS REQUIRED FOR THE PROJECT
===================================================*/
require_once "./controllers/plantilla_controlador.php";
require_once "./controllers/users.controller.php";

/* ===================================================
   MODELS REQUIRED FOR THE PROJECT
===================================================*/
$plantilla = new ControladorPlantilla();
$plantilla->ctrTraerPlantilla();
