<?php 

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, token");
    header("Content-Type: application/json");

    require_once "../app/services/mesas.php";
    require_once "../app/respuestas/respuesta.php";
    require_once "../app/auth/authClass.php";

    $mesa = new Mesa;
    $respuesta = new Respuesta;
    $auth = new authClass;


    $headers = getallheaders();
    if(isset($headers['Token'])){
        $is_token = $auth->findToken($headers['Token']);
        if($is_token){

            if($_SERVER["REQUEST_METHOD"] == "GET"){

                if(isset($_GET["page"])){
                    $pagina = $_GET["page"];
                    $mesaLista = $mesa->getMesaPagina($pagina);
                    http_response_code(200);      
                    echo json_encode($mesaLista);
                }else if(isset($_GET["id"])){
                    $id_mesa = $_GET["id"];
                    $mesa_data = $mesa->getMesa($id_mesa);
                    http_response_code(200);      
                    echo json_encode($mesa_data);
                }else{
                    $mesaLista = $mesa->getMesaLista();
                    http_response_code(200);      
                    echo json_encode($mesaLista);
                }
        
            }else if($_SERVER["REQUEST_METHOD"] == "POST"){
                
                $body = file_get_contents("php://input");
                $result = $mesa->saveMesa($body);
                if(isset($result["result"]["error_id"])){
                    $error_code = $result["result"]["error_id"];
                    http_response_code($error_code);
                }else{
                    http_response_code(200);
                }
                echo json_encode($result); 
        
            }else if($_SERVER["REQUEST_METHOD"] == "DELETE"){

                $result = '';
                if(isset($_GET["id"])){
                    $id_mesa = $_GET["id"];
                    $result = $mesa->deleteMesa($id_mesa);
                }else{
                    $body = file_get_contents("php://input");
                    $body = json_decode($body, true);
                    $id_mesa = $body["id"];
                    $result = $mesa->deleteMesa($id_mesa);
                }
                
                if(isset($result["result"]["error_id"])){
                    $error_code = $result["result"]["error_id"];
                    http_response_code($error_code);
                }else{
                    http_response_code(200);
                }
                echo json_encode($result);
                
            }else if($_SERVER["REQUEST_METHOD"] == "PUT"){
                
                $result = '';
                $body = file_get_contents("php://input");
                if(isset($_GET["id"])){
                    $id_mesa = $_GET["id"];
                    $result = $mesa->addVotes($id_mesa, $body);
                }else{
                    $result = $mesa->updateMesa($body);
                }
                
                if(isset($result["result"]["error_id"])){
                    $error_code = $result["result"]["error_id"];
                    http_response_code($error_code);
                }else{
                    http_response_code(200);
                }
                echo json_encode($result);
                
            }else{
        
                $response_invalid = $respuesta->error405();
                echo json_encode($response_invalid);
        
            }
        
        }else{
            $response_invalid = $respuesta->error401("Token invalido");
            echo json_encode($response_invalid);
        }
    }else{
        $response_invalid = $respuesta->error401("No se ha encontrado ningun token");
        echo json_encode($response_invalid);
    }


?>