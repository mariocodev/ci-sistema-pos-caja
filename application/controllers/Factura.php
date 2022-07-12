<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *  Class Factura
 *
 *  ABM de factura
 *  https://stackoverflow.com/questions/21876224/create-an-optgroup-from-an-array-of-data
 *  https://github.com/tomsta93/Countries-drop-down-Codeigniter/wiki/Countries-drop-down-helper-Codeigniter
 *
 *  @package application/controllers/factura
 *  @author  seto  
 */
class Factura extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('factura_m');
        $this->load->model('auxiliar_m');
        date_default_timezone_set("America/Asuncion");
    }

    public function index()
    {
        $this->load->model('menu_m');
        
        $data['breadcrumb']  = $this->auxiliar_m->breadcrumb($this->router->class);

        $this->load->view('html/Head');
        $this->load->view('html/Nav', array(
            'model_menu'=> $this->load->model('menu_m'),
            'menus'     => $this->menu_m->menu()
        ));
        $this->load->view('html/Breadcrumb_v', $data);
        $this->load->view('section/Factura_v', $data);
        $this->load->view('html/Footer');
    }
    
    function datatable_datos()
    {
        $fetch_data = $this->factura_m->make_datatables();
        
        $data       = array();
        foreach ($fetch_data as $row) {
            $sub_array   = array();
            $sub_array[] = $row->factura_id;
            $sub_array[] = $row->nro_timbrado;
            $sub_array[] = $row->nro_desde;
            $sub_array[] = $row->nro_hasta;
            $sub_array[] = $row->nro_actual;
            $sub_array[] = $row->sucursal_descripcion;
            $sub_array[] = $row->estado;
            $data[]      = $sub_array;
        }
        $output = array(
            "draw"              => intval($this->input->post("draw")),
            "recordsTotal"      => $this->factura_m->get_all_data(),
            "recordsFiltered"   => $this->factura_m->get_filtered_data(),
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
            'timbrado_id'   => $this->input->post('timbrado_id'),
			'nro_desde'     => $this->input->post('nro_desde'),
			'nro_hasta'     => $this->input->post('nro_hasta'),
            'nro_actual'    => $this->input->post('nro_actual'),
            'estado'        => $this->input->post('estado'),
            'sucursal_id'   => $this->input->post('sucursal_id'),
            'estado'        => $this->input->post('estado')
        );
        $insert = $this->factura_m->add($data);
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
        $data = $this->factura_m->getbyId($id);
        echo json_encode($data);
    }

	public function actualizar()
    {
        $data = array(
            'timbrado_id'   => $this->input->post('timbrado_id'),
			'nro_desde'     => $this->input->post('nro_desde'),
			'nro_hasta'     => $this->input->post('nro_hasta'),
            'estado'        => $this->input->post('estado'),
            'sucursal_id'   => $this->input->post('sucursal_id'),
            'estado'        => $this->input->post('estado')
        );
        $this->factura_m->update(
            array('factura_id'  => $this->input->post('factura_id')),
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
        $this->factura_m->update(
            array('factura_id' => $id),
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

}