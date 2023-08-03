<?php 

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, token");
    header("Content-Type: application/json");
    

    require_once "../app/services/jurados.php";
    require_once "../app/respuestas/respuesta.php";
    require_once "../app/auth/authClass.php";

    $jurado = new Jurado;
    $respuesta = new Respuesta;
    $auth = new authClass;


    if($_SERVER["REQUEST_METHOD"] == "GET"){

        $headers = getallheaders();
        if(isset($headers['token'])){
            $is_token = $auth->findToken($headers['token']);
            if($is_token){
                if(isset($_GET["page"])){
                    $pagina = $_GET["page"];
                    $juradoLista = $jurado->getJuradoPagina($pagina);
                    echo json_encode($juradoLista);
                }else if(isset($_GET["id"])){
                    $id_jurado = $_GET["id"];
                    $jurado_data = $jurado->getJurado($id_jurado);
                    http_response_code(200);      
                    echo json_encode($jurado_data);
                }else{
                    $juradoLista = $jurado->getJuradoLista();
                    http_response_code(200);      
                    echo json_encode($juradoLista);
                }
            }else{
                $response_invalid = $respuesta->error401("Token invalido");
                echo json_encode($response_invalid);
            }
        }else{
            $response_invalid = $respuesta->error401("No se ha encontrado ningun token");
            echo json_encode($response_invalid);
        }

    }else if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        $headers = getallheaders();
        if(isset($headers['token'])){
            $is_token = $auth->findToken($headers['token']);
            if($is_token){
                $body = file_get_contents("php://input");
                $result = $jurado->saveJurado($body);
                if(isset($result["result"]["error_id"])){
                    $error_code = $result["result"]["error_id"];
                    http_response_code($error_code);
                }else{
                    http_response_code(200);
                }
                echo json_encode($result); 
            }else{
                $response_invalid = $respuesta->error401("Token Invalido");
                echo json_encode($response_invalid);
            }
        }else{
            $response_invalid = $respuesta->error401("No se ha encontrado ningun token");
            echo json_encode($response_invalid);
        }

    }else if($_SERVER["REQUEST_METHOD"] == "DELETE"){
        
        $headers = getallheaders();
        if(isset($headers['token'])){
            $is_token = $auth->findToken($headers['token']);
            if($is_token){
                $body = file_get_contents("php://input");
                $result = $jurado->deleteJurado($body);
                if(isset($result["result"]["error_id"])){
                    $error_code = $result["result"]["error_id"];
                    http_response_code($error_code);
                }else{
                    http_response_code(200);
                }
                echo json_encode($result);
            }else{
                $response_invalid = $respuesta->error401("Usuario no autorizado");
                echo json_encode($response_invalid);
            }
        }else{
            $response_invalid = $respuesta->error401("No se ha encontrado ningun token");
            echo json_encode($response_invalid);
        }
        
    }else if($_SERVER["REQUEST_METHOD"] == "PUT"){
        
        $headers = getallheaders();
        if(isset($headers['token'])){
            $is_token = $auth->findToken($headers['token']);
            if($is_token){
                $body = file_get_contents("php://input");
                $result = $jurado->updateJurado($body);
                if(isset($result["result"]["error_id"])){
                    $error_code = $result["result"]["error_id"];
                    http_response_code($error_code);
                }else{
                    http_response_code(200);
                }
                echo json_encode($result);
            }else{
                $response_invalid = $respuesta->error401("Usuario no autorizado");
                echo json_encode($response_invalid);
            }
        }else{
            $response_invalid = $respuesta->error401("No se ha encontrado ningun token");
            echo json_encode($response_invalid);
        }
        
    }else{

        $response_invalid = $respuesta->error405();
        echo json_encode($response_invalid);

    }

?>