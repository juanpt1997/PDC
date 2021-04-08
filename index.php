<?php
/* ===================================================
       INDEX: We will show the responses of the views to the user, also we will send the different actions that the user have to the controller

    ===================================================*/

/* ===================================================
   CONTROLLERS REQUIRED FOR THE PROJECT
===================================================*/
require_once "./controllers/plantilla_controlador.php";
require_once "./controllers/users.controller.php";
require_once "./controllers/operations.controller.php";
require_once "./controllers/files.controller.php";
require_once "./controllers/mail.controller.php";
require_once "./controllers/dashboard.controller.php";

/* ===================================================
   MODELS REQUIRED FOR THE PROJECT
===================================================*/
require_once "./models/operations.model.php";
require_once "./models/users.model.php";
require_once "./models/dashboard.model.php";


$plantilla = new ControladorPlantilla();
$plantilla->ctrTraerPlantilla();
