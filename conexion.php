<?php 
function conectarse()
{
if(!($link = mysqli_connect("localhost", "root","", "agenda_jobs")))
{
    echo"error conectando a la base de datos."; 
    exit();
}
return $link;
}
?>