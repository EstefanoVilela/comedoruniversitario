<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Comedor_Inicio extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('Login');
        $this->load->model('Reserva');
        $this->load->library('twig'); // Can also be autoloaded
    }

    # VER LA SESSIÓN
    public function a() {
        // echo json_encode($this->session);
        // $config = $this->Reserva->getConfig();
        // echo json_encode($config);

        $h = $this->Reserva->getHabilitacion();
        echo json_encode($h);
    }

    # CORRER LOGIN/HOME
    public function index() {
        $var_usuario = $this->session->sess_usuario;

        if (isset($var_usuario)) { # Hay una sesión
            // TRAER LAS CONFIGURACIONES
            $config = $this->Reserva->getConfig(); # DB
            $success = $config['success'];

            if($success['code'] == 1){
                $data = $config['fetchData']; # MANDAR EL FETCHDATA A LA VISTA

                # Saber si hay habilitación
                $habilitado = $this->Reserva->getHabilitacion();
                $data['hab'] = $habilitado;

                $data['flg'] = 1;
                $data['title'] = '.:: Bienvenido ::.';

                $data['alumno'] = $var_usuario; # CONSEGUIR LOS DATOS DE LOS ALUMNOS
                // echo json_encode($data);
                echo $this->twig->render('Comedor/layouts/home.twig', $data);
            }else{
                echo json_encode($success);
            }
        } else { # No hay sesión
            $data['flg'] = 0;
            $data['title'] = '.:: Login ::.';
            echo $this->twig->render('Comedor/layouts/login.twig', $data);
        }
    }

    # validación para cargar la información del alumno
    public function validar() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $res = $this->Login->validar($username, $password);
        echo json_encode($res);
    }

    # GENERAR UNA RESERVA
    public function reservar(){
        $id_horario = $this->input->post('id_horario');
        $res = $this->Reserva->save($id_horario);
        $res['hab'] = $this->Reserva->getHabilitacion();
        echo json_encode($res);
    }
    
    # ELIMINAR RESERVA
    public function eliminar(){
        $res = $this->Reserva->delete();
        echo json_encode($res);
    }

    # CERRAR SESIÓN
    public function logout(){
        $this->session->sess_destroy();
        redirect('/');
    }
}
