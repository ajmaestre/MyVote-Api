
<?php

    class JuradoModel{

        private $id;
        private $nombre;
        private $apellido;
        private $cedula;
        private $cargo;
        private $id_mesa;
        private $jurado = array();

        public function __construct($nombre, $apellido, $cedula, $cargo, $id_mesa, $id = -1) {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->apellido = $apellido;
            $this->cedula = $cedula;
            $this->cargo = $cargo;
            $this->id_mesa = $id_mesa;
        }

        public function getNombre(){
            return $this->nombre;
        }

        public function getId(){
            return $this->id;
        }

        public function getApellido(){
            return $this->apellido;
        }

        public function getCedula(){
            return $this->cedula;
        }

        public function getCargo(){
            return $this->cargo;
        }

        public function getIdMesa(){
            return $this->id_mesa;
        }

        public function getJurado(){
            $this->jurado = array(
                                'id' => $this->id,
                                'nombre' => $this->nombre, 
                                'apellido' => $this->apellido, 
                                'cedula' => $this->cedula, 
                                'cargo' => $this->cargo,
                                'id_mesa' => $this->id_mesa
            );
            return $this->jurado;
        }

    }

?>