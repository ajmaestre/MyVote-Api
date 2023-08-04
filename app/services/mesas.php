
<?php

    require_once '../database/consulta.php';
    require_once "../app/respuestas/respuesta.php";
    require_once "../app/models/mesa.php";

    
    class Mesa extends Consulta{

        private $table = 'mesa_myvote';
        private $mesaList = array();

        public function getMesaLista(){
            try {
                $respuesta = new Respuesta();
                $query = "select * from $this->table";
                $result = parent::executeQuery($query);
                foreach ($result as $key => $value) {
                    $mesa = $this->setMesa($value);
                    $this->mesaList[] = $mesa->getMesa();
                }
                return $this->mesaList;
            } catch (Exception $e) {
                return $respuesta->error500(); 
            }
        }

        public function getMesa($id){
            try {
                $respuesta = new Respuesta();
                $query = "select * from $this->table where id = $id";
                $result = parent::executeQuery($query);
                $mesa = $this->setMesa($result[0]);
                return $mesa->getMesa();
            } catch (Exception $e) {
                return $respuesta->error500();
            }
        }

        public function getMesaPagina($pagina = 1){
            try {
                $respuesta = new Respuesta();
                $inicio = 0;
                $cantidad = 50;
                if($pagina > 1){
                    $inicio = ($cantidad * ($pagina - 1)) + 1;
                    $cantidad = $cantidad * $pagina;
                }
                $query = "select * from $this->table limit $cantidad offset $inicio";
                $result = parent::executeQuery($query);
                foreach ($result as $key => $value) {
                    $mesa = $this->setMesa($value);
                    $this->mesaList[] = $mesa->getMesa();
                }
                return $this->mesaList;
            } catch (Exception $e) {
                return $respuesta->error500(); 
            }
        }

        public function saveMesa($data){
            try {
                $respuesta = new Respuesta();
                $mesa = json_decode($data, true);
                if(!$this->validateData($mesa)){
                    return $respuesta->error400();
                }
                $mesa = $this->setMesa($mesa);
                $query = "insert into $this->table (numero, total_inscritos, id_usuario, id_puesto) 
                                        values 
                                        (
                                            '".$mesa->getNumero()."',
                                            '".$mesa->getTotalInscritos()."',
                                            '".$mesa->getIdUsuario()."',
                                            '".$mesa->getIdPuesto()."'
                                        )";
                $result = parent::executeNotQuery($query);
                if ($result) {
                    $response = $respuesta->response;
                    $response["result"] = array(
                        "message" => "Mesa guardada"
                    );
                    return $response;
                } else {
                    return $respuesta->error500();
                }
            } catch (Exception $e) {
                return $respuesta->error500(); 
            }
        }

        public function updateMesa($data){
            try {
                $respuesta = new Respuesta();
                $mesa = json_decode($data, true);
                if(!isset($mesa['id']) || !$this->validateData($mesa)){
                    return $respuesta->error400();
                }
                $mesa = $this->setMesa($mesa);
                $query = "update $this->table set
                            numero = '".$mesa->getNumero()."', 
                            total_inscritos = '".$mesa->getTotalInscritos()."',
                            id_usuario = '".$mesa->getIdUsuario()."',
                            id_puesto = '".$mesa->getIdPuesto()."'
                            where id = ".$mesa->getId()."";
                $result = parent::executeNotQuery($query);
                if ($result) {
                    $response = $respuesta->response;
                    $response["result"] = array(
                        "message" => "Mesa actualizada"
                    );
                    return $response;
                } else {
                    return $respuesta->error500();
                }
            } catch (Exception $e) {
                return $respuesta->error500();
            }
        }

        public function addVotes($id, $data){
            try {
                $respuesta = new Respuesta();
                $data = json_decode($data, true);
                if(!$id || !isset($data['votos'])){
                    return $respuesta->error400();
                }
                $mesa = $this->getMesa($id);
                $data['votos'] += $mesa['votos'];
                $query = "update $this->table set
                            votos = ".$data['votos']."
                            where id = ".$id."";
                $result = parent::executeNotQuery($query);
                if ($result) {
                    $response = $respuesta->response;
                    $response["result"] = array(
                        "message" => "Votos agregados"
                    );
                    return $response;
                } else {
                    return $respuesta->error500();
                }
            } catch (Exception $e) {
                return $respuesta->error500();
            }
        }
        
        public function deleteMesa($id){
            try {
                $respuesta = new Respuesta();
                $query = "delete from $this->table
                            where id = ".$id."";
                $result = parent::executeNotQuery($query);
                if ($result) {
                    $response = $respuesta->response;
                    $response["result"] = array(
                        "message" => "Mesa eliminada"
                    );
                    return $response;
                } else {
                    return $respuesta->error500();
                }
            } catch (Exception $e) {
                return $respuesta->error500();
            }
        }

        private function setMesa($data){
            try {
                if(isset($data['id'])){
                    $mesa = new MesaModel(
                        $data['numero'], 
                        $data['total_inscritos'], 
                        $data['id_usuario'],
                        $data['id_puesto'],
                        $data['id']
                    );
                }else{
                    $mesa = new MesaModel(
                        $data['numero'], 
                        $data['total_inscritos'], 
                        $data['id_usuario'],
                        $data['id_puesto']
                    );
                }
                return $mesa;
            } catch (Exception $e) {
                return false; 
            }
        }

        private function validateData($data){
            if(isset($data['numero']) && 
                isset($data['total_inscritos']) && 
                isset($data['id_usuario']) &&
                isset($data['id_puesto'])){
                    return true;
            }
            return false;
        }

    }

?>