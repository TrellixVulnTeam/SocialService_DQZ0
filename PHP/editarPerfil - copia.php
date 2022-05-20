<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require_once("ConexionBD.php");
require_once("ruta.php");


    $json = file_get_contents('php://input');
    $params = json_decode($json);
    $base64 = $params->img;
    $usuario = $params->usuario;

    $base_to_php = explode(',', $base64);
    $data = base64_decode($base_to_php[1]);
    $path_Generico = getcwd();
    $path_img = "/User/".$usuario.".png";
    $filepath = $path_Generico.''.$path_img;
    $ruta = ruta();

    $path_database = $ruta.''.$path_img;

    file_put_contents($filepath, $data);

    $conexion = conexion();
    if(isset($base64)){
       if(mysqli_query($conexion, "UPDATE usuario SET Perfil = '$path_database' WHERE idUsuario = '$usuario'")){
        $json_response = ['Respuesta' => 'Exitoso'];
        $json = json_encode($json_response);
        echo $json;
        header('Content-Type: application/json');
       }
    }
?>