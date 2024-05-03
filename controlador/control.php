<?php
session_start();
include("../conexion.php");

if (isset($_POST['usuario']) && isset($_POST['password'])) {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $link = Conectarse();
    $stmt = $link->prepare("SELECT * FROM usuarios WHERE codusuario = ? AND contraseña = ?");
    $stmt->bind_param("ss", $usuario, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $campo = $result->fetch_assoc();
        $rol = $campo['fk_idrol'];

        switch ($rol) {
            case 1:
                header('Location: ../controlador/comprobacion.php');
                break;
            case 2:
                header('Location: ../controlador/comprobacion_docente.php');
                break;
            default:
                header('Location: ../index.php');
                break;
        }
    } else {
        header("Location: ../index.php?errorusuario=si");
    }
    $stmt->close();
    $link->close();
}

?>
<?php
