
<?php

    require_once '../database/consulta.php';
    require_once "../app/respuestas/respuesta.php";
    require_once "../app/models/usuario.php";

    
    class Usuario extends Consulta{

        private $table = 'usuario_myvote';
        private $usuarioList = array();

        public function getUsuarioLista(){
            try {
                $respuesta = new Respuesta();
                $query = "select * from $this->table";
                $result = parent::executeQuery($query);
                foreach ($result as $key => $value) {
                    $usuario = $this->setUsuario($value);
                    $this->usuarioList[] = $usuario->getUsuario();
                }
                return $this->usuarioList;
            } catch (Exception $e) {
                return $respuesta->error500(); 
            }
        }

        public function getUsuario($id){
            try {
                $respuesta = new Respuesta();
                $query = "select * from $this->table where id = $id";
                $result = parent::executeQuery($query);
                $usuario = $this->setUsuario($result[0]);
                return $usuario->getUsuario();
            } catch (Exception $e) {
                return $respuesta->error500();
            }
        }

        public function getUsuarioPagina($pagina = 1){
            try {
                $respuesta = new Respuesta();
                $inicio = 0;
                $cantidad = 50;
                if($pagina > 1){
                    $inicio = ($cantidad * ($pagina - 1)) + 1;
                    $cantidad = $cantidad * $pagina;
                }
                $query = "select * from $this->table limit $inicio, $cantidad";
                $result = parent::executeQuery($query);
                foreach ($result as $key => $value) {
                    $usuario = $this->setUsuario($value);
                    $this->usuarioList[] = $usuario->getUsuario();
                }
                return $this->usuarioList;
            } catch (Exception $e) {
                return $respuesta->error500(); 
            }
        }

        public function saveUsuario($data){
            try {
                $respuesta = new Respuesta();
                $usuario = json_decode($data, true);
                if(!$this->validateData($usuario)){
                    return $respuesta->error400();
                }
                $usuario = $this->setUsuario($usuario);
                $query = "insert into $this->table (nombre, apellido, cedula, email, user_name, pass_word, rol) 
                            values 
                            (
                                '".$usuario->getNombre()."', 
                                '".$usuario->getApellido()."', 
                                '".$usuario->getCedula()."', 
                                '".$usuario->getEmail()."',
                                '".$usuario->getUsername()."',
                                md5('".$usuario->getPassword()."'),
                                '".$usuario->getRol()."'
                            )";
                $result = parent::executeNotQuery($query);
                if ($result) {
                    $response = $respuesta->response;
                    $response["result"] = array(
                        "message" => "Usuario guardado"
                    );
                    return $response;
                } else {
                    return $respuesta->error500();
                }
            } catch (Exception $e) {
                return $respuesta->error500();
            }
        }

        public function updateUsuario($data){
            try {
                $respuesta = new Respuesta();
                $usuario = json_decode($data, true);
                if(!isset($usuario['id']) || !$this->validateData($usuario)){
                    return $respuesta->error400();
                }
                $usuario = $this->setUsuario($usuario);
                $query = "update $this->table set
                            nombre = '".$usuario->getNombre()."', 
                            apellido = '".$usuario->getApellido()."', 
                            cedula = '".$usuario->getCedula()."', 
                            email = '".$usuario->getEmail()."',
                            user_name = '".$usuario->getUsername()."',
                            pass_word = md5('".$usuario->getPassword()."'),
                            rol = '".$usuario->getRol()."'
                            where id = ".$usuario->getId()."";
                $result = parent::executeNotQuery($query);
                if ($result) {
                    $response = $respuesta->response;
                    $response["result"] = array(
                        "message" => "Usuario actualizado"
                    );
                    return $response;
                } else {
                    return $respuesta->error500();
                }
            } catch (Exception $e) {
                return $respuesta->error500();
            }
        }

        public function deleteUsuario($data){
            try {
                $respuesta = new Respuesta();
                $usuario = json_decode($data, true);
                if(!isset($usuario['id'])){
                    return $respuesta->error400();
                }
                $query = "delete from $this->table
                            where id = ".$usuario['id']."";
                $result = parent::executeNotQuery($query);
                if ($result) {
                    $response = $respuesta->response;
                    $response["result"] = array(
                        "message" => "Usuario eliminado"
                    );
                    return $response;
                } else {
                    return $respuesta->error500();
                }
            } catch (Exception $e) {
                return $respuesta->error500();
            }
        }

        private function setUsuario($data){
            try {
                if(isset($data['id'])){
                    $usuario = new UsuarioModel(
                        $data['nombre'], 
                        $data['apellido'], 
                        $data['cedula'], 
                        $data['email'],
                        $data['user_name'],
                        $data['pass_word'],
                        $data['rol'],
                        $data['id']
                    );
                }else{
                    $usuario = new UsuarioModel(
                        $data['nombre'], 
                        $data['apellido'], 
                        $data['cedula'], 
                        $data['email'],
                        $data['user_name'],
                        $data['pass_word'],
                        $data['rol']
                    );
                }
                return $usuario;
            } catch (Exception $e) {
                return false; 
            }
        }

        private function validateData($data){
            if(isset($data['nombre']) && 
                isset($data['apellido']) && 
                isset($data['cedula']) && 
                isset($data['email']) &&
                isset($data['user_name']) &&
                isset($data['pass_word']) &&
                isset($data['rol'])){
                    return true;
            }
            return false;
        }

    }

?>