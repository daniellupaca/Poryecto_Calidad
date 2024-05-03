<?php
// EventController.php

require_once('../config.php');

class EventController {
    public function obtenerEventos() {
        global $con;

        $SqlEventos   = "SELECT * FROM eventoscalendar";
        $resulEventos = mysqli_query($con, $SqlEventos);

        $eventos = [];
        while ($dataEvento = mysqli_fetch_array($resulEventos)) {
            $eventos[] = [
                '_id'   => $dataEvento['id'],
                'title' => $dataEvento['evento'],
                'start' => $dataEvento['fecha_inicio'],
                'end'   => $dataEvento['fecha_fin'],
                'color' => $dataEvento['color_evento']
            ];
        }

        return $eventos;
    }

    public function eliminarEvento($id) {
        global $con;

        // Preparar la sentencia SQL para prevenir inyección SQL
        if ($stmt = $con->prepare("DELETE FROM eventoscalendar WHERE id = ?")) {
            // Vincular el parámetro 'id' a la variable $id
            $stmt->bind_param("i", $id);

            // Ejecutar la sentencia
            $stmt->execute();

            // Cerrar la sentencia
            $stmt->close();
        } else {
            // Manejar el error de preparación aquí
            error_log('Error al preparar la sentencia: ' . $con->error);
        }

        // Redireccionar al usuario a la página deseada
        header("Location: ./Vindex.php?ea=1");
        exit();
    }

    public function crearEvento($evento, $fecha_inicio, $fecha_fin, $color_evento) {
        global $con;

        // Preparar la sentencia SQL
        $stmt = $con->prepare("INSERT INTO eventoscalendar (evento, fecha_inicio, fecha_fin, color_evento) VALUES (?, ?, ?, ?)");

        // Verificar si la preparación de la sentencia fue exitosa
        if ($stmt === false) {
            // Manejar el error aquí
            die('Error al preparar la sentencia: ' . htmlspecialchars($con->error));
        }

        // Vincular los parámetros a la sentencia
        $stmt->bind_param("ssss", $evento, $fecha_inicio, $fecha_fin, $color_evento);

        // Ejecutar la sentencia
        $stmt->execute();

        // Verificar si hubo errores durante la ejecución
        if ($stmt->error) {
            // Manejar el error aquí
            die('Error al ejecutar la sentencia: ' . htmlspecialchars($stmt->error));
        }

        // Cerrar la sentencia
        $stmt->close();

        // Redireccionar al usuario a la página deseada
        header("Location: ./Vindex.php?e=1");
        exit();
    }
    public function actualizarEvento($idEvento, $evento, $fecha_inicio, $fecha_fin, $color_evento) {
        global $con;
    
        // Preparar la sentencia SQL
        $stmt = $con->prepare("UPDATE eventoscalendar SET evento = ?, fecha_inicio = ?, fecha_fin = ?, color_evento = ? WHERE id = ?");
        
        // Verificar si la preparación de la sentencia fue exitosa
        if ($stmt === false) {
            // Manejar el error aquí
            die('Error al preparar la sentencia: ' . htmlspecialchars($con->error));
        }
    
        // Vincular los parámetros a la sentencia
        $stmt->bind_param("ssssi", $evento, $fecha_inicio, $fecha_fin, $color_evento, $idEvento);
    
        // Ejecutar la sentencia
        $stmt->execute();
    
        // Verificar si hubo errores durante la ejecución
        if ($stmt->error) {
            // Manejar el error aquí
            die('Error al ejecutar la sentencia: ' . htmlspecialchars($stmt->error));
        }
    
        // Cerrar la sentencia
        $stmt->close();
    }
}
?>
