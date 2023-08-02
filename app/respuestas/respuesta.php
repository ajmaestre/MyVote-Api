
<?php 

    class Respuesta{

        public $response = [
            'status' => 'ok',
            'result' => array()
        ];

        public function error405(){
            $this->response['status'] = 'error';
            $this->response['result'] = array(
                'error_id' => '405',
                'error_msg' => 'Metodo invalido'
            );
            return $this->response;
        }

        public function error200($data = 'Datos incorrectos'){
            $this->response['status'] = 'error';
            $this->response['result'] = array(
                'error_id' => '200',
                'error_msg' => $data
            );
            return $this->response;
        }

        public function error400(){
            $this->response['status'] = 'error';
            $this->response['result'] = array(
                'error_id' => '400',
                'error_msg' => 'Datos enviados con formato incorrecto'
            );
            return $this->response;
        }

        public function error500($data = 'Error en el servidor'){
            $this->response['status'] = 'error';
            $this->response['result'] = array(
                'error_id' => '500',
                'error_msg' => $data
            );
            return $this->response;
        }

        public function error401($data = 'Acceso no autorizado'){
            $this->response['status'] = 'error';
            $this->response['result'] = array(
                'error_id' => '401',
                'error_msg' => $data
            );
            return $this->response;
        }

    }

?>