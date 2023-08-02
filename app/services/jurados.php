
<?php

    require_once '../database/consulta.php';
    require_once "../app/respuestas/respuesta.php";
    require_once "../app/models/jurado.php";

    
    class Jurado extends Consulta{

        private $table = 'jurado_myvote';
        private $juradoList = array();

        public function getJuradoLista(){
            try {
                $respuesta = new Respuesta();
                $query = "select * from $this->table";
                $result = parent::executeQuery($query);
                foreach ($result as $key => $value) {
                    $jurado = $this->setJurado($value);
                    $this->juradoList[] = $jurado->getJurado();
                }
                return $this->juradoList;
            } catch (Exception $e) {
                return $respuesta->error500(); 
            }
        }

        public function getJurado($id){
            try {
                $respuesta = new Respuesta();
                $query = "select * from $this->table where id = $id";
                $result = parent::executeQuery($query);
                $jurado = $this->setJurado($result[0]);
                return $jurado->getJurado();
            } catch (Exception $e) {
                return $respuesta->error500();
            }
        }

        public function getJuradoPagina($pagina = 1){
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
                    $jurado = $this->setJurado($value);
                    $this->juradoList[] = $jurado->getJurado();
                }
                return $this->juradoList;
            } catch (Exception $e) {
                return $respuesta->error500(); 
            }
        }

        public function saveJurado($data){
            try {
                $respuesta = new Respuesta();
                $jurado = json_decode($data, true);
                if(!$this->validateData($jurado)){
                    return $respuesta->error400();
                }
                $jurado = $this->setJurado($jurado);
                $query = "insert into $this->table (nombre, apellido, cedula, cargo, id_mesa) 
                            values 
                            (
                                '".$jurado->getNombre()."', 
                                '".$jurado->getApellido()."', 
                                '".$jurado->getCedula()."', 
                                '".$jurado->getCargo()."',
                                '".$jurado->getIdMesa()."'
                            )";
                $result = parent::executeNotQuery($query);
                if ($result) {
                    $response = $respuesta->response;
                    $response["result"] = array(
                        "message" => "Jurado guardado"
                    );
                    return $response;
                } else {
                    return $respuesta->error500();
                }
            } catch (Exception $e) {
                return $respuesta->error500(); 
            }
        }

        public function updateJurado($data){
            try {
                $respuesta = new Respuesta();
                $jurado = json_decode($data, true);
                if(!isset($jurado['id']) || !$this->validateData($jurado)){
                    return $respuesta->error400();
                }
                $jurado = $this->setJurado($jurado);
                $query = "update $this->table set
                            nombre = '".$jurado->getNombre()."', 
                            apellido = '".$jurado->getApellido()."',
                            cedula = '".$jurado->getCedula()."',
                            cargo = '".$jurado->getCargo()."',
                            id_mesa = '".$jurado->getIdMesa()."'
                            where id = ".$jurado->getId()."";
                $result = parent::executeNotQuery($query);
                if ($result) {
                    $response = $respuesta->response;
                    $response["result"] = array(
                        "message" => "Jurado actualizado"
                    );
                    return $response;
                } else {
                    return $respuesta->error500();
                }
            } catch (Exception $e) {
                return $respuesta->error500();
            }
        }

        public function deleteJurado($data){
            try {
                $respuesta = new Respuesta();
                $jurado = json_decode($data, true);
                if(!isset($jurado['id'])){
                    return $respuesta->error400();
                }
                $query = "delete from $this->table
                            where id = ".$jurado['id']."";
                $result = parent::executeNotQuery($query);
                if ($result) {
                    $response = $respuesta->response;
                    $response["result"] = array(
                        "message" => "Jurado eliminado"
                    );
                    return $response;
                } else {
                    return $respuesta->error500();
                }
            } catch (Exception $e) {
                return $respuesta->error500();
            }
        }

        private function setJurado($data){
            try {
                if(isset($data['id'])){
                    $jurado = new JuradoModel(
                        $data['nombre'], 
                        $data['apellido'], 
                        $data['cedula'],
                        $data['cargo'],
                        $data['id_mesa'],
                        $data['id']
                    );
                }else{
                    $jurado = new JuradoModel(
                        $data['nombre'], 
                        $data['apellido'], 
                        $data['cedula'],
                        $data['cargo'],
                        $data['id_mesa'],
                    );
                }
                return $jurado;
            } catch (Exception $e) {
                return false; 
            }
        }

        private function validateData($data){
            if(isset($data['nombre']) && 
                isset($data['apellido']) &&
                isset($data['cedula']) &&
                isset($data['cargo']) &&
                isset($data['id_mesa'])){
                    return true;
            }
            return false;
        }

    }

?>