<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mantenimiento_sistema extends CI_Controller {

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
		$this->load->model('auxiliar_m');
        $data['breadcrumb']  = $this->auxiliar_m->breadcrumb($this->router->class);
        $this->load->view('html/Head');
		$this->load->view('html/Nav', array(
										'model_menu' => $this->load->model('menu_m'), 
										'menus' => $this->menu_m->menu()
										));
		//$this->load->view('admin/usuarios_v', $data);
		$this->load->view('html/Breadcrumb_v', $data);
        $this->load->view('admin/Mantenimiento_sistema_v');
        $this->load->view('html/Footer');
	}

	function crear_carpeta($carpeta, $permisos){
		if (!file_exists($carpeta)) {
		    mkdir($carpeta, $permisos, true);
		    //echo 'Directorio creado: '.$carpeta.'.<br>Permisos: '.$permisos.'</br>';
		}
	}

	//	Here is a simple function to convert Bytes to KB, MB, GB, TB :
	function convertToReadableSize($size){
		$base = log($size) / log(1024);
		$suffix = array("", "KB", "MB", "GB", "TB");
		$f_base = floor($base);
		return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
	}

	function listar_archivos($carpeta){
		//echo $this->convertToReadableSize(3789);
	    if(is_dir($carpeta)){
	        if($dir = opendir($carpeta)){
	        	while(($archivo = readdir($dir)) !== false){
	                if($archivo != '.' && $archivo != '..' && $archivo != '.htaccess'){
	                    echo '<div class="col-lg-4 col-md-6"><div class="card-box widget-user">
                            <div><a target="_blank" href="'.$carpeta.$archivo.'">
                                <img src="https://image.flaticon.com/icons/png/512/443/443827.png" class="img-responsive img-circle" alt="user"></a>
                                <div class="wid-u-info">
                                    <h4 class="m-t-0 m-b-5">'.$archivo.'</h4>
                                    <p class="text-muted m-b-5 font-13"><b>T: </b>'.$this->convertToReadableSize(filesize($carpeta.'/'.$archivo)).'</p>
                                    <small class="text-custom"><b>F: </b>'.date("d-m-Y H:i",filemtime($carpeta.'/'.$archivo)).'</small>
                                </div>
                            </div>
                            </div>
                            </div>
                        </div>';
	                }
	            }
	            closedir($dir);
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

		//$db_name = 'bkp'. date("YmdHi") .'.zip';
		// backup por hora
		$db_name = 'bkp-F'.date("Ymd").'-H'.date("H").'.zip';

		// Carpeta directorio
		// Crear carpeta dump manualmente
		$carpeta = 'files/dump/';
		//$carpeta = 'E://dump/';
		// Crear carpeta
		$this->crear_carpeta($carpeta, 0777);
		//$save = 'C:/Users/mamarilla/Documents/dumps/monteolivos/'.$db_name;
		$save = $carpeta.$db_name;

		//Escribir el archivo en un directorio
		$this->load->helper('file');
		write_file($save, $backup);
		echo '<br><p><b>Directorio actual:</b> '.$carpeta.' - ';
		echo '<b>Último archivo creado:</b> '.$db_name.'</p>';
		//	Eliminar archivos con x tiempo de creación - 3600*24*7 7 dias
		$this->eliminar_archivos($carpeta, (60*60)); // 30 minutos; 60*60*5: 5horas
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