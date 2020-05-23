<?php
class Audi_log {
	function __construct() {
		// pedro flecha 
	}
	function Insertar_audi_log() {
		$CI = & get_instance();
		if($CI->db->trans_status()){   
			foreach ($CI->db->queries as $key => $query) {
				if(strtolower(substr($query, 0, 6)) != 'select' 
                                    && strtolower(substr($query, 0, 20)) != 'update `ci_sessions`' 
									&& strtolower(substr($query, 0, 25)) != 'delete from `ci_sessions`' 
                                    && strtolower(substr($query, 0, 25)) != 'insert into `ci_sessions`' 
                                    && strtolower(substr($query, 0, 17)) != 'update `sesiones`' 
									&& strtolower(substr($query, 0, 22)) != 'delete from `sesiones`' 
                                    && strtolower(substr($query, 0, 22)) != 'insert into `sesiones`'){
					$usuario_id = $CI->session->userdata('usuario_id');
					if(!empty($usuario_id)){
						$data = array(
							'consulta'   =>  $query,							
							'usuario_id' =>  $usuario_id,
							'controlador'=>  $CI->uri->uri_string,
							'datos_log'  =>  json_encode($_REQUEST)
						);
                        if ($query <> "SET lc_time_names = 'es_ES'"){
                            // No insertar seteo de idioma para meses
                            $CI->db->insert('auditoria_logs', $data);
                        }
					}
				}
			}
		}
	}
}