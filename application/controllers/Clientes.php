<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *  Class Usuarios
 *
 *  ABM de usuarios
 *  https://stackoverflow.com/questions/21876224/create-an-optgroup-from-an-array-of-data
 *  https://github.com/tomsta93/Countries-drop-down-Codeigniter/wiki/Countries-drop-down-helper-Codeigniter
 *
 *  @package application/controllers/usuarios
 *  @author  seto  
 */
class Clientes extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('clientes_m');
        $this->load->model('auxiliar_m');
        date_default_timezone_set("America/Asuncion");
    }

    public function index()
    {
        $this->load->model('menu_m');
        
        $data['breadcrumb']  = $this->auxiliar_m->breadcrumb($this->router->class);
        $data['tbl_cliente_tipo']  = $this->auxiliar_m->traer_tabla(NULL, 'clientes_tipo');

        $this->load->view('html/Head');
        $this->load->view('html/Nav', array(
            'model_menu'=> $this->load->model('menu_m'),
            'menus'     => $this->menu_m->menu()
        ));
        $this->load->view('html/Breadcrumb_v', $data);
        $this->load->view('section/Clientes_v', $data);        
        $this->load->view('html/Footer');
    }
    
    function datatable_datos()
    {
        $fetch_data = $this->clientes_m->make_datatables();
        
        $data       = array();
        foreach ($fetch_data as $row) {
            $sub_array   = array();
            $sub_array[] = $row->cliente_id;
            $sub_array[] = $row->usuario_nombre_apellido;
            $sub_array[] = $row->cliente_tipo_nombre;
            $sub_array[] = $row->cliente_ci;
            $sub_array[] = $row->cliente_cel;
            $sub_array[] = $row->cliente_direccion;
            $sub_array[] = $row->cliente_dateinsert;
            $data[]      = $sub_array;
        }
        $output = array(
            "draw"              => intval($this->input->post("draw")),
            "recordsTotal"      => $this->clientes_m->get_all_data(),
            "recordsFiltered"   => $this->clientes_m->get_filtered_data(),
            "data"              => $data
        );
        if(!isset($headers)){
            $headers='Content-type:application/json';
        }
        header($headers);
        echo json_encode($output, JSON_PRETTY_PRINT);
    }    

    /**
    *   Añadir, Editar / Actualizar, Eliminar
    *
    */
    public function agregar()
    {
        $cliente_id_padre = $this->input->post('cliente_id_padre');
        if ($this->input->post('cliente_tipo_id') == 1){$cliente_id_padre = NULL;}
		//$this->input->post('plan_id');
        
		$data   = array(
            'cliente_nombre'     => $this->input->post('cliente_nombre'),
            'cliente_apellido'   => $this->input->post('cliente_apellido'),
            'cliente_id_padre'   => $cliente_id_padre,
            'cliente_ci'         => $this->input->post('cliente_ci'),
            'cliente_cel'        => $this->input->post('cliente_cel'),
            'cliente_fecha_nacimiento'  => $this->input->post('cliente_fecha_nacimiento'),
            'cliente_sexo'       => $this->input->post('cliente_sexo'),
            'cliente_direccion'  => $this->input->post('cliente_direccion'),
            'cliente_tipo_id'    => $this->input->post('cliente_tipo_id'),
            'cliente_archivo'    => $this->input->post('cliente_archivo'),
            'cliente_ruc'        => $this->input->post('cliente_ruc'),
            'cliente_ruc_dv'     => $this->input->post('cliente_ruc_dv'),
            'cliente_dateinsert' => date("Y-m-d H:i:s"),
            'usuario_id'         => $this->session->userdata('usuario_id')
        );
        $insert = $this->clientes_m->agregar($data);
        // Si todo se insertó bien, inserto el plan del cliente
        if ($insert){
            $data   = array(
                'cliente_id'						=> $insert,
                'plan_id'           				=> $this->input->post('plan_id'),
                'planes_clientes_estado'        	=> 'activo',
				'planes_clientes_modificar_monto' 	=> $this->input->post('planes_clientes_modificar_monto',TRUE)==null ? 'no' : 'si',
                'planes_clientes_monto'				=> $this->input->post('planes_clientes_monto'),
                'planes_clientes_fecha_ingreso' 	=> $this->input->post('planes_clientes_fecha_ingreso'),
                'planes_clientes_dateinsert'    	=> date("Y-m-d H:i:s")
            );
            $insert = $this->clientes_m->agregar_plan_cliente($data);
            
        }
		
        echo json_encode(array(
            "status" => TRUE
        ));
    }

    public function editar($id)
    {
        $data = $this->clientes_m->obtener_por_id($id);
        echo json_encode($data);
    }

    public function actualizar()
    {        
        $cliente_id_padre   = $this->input->post('cliente_id_padre');
        $cliente_id         = $this->input->post('cliente_id');
        // Si el campo cliente_tipo_id = 1 (titular), se inserta null en cliente_id_padre
        if ($this->input->post('cliente_tipo_id') == 1){$cliente_id_padre = NULL;}
        $data1 = array(
            'cliente_nombre'     => $this->input->post('cliente_nombre'),
            'cliente_apellido'   => $this->input->post('cliente_apellido'),
            'cliente_id_padre'   => $cliente_id_padre,
            'cliente_ci'         => $this->input->post('cliente_ci'),
            'cliente_cel'        => $this->input->post('cliente_cel'),
            'cliente_fecha_nacimiento'  => $this->input->post('cliente_fecha_nacimiento'),
            'cliente_sexo'      => $this->input->post('cliente_sexo'),
            'cliente_direccion' => $this->input->post('cliente_direccion'),
            'cliente_ruc'       => $this->input->post('cliente_ruc'),
            'cliente_ruc_dv'    => $this->input->post('cliente_ruc_dv'),
            'cliente_tipo_id'    => $this->input->post('cliente_tipo_id')
        );        
        // Cliente es titular?
        $cliente_es_titular = $this->clientes_m->cliente_es_titular($cliente_id, '1');
        // Si cliente es titular y ahora elige ser adherente, todos sus adherentes pasan al nuevo titular
        if ($cliente_es_titular and ($this->input->post('cliente_tipo_id') =='2'))
        {
            // Actualizar todos los cliente_id_padre donde cliente_id_padre sea igual al cliente_id que era titular
            $data2 = array('cliente_id_padre' => $cliente_id_padre);
            $this->clientes_m->update(array('cliente_id_padre'  => $cliente_id), $data2);
        }
        //Actualizar todos los datos del formulario
        $exito = $this->clientes_m->update(array(
            'cliente_id' => $this->input->post('cliente_id')
        ), $data1);
        // Plan del cliente existe en tabla planes_clientes?        
        $planes_clientes_existe = $this->clientes_m->planes_clientes_existe($this->input->post('cliente_id'), $this->input->post('plan_id'), $this->input->post('planes_clientes_modificar_monto',TRUE)==null ? 'no' : 'si', $this->input->post('planes_clientes_monto'), $this->input->post('planes_clientes_fecha_ingreso'));
        // Si no existe cliente_id, plan_id and pla_clientes_estado = activo, insertar y cambiar estado
        if (!$planes_clientes_existe){ // Evitar duplicado, Si no se ha insertado todavía
            // Antes de insertar cambiar el estado a inactivo del plan cliente existente
            $data3 = array('planes_clientes_estado' => 'inactivo');
            $exito = $this->clientes_m->update_planes_clientes_estado(array('cliente_id' => $this->input->post('cliente_id')), $data3);
						
			$data4   = array(
                'cliente_id'						=> $this->input->post('cliente_id'),
                'plan_id'           				=> $this->input->post('plan_id'),
                'planes_clientes_estado'        	=> 'activo',
                'planes_clientes_modificar_monto' 	=> $this->input->post('planes_clientes_modificar_monto',TRUE)==null ? 'no' : 'si',
                'planes_clientes_monto'				=> $this->input->post('planes_clientes_monto'),
				'planes_clientes_fecha_ingreso' 	=> $this->input->post('planes_clientes_fecha_ingreso'),                
                'planes_clientes_dateinsert'    	=> date("Y-m-d H:i:s")
            );
            $exito = $this->clientes_m->agregar_plan_cliente($data4);
        }
        
        echo $exito = json_encode(array(
            "status" => TRUE
        ));
    }
	
	/*******
	*
	*	PLAN CLIENTE
	*/
	public function plan_cliente(){
		if(!isset($headers)){
            $headers='Content-type:application/json';
        }
        header($headers);
		$planes_clientes_existe = $this->clientes_m->planes_clientes_existe(2, 6, 'si');
		echo json_encode($planes_clientes_existe, JSON_PRETTY_PRINT);
	}

    // Borrado lógico
    public function eliminar($id)
    {
        $this->clientes_m->update(
            array('cliente_id'       => $id),
            array('cliente_estado'   => 'borrado')
        );
        echo json_encode(array("status" => TRUE));
        /*
        $this->clientes_m->eliminar_por_id($id);
        echo json_encode(array(
            "status" => TRUE
        ));
        */
    }

    public function cliente_titular($cliente_id)
    {
        /*$data = $this->auxiliar_m->traer_tabla(array(
            'cliente_tipo_id' => 1 // titular
        ), 'clientes');
        */
        foreach ($this->clientes_m->listar_clientes_titulares($cliente_id) as $row) {
            echo '<option value="'.$row->cliente_id.'" '.$row->selected.'>'.$row->cliente_nombre.' '.$row->cliente_apellido.' - '.$row->cliente_ci.'</option>';
        }
    }
    
    public function planes($fecha_nacimiento, $cliente_id){
        // Capturo y formateo la fecha de nacimiento (igual si esta bien formateada) enviada por el campo cliente_fecha_nacimiento
        //echo $fecha_nacimiento;
        
        $fecha_nacimiento = date("Y-m-d", strtotime($fecha_nacimiento));
        $cumpleanos = new DateTime($fecha_nacimiento);
        $hoy = new DateTime();
        $edad = $hoy->diff($cumpleanos);
        $edad = $edad->y;		
        
        foreach ($this->clientes_m->listar_planes($edad, $cliente_id) as $row) {
            echo '<option value="'.$row->plan_id.'" '.$row->selected.'> '.$row->plan_categoria_nombre.' '.$row->planes_costo.' - '.$row->plan_rango_edad_nombre.'</option>';
        }
        
        /*****
        $fechaInicio=strtotime("25-09-2018");
        $fechaFin=strtotime("30-09-2018");
        
        for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
            echo date("d-m-Y", $i)."<br>";
        }
        */
    }
    public function planes_clientes_fecha_ingreso($cliente_id, $plan_id){
        $data = $this->clientes_m->planes_clientes_existe($cliente_id, $plan_id, NULL, NULL, null);
        echo json_encode($data);
    }

    // Obtener cliente por ID
    public function getById($cliente_id)
    {
        $data = $this->clientes_m->obtener_por_id($cliente_id);
        //echo $data->cliente_nombre;
        echo json_encode($data);
    }

}