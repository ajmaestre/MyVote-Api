
<?php

    class UsuarioModel{

        private $id;
        private $nombre;
        private $apellido;
        private $cedula;
        private $email;
        private $user_name;
        private $pass_word;
        private $rol;
        private $usuario = array();

        public function __construct($nombre, $apellido, $cedula, $email, $user_name, $pass_word, $rol, $id = -1) {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->apellido = $apellido;
            $this->cedula = $cedula;
            $this->email = $email;
            $this->user_name = $user_name;
            $this->pass_word = $pass_word;
            $this->rol = $rol;
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

        public function getEmail(){
            return $this->email;
        }

        public function getUsername(){
            return $this->user_name;
        }

        public function getPassword(){
            return $this->pass_word;
        }

        public function getRol(){
            return $this->rol;
        }

        public function getUsuario(){
            $this->usuario = array(
                                'id' => $this->id,
                                'nombre' => $this->nombre, 
                                'apellido' => $this->apellido, 
                                'cedula' => $this->cedula, 
                                'email' => $this->email,
                                'user_name' => $this->user_name,
                                'pass_word' => $this->pass_word,
                                'rol' => $this->rol
            );
            return $this->usuario;
        }

    }

?>