
<?php

    require_once '../database/consulta.php';
    require_once "../app/respuestas/respuesta.php";
    require_once "../app/models/puesto.php";

    
    class Puesto extends Consulta{

        private $table = 'puesto_myvote';
        private $puestoList = array();

        public function getPuestoLista(){
            try {
                $respuesta = new Respuesta();
                $query = "select * from $this->table";
                $result = parent::executeQuery($query);
                foreach ($result as $key => $value) {
                    $puesto = $this->setPuesto($value);
                    $this->puestoList[] = $puesto->getPuesto();
                }
                return $this->puestoList;
            } catch (Exception $e) {
                return $respuesta->error500(); 
            }
        }

        public function getPuesto($id){
            try {
                $respuesta = new Respuesta();
                $query = "select * from $this->table where id = $id";
                $result = parent::executeQuery($query);
                $puesto = $this->setPuesto($result[0]);
                return $puesto->getPuesto();
            } catch (Exception $e) {
                return $respuesta->error500();
            }
        }

        public function getPuestoPagina($pagina = 1){
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
                    $puesto = $this->setPuesto($value);
                    $this->puestoList[] = $puesto->getPuesto();
                }
                return $this->puestoList;
            } catch (Exception $e) {
                return $respuesta->error500(); 
            }
        }

        public function savePuesto($data){
            try {
                $respuesta = new Respuesta();
                $puesto = json_decode($data, true);
                if(!$this->validateData($puesto)){
                    return $respuesta->error400();
                }
                $puesto = $this->setPuesto($puesto);
                $query = "insert into $this->table (nombre, direccion, barrio, departamento, municipio) 
                                        values 
                                        (
                                            '".$puesto->getNombre()."',
                                            '".$puesto->getDireccion()."',
                                            '".$puesto->getBarrio()."',
                                            '".$puesto->getDepartamento()."',
                                            '".$puesto->getMunicipio()."'
                                        )";
                $result = parent::executeNotQuery($query);
                if ($result) {
                    $response = $respuesta->response;
                    $response["result"] = array(
                        "message" => "Puesto guardado"
                    );
                    return $response;
                } else {
                    return $respuesta->error500();
                }
            } catch (Exception $e) {
                return $respuesta->error500(); 
            }
        }

        public function updatePuesto($data){
            try {
                $respuesta = new Respuesta();
                $puesto = json_decode($data, true);
                if(!isset($puesto['id']) || !$this->validateData($puesto)){
                    return $respuesta->error400();
                }
                $puesto = $this->setPuesto($puesto);
                $query = "update $this->table set
                            nombre = '".$puesto->getNombre()."', 
                            direccion = '".$puesto->getDireccion()."', 
                            barrio = '".$puesto->getBarrio()."', 
                            departamento = '".$puesto->getDepartamento()."',
                            municipio = '".$puesto->getMunicipio()."'
                            where id = ".$puesto->getId()."";
                $result = parent::executeNotQuery($query);
                if ($result) {
                    $response = $respuesta->response;
                    $response["result"] = array(
                        "message" => "Puesto actualizado"
                    );
                    return $response;
                } else {
                    return $respuesta->error500();
                }
            } catch (Exception $e) {
                return $respuesta->error500();
            }
        }

        public function deletePuesto($data){
            try {
                $respuesta = new Respuesta();
                $puesto = json_decode($data, true);
                if(!isset($puesto['id'])){
                    return $respuesta->error400();
                }
                $query = "delete from $this->table
                            where id = ".$puesto['id']."";
                $result = parent::executeNotQuery($query);
                if ($result) {
                    $response = $respuesta->response;
                    $response["result"] = array(
                        "message" => "Puesto eliminado"
                    );
                    return $response;
                } else {
                    return $respuesta->error500();
                }
            } catch (Exception $e) {
                return $respuesta->error500();
            }
        }

        private function setPuesto($data){
            try {
                if(isset($data['id'])){
                    $puesto = new PuestoModel(
                        $data['nombre'], 
                        $data['direccion'], 
                        $data['barrio'],
                        $data['departamento'],
                        $data['municipio'],
                        $data['id']
                    );
                }else{
                    $puesto = new PuestoModel(
                        $data['nombre'], 
                        $data['direccion'], 
                        $data['barrio'],
                        $data['departamento'],
                        $data['municipio']
                    );
                }
                return $puesto;
            } catch (Exception $e) {
                return false; 
            }
        }

        private function validateData($data){
            if(isset($data['nombre']) && 
                isset($data['direccion']) && 
                isset($data['barrio']) && 
                isset($data['departamento']) &&
                isset($data['municipio'])){
                    return true;
            }
            return false;
        }

    }

?>