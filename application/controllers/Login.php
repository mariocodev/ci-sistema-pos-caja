<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
   public function __construct() {
      parent::__construct();
	  $this->load->model('login_m');
   }
	public function index(){
		if($this->session->logueado){
          redirect('usuarios');
		}
		$data = array();
		$data['error'] = $this->session->flashdata('error');
		$data['controller'] = 'admin/' . strtolower($this->router->class);		
		$data['archivoJS']	= ucfirst($this->router->class);
		
		$this->load->view('html/Head');
		$this->load->view('admin/Login_v', $data);
		$this->load->view('html/Footer');
	}
	/*public function perfiles(){
		foreach ($this->login_m->obtener_perfiles(21) as $perfil){
			echo $perfil->perfil_id;
		}
	}*/
	public function iniciar_sesion_post() {
		if ($this->input->post()) {
			$usuario_user  = $this->input->post('usuario_user');
			$usuario_pass  = md5($this->input->post('usuario_pass'));
			$usuario = $this->login_m->obtener_usuario($usuario_user, $usuario_pass);
			if ($usuario) {
                if (!$usuario_foto = $usuario->usuario_foto){ 
                    $usuario_foto = base_url('template/assets/images/').'avatar-2.jpg';
                }else{
                    $usuario_foto = base_url('files/avatar/').$usuario->usuario_foto;
                }
                
				$usuario_data = array(
					'usuario_id'        => $usuario->usuario_id,
					'usuario_user'      => $usuario->usuario_user,
					'usuario_estado'    => $usuario->usuario_estado,
					'usuario_foto'      => $usuario_foto,
					'logueado'          => TRUE
				);
				$this->session->set_userdata($usuario_data);
				//var_dump($usuario_data);
				//redirect('Welcome');
				echo json_encode(array(
					"status" => TRUE
				));
            } else {
            $this->session->set_flashdata('error', 'El usuario o la contraseña son incorrectos.');
            $this->index();
         }
      } else {
         $this->index();
      }
   }   
   public function cerrar_sesion() {
      $this->session->sess_destroy();        
      redirect('');
   }
}