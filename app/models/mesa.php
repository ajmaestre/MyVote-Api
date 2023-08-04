
<?php

    class MesaModel{

        private $id;
        private $numero;
        private $total_inscritos;
        private $votos;
        private $id_usuario;
        private $id_puesto;
        private $mesa = array();

        public function __construct($numero, $total_inscritos, $votos, $id_usuario, $id_puesto, $id = -1) {
            $this->id = $id;
            $this->numero = $numero;
            $this->total_inscritos = $total_inscritos;
            $this->votos = $votos;
            $this->id_usuario = $id_usuario;
            $this->id_puesto = $id_puesto;
        }

        public function getId(){
            return $this->id;
        }

        public function getNumero(){
            return $this->numero;
        }

        public function getTotalInscritos(){
            return $this->total_inscritos;
        }

        public function getVotos(){
            return $this->votos;
        }

        public function getIdUsuario(){
            return $this->id_usuario;
        }

        public function getIdPuesto(){
            return $this->id_puesto;
        }

        public function getMesa(){
            $this->mesa = array(
                                'id' => $this->id,
                                'numero' => $this->numero, 
                                'total_inscritos' => $this->total_inscritos, 
                                'votos' => $this->votos, 
                                'id_usuario' => $this->id_usuario, 
                                'id_puesto' => $this->id_puesto
            );
            return $this->mesa;
        }

    }

?>