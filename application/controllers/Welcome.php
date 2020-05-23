<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 * http://coderthemes.com/flacto/light_red_1_light/index.html
	 */
	public function index()
	{
		$data[] = 'Hola';
        $this->load->view('html/Head');
		$this->load->view('html/Nav', array(
										'model_menu' => $this->load->model('menu_m'), 
										'menus' => $this->menu_m->menu()
										));
		//$this->load->view('admin/usuarios_v', $data);
        $this->load->view('welcome_message');
        $this->load->view('html/Footer');
	}

	function crear_carpeta($carpeta, $permisos){
		if (!file_exists($carpeta)) {
		    mkdir($carpeta, $permisos, true);
		    //echo 'Directorio creado: '.$carpeta.'.<br>Permisos: '.$permisos.'</br>';
		}
	}

	function listar_archivos($carpeta){
	    if(is_dir($carpeta)){
	        if($dir = opendir($carpeta)){
	        	echo '<ul>';
	            while(($archivo = readdir($dir)) !== false){
	                if($archivo != '.' && $archivo != '..' && $archivo != '.htaccess'){
	                    echo '<li><a target="_blank" href="'.$carpeta.'/'.$archivo.'">'.$archivo.'</a> - Tamaño: '.filesize($carpeta.'/'.$archivo).'</li>';
	                }
	            }
	            closedir($dir);
	            echo '<ul>';
	        }
	    }
	}
	function eliminar_archivos($carpeta, $tiempo){
		$files = glob($carpeta.'*'); //obtenemos el nombre de todos los ficheros
		foreach($files as $file){
		    $lastModifiedTime = filemtime($file);
		    $currentTime = time();
		    //$timeDiff = abs($currentTime - $lastModifiedTime)/(60*60); //en horas
		    $timeDiff = abs($currentTime - $lastModifiedTime)/($tiempo); // elimina archivos cada x m
		    if(is_file($file) && $timeDiff > 10)
		    unlink($file); //elimino el fichero
		}
	}
	public function databasebackup(){
		$this->load->dbutil();
		date_default_timezone_set("America/Asuncion");

		$prefs = array(     
		    'format'      => 'zip',             
		    'filename'    => 'db_'.date("YmdH").'.sql'
		    );

		//	$backup =& $this->dbutil->backup($prefs);
		$backup = $this->dbutil->backup($prefs);		

		$db_name = 'bkp'. date("YmdHi") .'.zip';

		// Carpeta directorio
		$carpeta = 'files/dump/';
		//$carpeta = 'E://dump/';
		// Crear carpeta
		$this->crear_carpeta($carpeta, 0777);
		//$save = 'C:/Users/mamarilla/Documents/dumps/monteolivos/'.$db_name;
		$save = $carpeta.$db_name;

		//Escribir el archivo en un directorio
		$this->load->helper('file');
		write_file($save, $backup);
		echo 'Se ha creado el archivo: '.$save.'<br>';
		//	Eliminar archivos con x tiempo de creación - 3600*24*7 7 dias
		$this->eliminar_archivos($carpeta, 15);
		$this->listar_archivos($carpeta);
		
		// Descargarlo directamente
		//$this->load->helper('download');
		//force_download($db_name, $backup);
	}
    public function insertar_prueba()
    {
        $this->load->model('clientes_m');
        ini_set('MAX_EXECUTION_TIME', 0);
        for ($i = 1; $i < 1500; $i++) {            
            $data   = array(
                'cliente_nombre'    => substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 7),
                'cliente_apellido'  => substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6),
                'cliente_ci'        => rand(),
                'cliente_cel'       => rand(1111111111, 9999999999),
                'cliente_dateinsert'=> date("Y-m-d H:i:s")                
            );
            $insert = $this->clientes_m->agregar($data);
            echo json_encode(array(
                "status" => TRUE
            ));
        }
    }
}