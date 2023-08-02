
<?php

    include_once '.env';

    class conexion{

        private $url;
        public $conexion;

        public function __construct() {
            try {
                $datosLista = $_ENV['DATABASE_URL'];
                $this->conexion = pg_connect($datosLista);
            } catch (Exception $e) {
                return false;
            }
        }

        private function datosConexion(){
            $direccion = dirname(__DIR__);
            $jsondata = file_get_contents($direccion . "\\" . ".env");
            return json_decode($jsondata, true);
        }

    }

?>