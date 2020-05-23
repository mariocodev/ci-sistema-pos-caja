<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perfil extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('perfil_m');
        date_default_timezone_set("America/Asuncion");
    }

	public function index()
	{
		$this->load->model('auxiliar_m');
        foreach ($this->perfil_m->get_usuario()->result() as $row){
            if (!$usuario_foto = $row->usuario_foto){ 
                $usuario_foto = base_url('template/assets/images/').'avatar-2.jpg';
            }else{
                $usuario_foto = base_url('files/avatar/').$row->usuario_foto;
            }
            $data = array (
        		'usuario_id'		=> $row->usuario_id,
        		'usuario_nombre'    => $row->usuario_nombre,
        		'usuario_apellido'  => $row->usuario_apellido,
        		'usuario_user'		=> $row->usuario_user,
        		'usuario_foto'		=> $usuario_foto
        	);
        }
        $this->load->view('html/Head');
		$this->load->view('html/Nav', array(
										'model_menu' => $this->load->model('menu_m'), 
										'menus' => $this->menu_m->menu()
										));
		$data['error'] = $this->session->flashdata('error');
        $data['success'] = $this->session->flashdata('success');
        $this->load->view('section/Perfil_v', $data);
        $this->load->view('html/Footer');
	}

	function guardar(){
        $this->perfil_m->guardar();
        redirect ('perfil');		
	}
    function cambiar_pass(){
        if ($this->perfil_m->pass_anterior(md5($this->input->post('usuario_pass_actual')))){
            $this->perfil_m->cambiar_pass();
            $this->session->set_flashdata('success', 'Contraseña modificada.');
        }else{
            $this->session->set_flashdata('error', 'La contraseña actual no coincide.');
		}
        redirect ('perfil');
	}
    function crear_carpeta($carpeta, $permisos){
		if (!file_exists($carpeta)) {
		    mkdir($carpeta, $permisos, true);
		}
	}
    
    public function subir_foto(){
        //  Ruta donde se guardan los ficheros
        $carpeta = 'files/avatar/';
        $this->crear_carpeta($carpeta, 0777);
       
        //  Configuraciones
        $config['upload_path'] = $carpeta;
        $config['allowed_types'] = 'gif|jpg|png'; //Tipos de ficheros permitidos
        //$config['file_name'] = 'foto-perfil-'.$this->session->userdata('usuario_id').$config['file_ext'];
        
        //Cargamos la librería de subida y le pasamos la configuración
        $this->load->library('upload', $config);
 
        if(!$this->upload->do_upload()){
            redirect ('perfil');
        }else{
            // Eliminar foto anterior
            unlink($carpeta.$this->perfil_m->get_nombre_foto());
            
            $datos["img"]=$this->upload->data();
            // Podemos acceder a todas las propiedades del fichero subido
            $archivo_nombre = $datos["img"]["file_name"];
            
            $this->perfil_m->guardar_foto($archivo_nombre);
            //  Elimino el userdata de la foto
            $this->session->unset_userdata('usuario_foto');
            // set array of items in session
            //'usuario_foto'      => base_url('files/avatar/').$usuario->usuario_foto,
            $usuario_foto = array(
                    'usuario_foto'  => base_url('files/avatar/').$archivo_nombre
            );
            $this->session->set_userdata($usuario_foto);
 
            //Cargamos la vista y le pasamos los datos
            redirect ('perfil');
        }
    }  
}