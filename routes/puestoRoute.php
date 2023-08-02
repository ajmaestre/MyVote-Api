
<?php 

    require_once "../app/services/puestos.php";
    require_once "../app/respuestas/respuesta.php";
    require_once "../app/auth/authClass.php";

    $puesto = new Puesto;
    $respuesta = new Respuesta;
    $auth = new authClass;


    if($_SERVER["REQUEST_METHOD"] == "GET"){

        $headers = getallheaders();
        if(isset($headers['token'])){
            $is_token = $auth->findToken($headers['token']);
            if($is_token){
                if(isset($_GET["page"])){
                    $pagina = $_GET["page"];
                    $puestoLista = $puesto->getPuestoPagina($pagina);
                    header("Content-Type: application/json");      
                    http_response_code(200);      
                    echo json_encode($puestoLista);
                }else if(isset($_GET["id"])){
                    $id_puesto = $_GET["id"];
                    $puesto_data = $puesto->getPuesto($id_puesto);
                    header("Content-Type: application/json");      
                    http_response_code(200);      
                    echo json_encode($puesto_data);
                }else{
                    $puestoLista = $puesto->getPuestoLista();
                    header("Content-Type: application/json");      
                    http_response_code(200);      
                    echo json_encode($puestoLista);
                }
            }else{
                header("Content-Type: application/json");
                $response_invalid = $respuesta->error401("Token invalido");
                echo json_encode($response_invalid);
            }
        }else{
            header("Content-Type: application/json");
            $response_invalid = $respuesta->error401("No se ha encontrado ningun token");
            echo json_encode($response_invalid);
        }

    }else if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        $headers = getallheaders();
        if(isset($headers['token'])){
            $is_token = $auth->findToken($headers['token']);
            if($is_token){
                $body = file_get_contents("php://input");
                $result = $puesto->savePuesto($body);
                header("Content-Type: application/json");      
                if(isset($result["result"]["error_id"])){
                    $error_code = $result["result"]["error_id"];
                    http_response_code($error_code);
                }else{
                    http_response_code(200);
                }
                echo json_encode($result); 
            }else{
                header("Content-Type: application/json");
                $response_invalid = $respuesta->error401("Token Invalido");
                echo json_encode($response_invalid);
            }
        }else{
            header("Content-Type: application/json");
            $response_invalid = $respuesta->error401("No se ha encontrado ningun token");
            echo json_encode($response_invalid);
        }

    }else if($_SERVER["REQUEST_METHOD"] == "DELETE"){
        
        $headers = getallheaders();
        if(isset($headers['token'])){
            $is_token = $auth->findToken($headers['token']);
            if($is_token){
                $body = file_get_contents("php://input");
                $result = $puesto->deletePuesto($body);
                header("Content-Type: application/json");      
                if(isset($result["result"]["error_id"])){
                    $error_code = $result["result"]["error_id"];
                    http_response_code($error_code);
                }else{
                    http_response_code(200);
                }
                echo json_encode($result);
            }else{
                header("Content-Type: application/json");
                $response_invalid = $respuesta->error401("Usuario no autorizado");
                echo json_encode($response_invalid);
            }
        }else{
            header("Content-Type: application/json");
            $response_invalid = $respuesta->error401("No se ha encontrado ningun token");
            echo json_encode($response_invalid);
        }
        
    }else if($_SERVER["REQUEST_METHOD"] == "PUT"){
        
        $headers = getallheaders();
        if(isset($headers['token'])){
            $is_token = $auth->findToken($headers['token']);
            if($is_token){
                $body = file_get_contents("php://input");
                $result = $puesto->updatePuesto($body);
                header("Content-Type: application/json");      
                if(isset($result["result"]["error_id"])){
                    $error_code = $result["result"]["error_id"];
                    http_response_code($error_code);
                }else{
                    http_response_code(200);
                }
                echo json_encode($result);
            }else{
                header("Content-Type: application/json");
                $response_invalid = $respuesta->error401("Usuario no autorizado");
                echo json_encode($response_invalid);
            }
        }else{
            header("Content-Type: application/json");
            $response_invalid = $respuesta->error401("No se ha encontrado ningun token");
            echo json_encode($response_invalid);
        }
        
    }else{

        header("Content-Type: application/json");
        $response_invalid = $respuesta->error405();
        echo json_encode($response_invalid);

    }

?>