
<?php

    class PuestoModel{

        private $id;
        private $nombre;
        private $direccion;
        private $barrio;
        private $departamento;
        private $municipio;
        private $puesto = array();

        public function __construct($nombre, $direccion, $barrio, $departamento, $municipio, $id = -1) {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->direccion = $direccion;
            $this->barrio = $barrio;
            $this->departamento = $departamento;
            $this->municipio = $municipio;
        }

        public function getId(){
            return $this->id;
        }

        public function getNombre(){
            return $this->nombre;
        }

        public function getDireccion(){
            return $this->direccion;
        }

        public function getBarrio(){
            return $this->barrio;
        }

        public function getDepartamento(){
            return $this->departamento;
        }

        public function getMunicipio(){
            return $this->municipio;
        }

        public function getPuesto(){
            $this->puesto = array(
                                'id' => $this->id,
                                'nombre' => $this->nombre, 
                                'direccion' => $this->direccion, 
                                'barrio' => $this->barrio, 
                                'departamento' => $this->departamento,
                                'municipio' => $this->municipio
            );
            return $this->puesto;
        }

    }

?>