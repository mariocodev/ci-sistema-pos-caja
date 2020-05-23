<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Planes extends CI_Controller {
	public function __construct() {
        parent::__construct();        
        $this->load->model('crear_menu_m');
        $this->load->model('planes_m');
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
		$this->load->view('section/Planes_v', $data);
		$this->load->view('html/Footer');
	}
    function datatable_datos()
    {
        $fetch_data = $this->planes_m->make_datatables();
        
        $data       = array();
        foreach ($fetch_data as $row) {
            $sub_array   = array();
            $sub_array[] = $row->plan_id;            
            $sub_array[] = $row->plan_categoria_nombre;            
            $sub_array[] = $row->plan_rango_edad_nombre;
            $sub_array[] = $row->planes_costo;
            $sub_array[] = $row->plan_vigencia_nombre;
            $sub_array[] = $row->plan_rango_limite;
            $data[]      = $sub_array;
        }
        $output = array(
            "draw"              => intval($this->input->post("draw")),
            "recordsTotal"      => $this->planes_m->get_all_data(),
            "recordsFiltered"   => $this->planes_m->get_filtered_data(),
            "data"              => $data
        );
        if(!isset($headers)){
            $headers='Content-type:application/json';
        }
        header($headers);
        echo json_encode($output, JSON_PRETTY_PRINT);
    }
	/*****
	*
	*	ABM
	*
	*/
	public function agregar(){
        $data = array(
            'plan_categoria_id'  => $this->input->post('plan_categoria_id'),
            'plan_rango_edad_id' => $this->input->post('plan_rango_edad_id'),
            'planes_costo'       => $this->input->post('planes_costo')
        );
        $insert = $this->planes_m->agregar($data);
        echo json_encode(array("status" => TRUE));
    }
    
	public function editar($id){
        $data = $this->planes_m->obtener_por_id($id);
        echo json_encode($data);
    }

	public function actualizar()
    {
        $data = array(
            //'plan_id'           => $this->input->post('plan_id'),
            'plan_categoria_id'  => $this->input->post('plan_categoria_id'),
			'plan_rango_edad_id' => $this->input->post('plan_rango_edad_id'),
			'planes_costo'       => $this->input->post('planes_costo')
        );
        $this->planes_m->update(
            array('plan_id'  => $this->input->post('plan_id')),
            $data);
        echo json_encode(array("status" => TRUE));
    }

	public function eliminar($id){
        $this->crear_menu_m->eliminar_por_id($id);
        echo json_encode(array("status" => TRUE));
    }
    /**********************
    *   Pequeños ABM
    *   Categoría
    *
    **/
    public function agregar_categoria(){
        $data = array(
            'plan_categoria_nombre' => $this->input->post('plan_categoria_nombre')
        );
        $insert = $this->planes_m->agregar_categoria($data);
        echo json_encode(array("status" => TRUE));
    }
    public function categoria_editar($id){
        $data = $this->planes_m->categoria_editar($id);
        echo json_encode($data);
    }
    public function categoria_actualizar()
    {
        $this->planes_m->categoria_actualizar(
            array('plan_categoria_id'       => $this->input->post('plan_categoria_id')),
            array('plan_categoria_nombre'   => $this->input->post('plan_categoria_nombre'))
        );
        echo json_encode(array("status" => TRUE));
    }

    /***
    *
    *   Rango edad
    */
    public function rango_edad_agregar(){
        $data = array(
            'plan_rango_edad_nombre'        => $this->input->post('planes_rango_limite_inferior').' a '.$this->input->post('planes_rango_limite_superior').' años',
            'planes_rango_limite_inferior'  => $this->input->post('planes_rango_limite_inferior'),
            'planes_rango_limite_superior'  => $this->input->post('planes_rango_limite_superior'),
            'plan_vigencia_id'              => $this->input->post('plan_vigencia_id')
        );
        $insert = $this->planes_m->rango_edad_agregar($data);
        echo json_encode(array("status" => TRUE));
    }
    public function rango_edad_editar($id){
        $data = $this->planes_m->rango_edad_editar($id);
        echo json_encode($data);
    }
    public function rango_edad_actualizar()
    {
        $data = array(
            'plan_rango_edad_nombre'        => $this->input->post('planes_rango_limite_inferior').' a '.$this->input->post('planes_rango_limite_superior').' años',
            'planes_rango_limite_inferior' => $this->input->post('planes_rango_limite_inferior'),
            'planes_rango_limite_superior' => $this->input->post('planes_rango_limite_superior'),
            'plan_vigencia_id'              => $this->input->post('plan_vigencia_id')
        );
        $this->planes_m->rango_edad_actualizar(
            array('plan_rango_edad_id'  => $this->input->post('plan_rango_edad_id')),
            $data);
        echo json_encode(array("status" => TRUE));
    }

    /*****
    *
    *   Call AJAX
    */
    public function planes_categorias($plan_id){
        foreach ($this->planes_m->listar_planes_categoria($plan_id) as $row) {
            echo '<option value="'.$row->plan_categoria_id.'" '.$row->selected.'>'.$row->plan_categoria_id.'. '.$row->plan_categoria_nombre.'</option>';
        }
    }
    public function planes_rango_edad($plan_id){
        foreach ($this->planes_m->listar_planes_rango_edad($plan_id) as $row) {
            echo '<option value="'.$row->plan_rango_edad_id.'" '.$row->selected.'>'.$row->plan_rango_edad_nombre.'</option>';
        }
    }
    public function planes_vigencia($plan_rango_edad_id){
        foreach ($this->planes_m->listar_planes_vigencia($plan_rango_edad_id) as $row) {
            echo '<option value="'.$row->plan_vigencia_id.'" '.$row->selected.'>'.$row->plan_vigencia_id.'. '.$row->plan_vigencia_nombre.' - '.$row->plan_vigencia_dias.' días</option>';
        }
    }
}
