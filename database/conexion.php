
<?php

    class conexion{

        private $url;
        public $conexion;

        public function __construct() {
            try {
                $urlConexion = $_ENV['DATABASE_URL'];
                $this->conexion = pg_connect($urlConexion);
            } catch (Exception $e) {
                return false;
            }
        }

    }

?>