<?php
// Vista.php

require_once('../controlador/EventController.php');

// Recuperar el 'id' del evento de manera segura
$id = $_REQUEST['id'];

// Llamar al método del controlador para eliminar el evento
$eventController = new EventController();
$eventController->eliminarEvento($id);
?>
