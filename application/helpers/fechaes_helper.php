<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('fecha_es')) {

    /**
     * Fecha en español
     *
     * Formatea una fecha MySQL (Y-m-d) a una fecha en español.
     * 
     * Uso: fecha_es(fecha_mysql, formato de retorno, opcional incluir hora)
     * https://github.com/juanjus98/helper-codeigniter-fecha-espanol
     * 
     * @package		Fecha en español
     * @author		Juan Julio Sandoval Layza
     * @copyright       webapu.com 
     * @since		25-06-2014
     * @version		Version 1.0
     */
    function fecha_es($fecha_mysql, $formato = "d/m/a", $incluir_hora = FALSE) {
        $fecha_en = strtotime($fecha_mysql);
        $dia = date("l", $fecha_en); // Sunday
        $ndia = date("d", $fecha_en); // 01-31
        $mes = date("m", $fecha_en); // 01-12
        $ano = date("Y", $fecha_en); // 2014
        $hora = date("H:i:s", $fecha_en); // H-i-s (Hora, minutos, segundos)

        $dias = array('Monday' => 'Lunes', 'Tuesday' => 'Martes', 'Wednesday' => 'Miercoles', 'Thursday' => 'Jueves', 'Friday' => 'Viernes', 'Saturday' => 'Sabado', 'Sunday' => 'Domingo');
        $meses = array('01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Setiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre');

        switch ($formato) {
            case "d/m/a":
                $fecha_es = date("d/m/Y", $fecha_en);
                //Resultado: 25/06/2014
                break;
            case "d-m-a":
                $fecha_es = date("d-m-Y", $fecha_en);
                //Resultado: 25-06-2014
                break;
            case "d.m.a":
                $fecha_es = date("d.m.Y", $fecha_en);
                //Resultado: 25.06.2014
                break;
            case "d M a":
                $fecha_es = $ndia . " " . substr($meses[$mes], 0, 3) . " " . $ano;
                //Resultado: 25 Jun 2014
                break;
            case "d F a":
                $fecha_es = $ndia . " " . $meses[$mes] . " " . $ano;
                //Resultado: 25 Junio 2014
                break;
            case "D d M a":
                $fecha_es = substr($dias[$dia], 0, 3) . " " . $ndia . " " . substr($meses[$mes], 0, 3) . " " . $ano;
                //Resultado: Mar 25 Jun 2014
                break;
            case "L d F a":
                $fecha_es = $dias[$dia] . " " . $ndia . " " . $meses[$mes] . " " . $ano;
                //Resultado: Martes 25 Junio 2014
                break;
        }

        if ($incluir_hora) {
            $fecha_es .= " " . $hora;
        }

        return $fecha_es;
    }

}
