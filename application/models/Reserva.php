<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reserva extends CI_Model{        
    public function save($id_horario){
        try {
            $alumno = $this->session->sess_usuario;
            $id_alumno = $alumno->id_alumno;

            $query = $this->db->query("CALL up_coun_guardarReserva($id_horario, $id_alumno, @code, @title, @message, @reservas);");

            if($query){
                $this->db->select('@code as code, @title as title, @message as message, @reservas as reservas', false);
                $rst = $this->db->get()->row_array();
                $success['code']    = $rst['code'];
                $success['title']   = $rst['title'];
                $success['message'] = $rst['message'];

                $fetchData['reservas']  = json_decode($rst['reservas']);

                // CARGAR NUEVO LISTADO DE RESERVAS A LA SESSIÓN
                $config = $this->session->sess_config;         # traemos config de la sessión
                $config['reservas'] = $fetchData['reservas'];  # actualizamos la llave reservas
                $this->session->sess_config = $config;         # actualizamos config en la sessión
            }else{
                $success['code'] = 0;
                $success['title'] = 'Upsss...';
                $success['message'] = 'No pudo realizarse la reserva.';
                $fetchData = null;
            }
            // $this->db->close();
        } catch (\Throwable $th) {
            $success['code'] = -1;
            $success['title'] = 'Error';
            $success['message'] = $th->getMessage();
            $fetchData = null;
        }

        $res['success'] = $success;
        $res['fetchData'] = $fetchData;

        return $res;
    }
    
    public function delete(){
        try{   
            $alumno = $this->session->sess_usuario;
            $id_alumno = $alumno->id_alumno;

            $query = $this->db->query("CALL up_coun_eliminarReservar($id_alumno, @code, @title, @message, @horarios, @reservas);");

            if($query){
                $this->db->select('@code code, @title title, @message message, @horarios horarios, @reservas reservas', false);
                $rst = $this->db->get()->row_array();

                $success['code']    = $rst['code'];
                $success['title']   = $rst['title'];
                $success['message'] = $rst['message'];

                $fetchData['reservas']  = json_decode($rst['reservas']);
                $fetchData['horarios']  = json_decode($rst['horarios']);

                // CARGAR NUEVO LISTADO DE RESERVAS A LA SESSIÓN
                $config = $this->session->sess_config;         # traemos config de la sessión
                $config['reservas'] = $fetchData['reservas'];  # actualizamos la llave reservas
                $this->session->sess_config = $config;         # actualizamos config en la sessión
            }else{
                $success['code'] = 0;
                $success['title'] = 'Upsss...';
                $success['message'] = 'No pudo realizarse la reserva.';
                $fetchData = null;
            }
        } catch (\Throwable $th) {
            $success['code'] = -1;
            $success['title'] = 'Error';
            $success['message'] = $th->getMessage();;
            $fetchData = null;
        }
        
        $res['success'] = $success;
        $res['fetchData'] = $fetchData;

        return $res;
    }

    /* ========== RECURSOS ========== */
    public function getConfig(){
        try {
            $config = $this->session->sess_config;

            if(isset($config)){ # ¿Existe config en la sessión?
                $success['code'] = 1;
                $success['title'] = 'Sessión';
                $success['message'] = 'Los datos ya existían en la sessión!';
                $fetchData = $config;
            }else{ # Si no existe, lo vamos a pedir a la BBDD
                $alumno = $this->session->sess_usuario;
                $id = $alumno->id_alumno;

                $query = $this->db->query("CALL up_coun_getConfig($id, @code, @title, @message, @ayudas, @dias, @horarios, @comidas, @reservas);");
                if($query){
                    $this->db->select('@code code, @title title, @message message, @ayudas ayudas, @dias dias, @horarios horarios, @comidas comidas, @reservas reservas;', false);
                    $rst = $this->db->get()->row_array();

                    $success['code']    = $rst['code'];
                    $success['title']   = $rst['title'];
                    $success['message'] = $rst['message'];

                    $fetchData['ayudas']   = json_decode($rst['ayudas'], false);
                    $fetchData['dias']     = json_decode($rst['dias'], false);
                    $fetchData['horarios'] = json_decode($rst['horarios'], false);
                    $fetchData['comidas']  = json_decode($rst['comidas'], false);
                    $fetchData['reservas']  = json_decode($rst['reservas'], false);

                    $this->session->sess_config = $fetchData;
                }else{
                    $success['code'] = 0;
                    $success['title'] = 'Upsss...';
                    $success['message'] = 'No se pudo conseguir la configuración del sistema.';
                    $fetchData = null;
                }
                $this->db->close();
            }
        } catch (\Throwable $th) {
            $success['code'] = -1;
            $success['title'] = 'Exception: Reserva(getConfig)';
            $success['message'] = $th->getMessage();
            $fetchData = null;
        }

        $res['success'] = $success;
        $res['fetchData'] = $fetchData;

        return $res;
    }

    public function getHabilitacion(){
        date_default_timezone_set("America/Lima");
        $res['hora'] = date("H");
        // $res['hora'] = 9;

        if ($res['hora'] >= 9 & $res['hora'] <= 10) {
            $config = $this->session->sess_config;
            $reservas = $config['reservas'];
            $cont = 0;

            if($reservas){
                foreach($reservas as $r){
                    if($r->id_atencion == 2){
                        $cont++;
                    }
                }
            }

            if($cont == 0){
                $res['code'] = 0;
                $res['title'] = 'Bien';
                $res['message'] = 'NO se ha encontrado una reserva.';
                $res['permitido'] = 1; # TRUE -> Sí se permite hacer una reserva
            }else{
                $res['code'] = 1;
                $res['title'] = 'Advertencia';
                $res['message'] = 'Ya existe una reserva para este código';
                $res['logs'] = "Se ha encontrado $cont reservas.";
                $res['boton'] = '<button type="button" onclick="eliminar()" class="btn btn-danger">Cancelar Reserva</button>';
                $res['permitido'] = 0; # FALSE -> NO se permite hacer reservas
            }
        } else {
            $res['code'] = 0;
            $res['title'] = 'Advertencia';
            $res['message'] = 'El servicio aún no está habilitado.';
            $res['permitido'] = 0; # FALSE -> NO se permite hacer reservas
        }

        return $res;
    }
}