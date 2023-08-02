
<?php

    class conexion{

        private $url;
        public $conexion;

        public function __construct() {
            try {
                $datosLista = $this->datosConexion();
                foreach ($datosLista as $key => $value) {
                    $this->url = $value["url"];
                }
                $this->conexion = pg_connect($this->url);
            } catch (Exception $e) {
                return false;
            }
        }

        private function datosConexion(){
            $direccion = dirname(__FILE__);
            $jsondata = file_get_contents($direccion . "/" . "config");
            return json_decode($jsondata, true);
        }

    }

?>