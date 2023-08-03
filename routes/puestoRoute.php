
<?php 

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, token");
    header("Content-Type: application/json");


    require_once "../app/services/puestos.php";
    require_once "../app/respuestas/respuesta.php";
    require_once "../app/auth/authClass.php";

    $puesto = new Puesto;
    $respuesta = new Respuesta;
    $auth = new authClass;

    
    $headers = getallheaders();
    if(isset($headers['Token'])){
        $is_token = $auth->findToken($headers['Token']);
        if($is_token){
            
            if($_SERVER["REQUEST_METHOD"] == "GET"){
            
                if(isset($_GET["page"])){
                    $pagina = $_GET["page"];
                    $puestoLista = $puesto->getPuestoPagina($pagina);
                    http_response_code(200);      
                    echo json_encode($puestoLista);
                }else if(isset($_GET["id"])){
                    $id_puesto = $_GET["id"];
                    $puesto_data = $puesto->getPuesto($id_puesto);
                    http_response_code(200);      
                    echo json_encode($puesto_data);
                }else{
                    $puestoLista = $puesto->getPuestoLista();
                    http_response_code(200);      
                    echo json_encode($puestoLista);
                }
            
            }else if($_SERVER["REQUEST_METHOD"] == "POST"){

                $body = file_get_contents("php://input");
                $result = $puesto->savePuesto($body);
                if(isset($result["result"]["error_id"])){
                    $error_code = $result["result"]["error_id"];
                    http_response_code($error_code);
                }else{
                    http_response_code(200);
                }
                echo json_encode($result); 
            
            }else if($_SERVER["REQUEST_METHOD"] == "DELETE"){

                $body = file_get_contents("php://input");
                $result = $puesto->deletePuesto($body);
                if(isset($result["result"]["error_id"])){
                    $error_code = $result["result"]["error_id"];
                    http_response_code($error_code);
                }else{
                    http_response_code(200);
                }
                echo json_encode($result);

            }else if($_SERVER["REQUEST_METHOD"] == "PUT"){

                $body = file_get_contents("php://input");
                $result = $puesto->updatePuesto($body);
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