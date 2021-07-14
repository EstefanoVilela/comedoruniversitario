<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    public function validar($username, $password) {
        try {
            $query = $this->db->query("CALL up_coun_validarUsuario('$username', '$password', @code, @title, @message, @usuario);");

            if($query){
                $this->db->select('@code as code, @title as title, @message as message, @usuario as usuario', false);
                $rst = $this->db->get()->row_array();

                $success['code']    = $rst['code'];
                $success['title']   = $rst['title'];
                $success['message'] = $rst['message'];

                $fetchData = json_decode($rst['usuario']);
                $this->session->sess_usuario = $fetchData;
            }else{
                $success['code']    = 0;
                $success['title']   = 'Error';
                $success['message'] = 'No se pudo ejecutar la validación';

                $fetchData = null;
            }

            $this->db->close();
        } catch (\Throwable $th) {
            $success['code'] = 0;
            $success['title'] = 'Error';
            $success['message'] = $th->getMessage();
            $fetchData = null;
        }

        $res['success'] = $success;
        $res['fetchData'] = $fetchData;

        return $res;
    }
}
