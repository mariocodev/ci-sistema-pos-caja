<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Timbrado extends CI_Controller {
	public function __construct() {
        parent::__construct();        
        $this->load->model('crear_menu_m');
        $this->load->model('timbrado_m');
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
		$this->load->view('section/Timbrado_v', $data);
		$this->load->view('html/Footer');
	}
    function datatable_datos()
    {
        $fetch_data = $this->timbrado_m->make_datatables();
        
        $data       = array();
        foreach ($fetch_data as $row) {
            $sub_array   = array();
            $sub_array[] = $row->timbrado_id;            
            $sub_array[] = $row->nro_timbrado;            
            $sub_array[] = $row->fecha_desde;
            $sub_array[] = $row->fecha_hasta;
            $sub_array[] = $row->estado;
            $data[]      = $sub_array;
        }
        $output = array(
            "draw"              => intval($this->input->post("draw")),
            "recordsTotal"      => $this->timbrado_m->get_all_data(),
            "recordsFiltered"   => $this->timbrado_m->get_filtered_data(),
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
        $data = $this->timbrado_m->getAll();
        echo json_encode($data);
    }
	/*****
	*
	*	ABM
	*
	*/
	public function agregar(){
        $data = array(
            'nro_timbrado'  => $this->input->post('nro_timbrado'),
			'fecha_desde'   => $this->input->post('fecha_desde'),
			'fecha_hasta'   => $this->input->post('fecha_hasta'),
            'estado'        => $this->input->post('estado')
        );
        $insert = $this->timbrado_m->add($data);
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
        $data = $this->timbrado_m->getbyId($id);
        echo json_encode($data);
    }

	public function actualizar()
    {
        $data = array(
            'nro_timbrado'  => $this->input->post('nro_timbrado'),
			'fecha_desde'   => $this->input->post('fecha_desde'),
			'fecha_hasta'   => $this->input->post('fecha_hasta'),
            'estado'        => $this->input->post('estado')
        );
        $this->timbrado_m->update(
            array('timbrado_id'  => $this->input->post('timbrado_id')),
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

    public function eliminar($id){
        $this->timbrado_m->update(
            array('timbrado_id' => $id),
            array('estado'      => 2)
        );
        echo json_encode(
            array(
                "status"    => TRUE,
                "code"      => 200,
                "tipo"      => "success",
                "message"   => "Eliminado correctamente."
            )
        );
    }

    // Eliminado físico
	public function delete($id){
        $this->timbrado_m->delete($id);
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