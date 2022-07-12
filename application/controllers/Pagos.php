<?php
//  Para imprimir ticket
// Local
require '\application\third_party\ticket\autoload.php';
// Server
//require_once(APPPATH.'/third_party/ticket/autoload.php');

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *  Class Pagos
 *
 *
 *  @package application/controllers/pagos
 *  @author  seto  
 */
class Pagos extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('clientes_m');
        $this->load->model('pagos_m');
        $this->load->model('auxiliar_m');
        $this->load->model('usuarios_m');
        $this->load->model('factura_m');
        $this->load->model('parametros_m');
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
        $this->load->view('section/Pagos_v', $data);        
        $this->load->view('html/Footer');
    }
    /**
    *
    *   Datatable principal
    *
    */
    function datatable_datos()
    {
        $fetch_data = $this->pagos_m->make_datatables();
        
        $data       = array();
        foreach ($fetch_data as $row) {
            $sub_array   = array();
            $sub_array[] = $row->pago_cliente_id;
            $sub_array[] = $row->cliente;
            $sub_array[] = $row->pago_cliente_fecha;
            $sub_array[] = $row->cobrador;
            $sub_array[] = $row->pago_cliente_estado;
            $sub_array[] = $row->pago_cliente_monto_total;
            $sub_array[] = '';
            $data[]      = $sub_array;
        }
        $output = array(
            "draw"              => intval($this->input->post("draw")),
            "recordsTotal"      => $this->pagos_m->get_all_data(),
            "recordsFiltered"   => $this->pagos_m->get_filtered_data(),
            "data"              => $data
        );
        if(!isset($headers)){
            $headers='Content-type:application/json';
        }
        header($headers);
        echo json_encode($output, JSON_PRETTY_PRINT);
    } 
    /**
    *
    *   Datatable para crear ticket
    *
    */
    function datatableFacturaDetalle($cliente_id)
    {
        $fetch_data = $this->pagos_m->make_datatableFacturaDetalle($cliente_id);

        $data       = array();
        foreach ($fetch_data as $row) {
            $i=1;
            $sub_array   = array();
            //$sub_array[] = $row->cliente_id;
            $sub_array[] = '<input readonly="" tabindex="-1" name="cliente_id[]" value="'.$row->cliente_id.'" type="text" class="text-center form-control input-format-1" style="width:76px">';
            $sub_array[] = $row->cliente;
            $sub_array[] = $row->edad;
            $sub_array[] = $row->plan;
            $sub_array[] = $row->plan_monto;
            //$sub_array[] = "";
            $sub_array[] = '<input id="" tabindex="'.$i++.'" name="pago_cliente_detalle_monto_adicional[]" value="0" type="text" class="text-center form-control" style="width:100%;border: none;border-bottom: 1px solid #c2c2c2;border-radius: 0;padding: 0;margin: 0;">';
            $data[]      = $sub_array;            
        }
        $output = array(
            "draw"              => intval($this->input->post("draw")),
            "recordsTotal"      => $this->pagos_m->get_all_data_datatableFacturaDetalle($cliente_id),
            "recordsFiltered"   => $this->pagos_m->get_filtered_data_datatableFacturaDetalle($cliente_id),
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
        //	Diferencia en meses para saber las cuotas a pagar
		$datetime1 = new DateTime($this->input->post('pago_cliente_fecha'));
		$datetime2 = new DateTime($this->input->post('pago_cliente_fecha_hasta'));
		$interval = $datetime1->diff($datetime2);
		//$meses_cuotas = ( $interval->y * 12 ) + $interval->m;
		$meses_cuotas = ((( $interval->y * 12 ) + $interval->m) + 1);

        $userSucursal = $this->usuarios_m->obtener_por_id($this->session->userdata('usuario_id'))->sucursal_id;

        if ($userSucursal == null || $userSucursal == null <= 0) {
            echo $exito = json_encode(
                array(
                    "status"    => TRUE,
                    "code"      => 404,
                    "tipo"      => "error",
                    "message"   => "El usuario no tiene definido una sucursal."
                )
            );
            return;
        }
        
        if ($this->factura_m->getBySucursal($userSucursal) == null) {
            echo $exito = json_encode(
                array(
                    "status"    => TRUE,
                    "code"      => 404,
                    "tipo"      => "error",
                    "message"   => "No se registró ninguna factura."
                )
            );
            return;
        }
        // Se verifica número de factura
        $facturaNroActual = explode('-', $this->factura_m->getBySucursal($userSucursal)->nro_actual)[2];
        $facturaNroHasta = explode('-', $this->factura_m->getBySucursal($userSucursal)->nro_hasta)[2];
        if (!$this->currentNumberIsLessThanOrEqual($facturaNroActual, $facturaNroHasta)){
            echo $exito = json_encode(
                array(
                    "status"    => TRUE,
                    "code"      => 409,
                    "tipo"      => "warning",
                    "message"   => "El número de factura generado no puede ser mayor al número final de factura. Comuniquese con su Administrador."
                )
            );
            return;
        }
		// Insertar la cabecera, el primero siempre es el titular
		for ($i=0; $i < 1 ; $i++) {
            $data   = array(
                'cliente_id'            	=> $this->input->post('cliente_id')['0'],
                'pago_cliente_fecha'    	=> $this->input->post('pago_cliente_fecha')." ".date("H:i:s"),
                'pago_cliente_fecha_hasta'	=> $this->input->post('pago_cliente_fecha_hasta')." ".date("H:i:s"),
                'pago_forma_id'             => $this->input->post('pago_forma_id'),
                'pago_forma_efectivo_monto' => $this->input->post('pago_forma_efectivo_monto'),
                'pago_forma_tarjeta_monto'  => $this->input->post('pago_forma_tarjeta_monto'),
                'pago_cliente_cuotas'		=> $meses_cuotas,
                'pago_cliente_monto_plan'   => $this->input->post('pago_cliente_detalle_monto_adicional')['0'],
                'pago_cliente_estado'   	=> 'Pendiente',
                'usuario_id'            	=> $this->session->userdata('usuario_id'),
                'sucursal_id'               => $userSucursal,
            );
        }
        $generarFactura = ($this->input->post('generar_factura') != null) ? true:false;
        
        $exito = $this->pagos_m->agregar_cabecera($data);
        // Insertar detalle
        $countsize = count($this->input->post('cliente_id'));
        if ($exito){
            for ($i=0; $i < $countsize; $i++) 
            {
                $cliente_id = $this->input->post('cliente_id')[$i]; //obtener_planes_cliente_costo
                $data   = array(
                    'pago_cliente_id'					=> $exito,
                    'planes_clientes_id'    			=> $this->pagos_m->obtener_planes_cliente($cliente_id, 'planes_clientes_id'),
                    'pago_cliente_detalle_monto_plan' 	=> $monto_plan_detail = $this->pagos_m->obtener_planes_cliente_costo($this->pagos_m->obtener_planes_cliente($cliente_id, 'plan_id'), $cliente_id),
                    'pago_cliente_detalle_subtotal'     => $monto_plan_detail = $monto_plan_detail * $meses_cuotas,
                    'pago_cliente_detalle_monto_adicional'   => $monto_adicional_detail = $this->input->post('pago_cliente_detalle_monto_adicional')[$i],
                    'pago_cliente_detalle_iva' => ($monto_plan_detail + $monto_adicional_detail) * $this->parametros_m->getbyCod("iva10")->param_valor
                );
                $this->pagos_m->agregar_detalle($data);
            }
            // Si se ha insertado todos los detalles, saco la suma de los totales para insertarla en la cabecera            
            if ($exito){
                $data   = array(
                    'pago_cliente_estado'       => 'Pagado',
                    // Pagos plan + Adicional
                    'pago_cliente_monto_plan'   => $monto_total = $this->pagos_m->total_monto_plan($exito), // Monto plan
                    'pago_cliente_monto_iva'    => $monto_iva = $this->pagos_m->total_monto_iva($exito), // Monto iva
                    //  ( plan * cuotas) + adicional + IVA
                    'pago_cliente_monto_total'  => (($monto_total * $meses_cuotas)+$this->pagos_m->total_monto_adicional($exito)+$monto_iva), 
                    'factura_id'                => $this->factura_m->getBySucursal($userSucursal)->factura_id,
                    'factura_nro'               => $this->generateNextNumberFactura($this->factura_m->getBySucursal($userSucursal)->nro_actual),
                    'factura_ruc'               => $this->input->post('cliente_ruc'),
                    'factura_razon_social'      => $generarFactura ? $this->input->post('cliente_nombre'): 'SIN NOMBRE',
                    'factura_concepto'          => $this->input->post('factura_concepto'),
                );
                $exito = $this->pagos_m->actualizar_montos_cabecera(array('pago_cliente_id'  => $exito), $data);
                // Se actualiza data de factura
                if ($exito){
                    $data = array(
                        'nro_actual' => $this->generateNextNumberFactura($this->factura_m->getBySucursal($userSucursal)->nro_actual),
                    );
                    $this->factura_m->updateNroActual(array('factura_id' => $this->factura_m->getBySucursal($userSucursal)->factura_id), $data);
                }
            }
        }
        echo $exito = json_encode(
            array(
                "status"    => TRUE,
                "code"      => 200,
                "tipo"      => "success",
                "message"   => "Pago generado exitosamente."
            )
        );
    }

    public function getId()
    {
        $data = $this->usuarios_m->obtener_por_id($this->session->userdata('usuario_id'))->sucursal_id;
        echo json_encode($data);
    }
    /**
     * Se genera el número siguiente para la factura
     */
    public function generateNextNumberFactura($currentNroFactura){ 
        //$position2 = explode('-', $currentNroFactura)[2] //[0]-[1]-[2]
        // Eliminar ceros a la izquierda de la posición 2 del array [0]-[1]-[2]
        $nroFactura = ltrim(explode('-', $currentNroFactura)[2], "0");
        $number = $nroFactura + 1; // sumar 1
        $length = strlen(explode('-', $currentNroFactura)[2]);
        $nextNumber = substr(str_repeat(0, $length).$number, - $length);
        $nextNumber = explode('-', $currentNroFactura)[0]."-".explode('-', $currentNroFactura)[1]."-".$nextNumber;
        return $nextNumber;
    }
    /**
     * Se compara si el número actual de factura es menor o igual que el número final de factura
     */
    public function currentNumberIsLessThanOrEqual($currentNroFactura, $nroFacturaHasta){
        // Eliminar ceros a la izquierda
        $nroFactura = ltrim($currentNroFactura, "0")+1; // sumar 1
        $nroFacturaHasta = ltrim($nroFacturaHasta, "0");
        if ($nroFactura <= $nroFacturaHasta){
            return true;
        }else{
            return false;
        }
    }
    
    // Ver detalle cabecera y detalle del ticket
    public function ver_detalle($pago_cliente_id)
    {
        $data = $this->pagos_m->obtener_por_id($pago_cliente_id);
        echo json_encode($data);
    }
    public function datatableVerDetalle($pago_cliente_id)
    {
        $data['data'] = $this->pagos_m->datatableVerDetalle($pago_cliente_id);
        echo json_encode($data);
    }

    //--
    public function anular_ticket($id)
    {
        $exito = $this->pagos_m->anular_ticket(array('pago_cliente_id'  => $id), array('pago_cliente_estado'  => 'Anulado'));
        echo $exito = json_encode(array(
            "status" => TRUE
        ));
    }

    public function cliente_titular($cliente_id){
        /*
        $data = $this->auxiliar_m->traer_tabla(array(
            'cliente_tipo_id' => 1 // titular
        ), 'clientes');
        */
        foreach ($this->pagos_m->listar_clientes_titulares($cliente_id) as $row) {
            echo '<option value="'.$row->cliente_id.'" '.$row->selected.'>'.$row->cliente_nombre.' '.$row->cliente_apellido.' - '.$row->cliente_ci.'</option>';
        }
    }
    public function mostrar_forma_pago(){
        foreach ($this->pagos_m->mostrar_forma_pago() as $row) {
            echo '<option value="'.$row->pago_forma_id.'" '.$row->selected.'>'.$row->pago_forma_id.'. '.$row->pago_forma_descripcion.'</option>';
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
            echo '<option value="'.$row->plan_id.'" '.$row->selected.'>'.$row->plan_categoria_id.'. '.$row->plan_categoria_nombre.' '.$row->planes_costo.' - '.$row->plan_rango_edad_nombre.'</option>';
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
        $data = $this->clientes_m->planes_clientes_existe($cliente_id, $plan_id);
        echo json_encode($data);
    }
	
	public function mostrar_ultimo_pago($cliente_id){
		$data = $this->pagos_m->mostrar_ultimo_pago($cliente_id);
        echo json_encode($data);
        /*$dato = json_decode(json_encode($data));
		if ($dato != null){
		echo '<div class="col-md-9" style="font-size:13px">';
		echo '<div class="col-md-4 col-sm-4"><span class="label label-inverse">ÚLTIMO PAGO</span> Gs. '.$dato->pago_cliente_monto_total.'</div>';
		echo '<div class="col-md-4 col-sm-4"><span class="label label-inverse">Mes/es</span> '.$dato->pago_cliente_desde_hasta.'</div>';
		echo '<div class="col-md-4 col-sm-4"><span class="label label-inverse">Pagado el</span> '.$dato->pago_cliente_dateinsert.'</div>';
		echo '</div>';
		}else{
			//echo 'Primer pago todavía no se realizó';
		}*/
	}

    public function getTimbrado()
    {
        $data = $this->pagos_m->getTimbradoActivo();
        echo $data->timbrado_id;
        echo json_encode($data);
    }
	/**
     * TICKET
     */
	public function ticket($ticket_id){
        echo json_encode($this->pagos_m->obtener_por_id($ticket_id));
        $nombre_impresora = "ImpresoraTermica"; // ImpresoraTermica // Nitro PDF Creator (Pro 12)
        $connector = new WindowsPrintConnector($nombre_impresora);
        $printer = new Printer($connector);
        $printer -> initialize();
        
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        try{
            $logo = EscposImage::load("template/assets/images/logoTicket.png", false);
            $printer->bitImage($logo);
        }catch(Exception $e){}
        
        $printer -> setEmphasis(true);
        $printer -> text("\nFUNERARIA MONTEOLIVOS\n");
        $printer -> setEmphasis(false);
        $printer->setJustification();
        #
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setFont(Printer::FONT_B);
        $printer -> text("Espana 2235 casi America - Casa Central\n");
        $printer -> text("(021) 605 055 | (021) 211 955\n");
        $printer->setFont();
        $printer -> text("-------------------------------\n");
        $printer->setJustification();
        
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->setFont(Printer::FONT_B);
        //$line = sprintf('%-25s %-6s %5s', 'Cliente', 'Plan', 'Adicional');
		//$printer->text($line);
        $printer -> text("Cliente / Adherente");
		$printer -> text("\n¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯\n");
        $printer->setFont();
        $printer->setJustification();
        
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->setFont(Printer::FONT_B);
        foreach($this->pagos_m->datatableVerDetalle($ticket_id) as $row){
            $printer->text($row->cliente);
            $printer->text("\n"); 
        }
        $printer->setFont();
        $printer->setJustification();      
        
        $printer -> feed();
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text("---\n");
        $printer->setJustification();
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->setFont(Printer::FONT_B);
        $row = $this->pagos_m->obtener_por_id($ticket_id);        
        //$printer->text("Total plan:      " .$row->pago_cliente_monto_plan. "\n");
        //$printer->text("Total adicional: " .$row->pago_cliente_detalle_monto_adicional. "\n");
        $printer->setFont();
        $printer -> setEmphasis(true);
        $printer->text("TOTAL:       Gs. " .$row->pago_cliente_monto_total. "\n");
        $printer -> setEmphasis(false);
        $printer -> feed();
        $printer->setJustification();
        
        $printer -> text("-------------------------------\n");
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("Ticket: #". $ticket_id ."\n");
        $printer->setJustification();
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->setFont(Printer::FONT_B);        
        $printer->text("Titular: ". $row->cliente ."\n");
        $printer->text("C.I.:    ". $row->cliente_ci ."\n");
		
        $printer->text("Fecha pago: ". $row->pago_cliente_fecha . " ". $row->pago_cliente_hora ."\n");
        setlocale(LC_TIME, 'spanish');
		$printer->text("Mes pago: ". ucwords($row->pago_cliente_desde_hasta) . " \n");
		
        $printer->text("Estado:  ". $row->pago_cliente_estado ."\n");
        $printer->text("Cajero:  ". $row->cobrador ."\n");
        $printer->text("Ticket generado en: ". date("d-m-Y H:i") ."\n");
        $printer->setFont();
        $printer->setJustification();
        $printer -> feed();
        # Pie de página
            
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("--------\n");
        $printer->text("Gracias por la preferencia.\n");
        $printer->setJustification();
        
        $printer->feed(2);
        $printer->cut();
        $printer->pulse();
        $printer->close();
    }
    
    /****
	*	Ticket original
    public function ticket($ticket_id){
        $nombre_impresora = "ImpresoraTermica";
        $connector = new WindowsPrintConnector($nombre_impresora);
        $printer = new Printer($connector);
        $printer -> initialize();
        
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        try{
            $logo = EscposImage::load("template/assets/images/logoTicket.png", false);
            $printer->bitImage($logo);
        }catch(Exception $e){}
        
        $printer -> setEmphasis(true);
        $printer -> text("\nFUNERARIA MONTEOLIVOS\n");
        $printer -> setEmphasis(false);
        $printer->setJustification();
        #
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setFont(Printer::FONT_B);
        $printer -> text("Espana 2235 casi America - Casa Central\n");
        $printer -> text("(021) 605 055 | (021) 211 955\n");
        $printer->setFont();
        $printer -> text("-------------------------------\n");
        $printer->setJustification();
        
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->setFont(Printer::FONT_B);
        //$line = sprintf('%-25s %-6s %5s', 'Cliente', 'Plan', 'Adicional');
		//$printer->text($line);
        $printer -> text("Cliente / Adherente");
		$printer -> text("\n¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯\n");
        $printer->setFont();
        $printer->setJustification();
        
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->setFont(Printer::FONT_B);
        foreach($this->pagos_m->datatableVerDetalle($ticket_id) as $row){
            $printer->text($row->cliente);
            $printer->text("\n"); 
        }
        $printer->setFont();
        $printer->setJustification();      
        
        $printer -> feed();
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text("---\n");
        $printer->setJustification();
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->setFont(Printer::FONT_B);
        $row = $this->pagos_m->obtener_por_id($ticket_id);        
        //$printer->text("Total plan:      " .$row->pago_cliente_monto_plan. "\n");
        //$printer->text("Total adicional: " .$row->pago_cliente_detalle_monto_adicional. "\n");
        $printer->setFont();
        $printer -> setEmphasis(true);
        $printer->text("TOTAL:       " .$row->total_pago. "\n");
        $printer -> setEmphasis(false);
        $printer -> feed();
        $printer->setJustification();
        
        $printer -> text("-------------------------------\n");
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("Ticket: #". $ticket_id ."\n");
        $printer->setJustification();
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->setFont(Printer::FONT_B);        
        $printer->text("Titular: ". $row->cliente ."\n");
        $printer->text("C.I.:    ". $row->cliente_ci ."\n");
		
        $printer->text("Fecha pago: ". $row->pago_cliente_fecha . " ". $row->pago_cliente_hora ."\n");
        setlocale(LC_TIME, 'spanish');
		$printer->text("Mes pago: ". ucwords(strftime("%B", strtotime($row->pago_cliente_fecha))) . " \n");
		
        $printer->text("Estado:  ". $row->pago_cliente_estado ."\n");
        $printer->text("Cajero:  ". $row->cobrador ."\n");
        $printer->text("Ticket generado en: ". date("d-m-Y H:i") ."\n");
        $printer->setFont();
        $printer->setJustification();
        $printer -> feed();
        # Pie de página
            
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("--------\n");
        $printer->text("Gracias por la preferencia.\n");
        $printer->setJustification();
        
        $printer->feed(2);
        $printer->cut();
        $printer->pulse();
        $printer->close();
    }
	*/
}