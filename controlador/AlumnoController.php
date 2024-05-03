<?php
// AlumnoController.php

require_once('../../conexion.php');

class AlumnoController {
    public function obtenerAsistencia() {
        $link = conectarse();
        $instruccion = "SELECT asistencia.fkcodalumno, asistencia.fknomalumno, asistencia.fkapealumno, asistencia.fecha, asistencia.estado FROM asistencia";
        $resultado = mysqli_query($link, $instruccion) or die("Fallo en la consulta");

        $asistencias = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $asistencias[] = $fila;
        }

        mysqli_close($link);
        return $asistencias;
    }
}
?>