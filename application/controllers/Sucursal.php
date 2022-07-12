<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sucursal extends CI_Controller {
	public function __construct() {
        parent::__construct();        
        $this->load->model('sucursal_m');
        $this->load->model('auxiliar_m');
	}
	
	public function index() {
		$data['breadcrumb']  = $this->auxiliar_m->breadcrumb($this->router->class);
        $this->load->view('html/Head');
		$this->load->view('html/Nav', array(
										'model_menu' => $this->load->model('menu_m'), 
										'menus' => $this->menu_m->menu()
										));
        $this->load->view('html/Breadcrumb_v', $data);
		$this->load->view('section/Sucursal_v', $data);
		$this->load->view('html/Footer');
	}

	function datatable_datos()
    {
        $fetch_data = $this->sucursal_m->make_datatables();
        
        $data       = array();
        foreach ($fetch_data as $row) {
            $sub_array   = array();
            $sub_array[] = $row->sucursal_id;            
            $sub_array[] = $row->sucursal_descripcion;            
            $sub_array[] = $row->sucursal_direccion;
            $sub_array[] = $row->sucursal_telefono;
            $sub_array[] = $row->sucursal_ruc;
            $data[]      = $sub_array;
        }
        $output = array(
            "draw"              => intval($this->input->post("draw")),
            "recordsTotal"      => $this->sucursal_m->get_all_data(),
            "recordsFiltered"   => $this->sucursal_m->get_filtered_data(),
            "data"              => $data
        );
        if(!isset($headers)){
            $headers='Content-type:application/json';
        }
        header($headers);
        echo json_encode($output, JSON_PRETTY_PRINT);
    }

    public function getAll()
    {
        $data = $this->sucursal_m->getAll();
        echo json_encode($data);
    }
	/*****
	*
	*	ABM
	*
	*/
	public function agregar(){
        $data = array(
            'sucursal_descripcion'	=> $this->input->post('sucursal_descripcion'),
			'sucursal_direccion'	=> $this->input->post('sucursal_direccion'),
			'sucursal_telefono'		=> $this->input->post('sucursal_telefono'),
            'sucursal_ruc'			=> $this->input->post('sucursal_ruc'),
			'sucursal_central'		=> $this->input->post('sucursal_central')
        );
        $insert = $this->sucursal_m->add($data);
        echo json_encode(
            array(
                "status"    => TRUE,
                "code"      => 200,
                "tipo"      => "success",
                "message"   => "Agregado correctamente."
            )
        );
    }
    
	public function editar($id){
        $data = $this->sucursal_m->getbyId($id);
        echo json_encode($data);
    }

	public function actualizar()
    {
        $data = array(
            'sucursal_descripcion'	=> $this->input->post('sucursal_descripcion'),
			'sucursal_direccion'	=> $this->input->post('sucursal_direccion'),
			'sucursal_telefono'		=> $this->input->post('sucursal_telefono'),
            'sucursal_ruc'			=> $this->input->post('sucursal_ruc'),
			'sucursal_central'		=> $this->input->post('sucursal_central')
        );
        $this->sucursal_m->update(
            array('sucursal_id'  => $this->input->post('sucursal_id')),
            $data);
        echo json_encode(
            array(
                "status"    => TRUE,
                "code"      => 200,
                "tipo"      => "success",
                "message"   => "Actualizado correctamente."
            )
        );
    }

    // Eliminado físico
	public function delete($id){
        $this->sucursal_m->delete($id);
        echo json_encode(
            array(
                "status"    => TRUE,
                "code"      => 200,
                "tipo"      => "success",
                "message"   => "Eliminado correctamente."
            )
        );
    }

}