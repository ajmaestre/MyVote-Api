
<?php

    class conexion{

        private $url;
        public $conexion;

        public function __construct() {
            try {
                $datosLista = $_ENV['DATABASE_URL'];
                $this->conexion = pg_connect("postgres://admin:4U9SpzKXDDp2cH8w588DX46SGABuZpt0@dpg-cim6hotgkuvinfmj3l50-a.oregon-postgres.render.com/enginerds_db");
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