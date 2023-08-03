
<?php 

    require_once "../database/consulta.php";
    require_once "../app/respuestas/respuesta.php";


    class authClass extends Consulta{

        public function login($json){
            try {
                $respuesta = new Respuesta;
                $data = json_decode($json, true);
                if (!isset($data["usuario"]) || !isset($data["password"])) {
                    return $respuesta->error400();
                } else {
                    $usuario_validado = $this->validateCredentials($data['usuario'], $data['password']);
                    if(isset($usuario_validado["result"])){
                        return $usuario_validado;
                    }else{
                        return $respuesta->error200("Credenciales invalidas");
                    }
                }
            } catch (Exception $e) {
                return $respuesta->error200("Error al iniciar sesión");
            }
        }

        public function validateCredentials($usuario, $password){
            try {
                $respuesta = new Respuesta;
                $pass_encrypt = parent::encriptPassword($password);
                $dataUser = $this->extractData($usuario);
                if($dataUser){
                    if($pass_encrypt == $dataUser[0]['pass_word']){
                        $is_token = $this->isValidate($dataUser);
                        if(!$is_token){
                            $token = $this->createToken($dataUser);
                            if($token){
                                $result = $respuesta->response;
                                $result["result"] = array( "token" => $token );
                                return $result;
                            }else{
                                return false;
                            }
                        }else{
                            $result = $respuesta->response;
                            $result["result"] = array( "token" => $is_token );
                            return $result;
                        }
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            } catch (Exception $e) {
                return false;
            }
        }

        public function extractData($param){
            $query = "select * from usuario_myvote where email = '$param' or user_name = '$param'";
            $data = parent::executeQuery($query);
            if(isset($data[0]['id'])){
                return $data;
            }else{
                return false;
            }
        }

        public function createToken($param) {
            try {
                if(isset($param[0]['id'])){
                    $id_usuario = $param[0]['id'];
                    $val = true;
                    $token = bin2hex(openssl_random_pseudo_bytes(16, $val));
                    date_default_timezone_set('America/Bogota');
                    $date = date("Y-m-d H:i:s");
                    $estado = "activo";
                    $query = "insert into tokens_myvote (token, estado, fecha, id_usuario) 
                                            values('$token', '$estado', '$date', $id_usuario)";
                    $result = parent::executeNotQuery($query);
                    if($result){
                        return $token;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            } catch (Exception $e) {
                return false;
            }
        }

        public function isAdmin($token){
            try {
                $query = "select id_usuario from tokens_myvote where token = '$token' and estado = 'activo'";
                $result = parent::executeQuery($query);
                $rol = $this->extractRol($result);
                if($rol and $rol == 'admin'){
                    return true;
                }else{
                    return false;
                }
            } catch (Exception $e) {
                return false;
            }
        }

        private function extractRol($param){
            try {
                if(isset($param[0]['id_usuario'])){
                    $id_usuario = $param[0]['id_usuario'];
                    $query = "select rol from usuario_myvote where id = $id_usuario";
                    $result = parent::executeQuery($query);
                    if(isset($result[0]['rol'])){
                        return $result[0]['rol'];
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            } catch (Exception $e) {
                return false;
            }
        }

        public function findToken($token){
            try {
                $query = "select * from tokens_myvote where token = $token";
                $result = parent::executeQuery($query);
                echo $result;
                if($result){
                    return true;
                }else{
                    return false;
                }
            } catch (Exception $e) {
                return false;
            }
        }

        private function isValidate($param){
            try {
                if(isset($param[0]['id'])){
                    $id_usuario = $param[0]['id'];
                    $query = "select token from tokens_myvote where id_usuario = $id_usuario and estado = 'activo'";
                    $result = parent::executeQuery($query);
                    if(isset($result[0]['token'])){
                        return $result[0]['token'];
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            } catch (Exception $e) {
                return false;
            }
        }

        private function updateToken($id_token){
            try {
                date_default_timezone_set('America/Bogota');
                $date = date("Y-m-d H:i:s");
                $query = "update tokens_myvote set fecha = $date where id = $id_token";
                $result = parent::executeNotQuery($query);
                if($result >= 1){
                    return $result;
                }else{
                    return false;
                }
            } catch (Exception $e) {
                return false;
            }
        }

    }

?>