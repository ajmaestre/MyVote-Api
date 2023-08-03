
<?php

    require_once "conexion.php";

    
    class Consulta extends conexion{

        public function __construct() {
            try {
                parent::__construct();                
            } catch (\Throwable $th) {
                return false;
            }
        }

        private function toUTF8($array){
            array_walk_recursive($array, function(&$item, $key){
                if(!mb_detect_encoding($item, 'utf-8', true)){
                    $item = utf8_encode($item);
                }
            });
            return $array;
        }

        public function executeQuery($query){
            try {
                $result = pg_query($this->conexion, $query);
                $resultArray = array();
                while ($row = pg_fetch_assoc($result)) {
                    $resultArray[] = $row;
                }
                return $this->toUTF8($resultArray);
            } catch (Exception $e) {
                return false;
            }
        }

        public function executeNotQuery($query){
            try {
                $result = pg_query($this->conexion, $query);
                return $result;
            } catch (Exception $e) {
                return false;
            }
        }

        protected function encriptPassword($password){
            try{
                return md5($password);
            }catch(Exception $e){
                return false;
            }
        }

    }

?>