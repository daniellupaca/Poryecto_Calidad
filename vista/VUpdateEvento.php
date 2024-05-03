<?php
date_default_timezone_set("America/Lima");
setlocale(LC_ALL, "es_ES");

require_once('../config.php'); // Asegúrate de que este archivo carga correctamente.
require_once('../controlador/EventController.php'); // Incluir el controlador correctamente.

// Obtener los datos del formulario
$idEvento = $_POST['idEvento'];
$evento = ucwords($_REQUEST['evento']);
$f_inicio = $_REQUEST['fecha_inicio'];
$fecha_inicio = date('Y-m-d', strtotime($f_inicio)); 

$f_fin = $_REQUEST['fecha_fin']; 
$seteando_f_final = date('Y-m-d', strtotime($f_fin));  
$fecha_fin1 = strtotime($seteando_f_final . " + 1 days");
$fecha_fin = date('Y-m-d', $fecha_fin1);  
$color_evento = $_REQUEST['color_evento'];

// Llamar al método del controlador para actualizar el evento
$eventController = new EventController();
$eventController->actualizarEvento($idEvento, $evento, $fecha_inicio, $fecha_fin, $color_evento);

// Redirigir al usuario
header("Location: ./Vindex.php?ea=1");
exit();
?>
