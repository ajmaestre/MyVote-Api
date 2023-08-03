<?php 

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type");
    header("Content-Type: application/json");

    require_once "../app/auth/authClass.php";
    require_once "../app/respuestas/respuesta.php";


    $respuesta = new Respuesta;
    $auth = new authClass;


    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $postBody = file_get_contents('php://input');
        $login = $auth->login($postBody);

        if(isset($login["result"]["error_id"])){
            $response_code = $login["result"]["error_id"];
            http_response_code($response_code);
        }else{
            http_response_code(200);
        }
        echo json_encode($login);

    }else{
        $response_invalid = $respuesta->error405();
        echo json_encode($response_invalid);
    }

?>