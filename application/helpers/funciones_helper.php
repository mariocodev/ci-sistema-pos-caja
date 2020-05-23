<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//si no existe la función invierte_date_time la creamos
if (!function_exists('invierte_date_time')) {
    date_default_timezone_set("America/Asuncion");
    
    
    function decimal_romano($numero)
    {
        //    Definición de variables
        $var = $parcialfinal = $apariencia = $letternumero = $primernumero = "";
        
        $numero = floor($numero);
        if ($numero < 0) {
            $var    = "-";
            $numero = abs($numero);
        }
        # Definición de arrays
        $numerosromanos      = array(
            1000,
            500,
            100,
            50,
            10,
            5,
            1
        );
        $numeroletrasromanas = array(
            "M" => 1000,
            "D" => 500,
            "C" => 100,
            "L" => 50,
            "X" => 10,
            "V" => 5,
            "I" => 1
        );
        $letrasromanas       = array_keys($numeroletrasromanas);
        
        while ($numero) {
            for ($pos = 0; $pos <= 6; $pos++) {
                $dividendo = $numero / $numerosromanos[$pos];
                if ($dividendo >= 1) {
                    $var .= str_repeat($letrasromanas[$pos], floor($dividendo));
                    $numero -= floor($dividendo) * $numerosromanos[$pos];
                }
            }
        }
        $numcambios = 1;
        while ($numcambios) {
            $numcambios = 0;
            for ($inicio = 0; $inicio < strlen($var); $inicio++) {
                $parcial = substr($var, $inicio, 1);
                if ($parcial == $parcialfinal && $parcial != "M") {
                    $apariencia++;
                } else {
                    $parcialfinal = $parcial;
                    $apariencia   = 1;
                }
                # Caso en que encuentre cuatro carácteres seguidos iguales.
                if ($apariencia == 4) {
                    $primeraletra = substr($var, $inicio - 4, 1);
                    $letra        = $parcial;
                    $sum          = $primernumero + $letternumero * 4;
                    $pos          = busqueda($letra, $letrasromanas);
                    if ($letrasromanas[$pos - 1] == $primeraletra) {
                        $cadenaant   = $primeraletra . str_repeat($letra, 4);
                        $cadenanueva = $letra . $letrasromanas[$pos - 2];
                    } else {
                        $cadenaant   = str_repeat($letra, 4);
                        $cadenanueva = $letra . $letrasromanas[$pos - 1];
                    }
                    $numcambios++;
                    $var = str_replace($cadenaant, $cadenanueva, $var);
                }
            }
        }
        return $var;
    }
    function busqueda($cadenanueva, $array)
    {
        $pos = 0;
        foreach ($array as $contenido) {
            if ($contenido == $cadenanueva) {
                return $pos;
            }
            $pos++;
        }
    }
    
    //  Separador de miles para impresión
    function moneda($monto)
    {
        $monto = number_format($monto, 0, ",", ".");
        return $monto;
    }
    
    //  Sacar separador de miles para guardar en db
    function moneda2($monto)
    {
        $monto = str_replace('.', '', $monto);
        return $monto;
    }
    
    /**
     * Reemplaza todos los acentos por sus equivalentes sin ellos
     *
     * @param $string
     *  string la cadena a sanear
     *
     * @return $string
     *  string saneada
     */
    function sanearURL($string)
    {
        
        $string = trim($string);
        
        $string = str_replace(array(
            'á',
            'à',
            'ä',
            'â',
            'ª',
            'Á',
            'À',
            'Â',
            'Ä'
        ), array(
            'a',
            'a',
            'a',
            'a',
            'a',
            'A',
            'A',
            'A',
            'A'
        ), $string);
        
        $string = str_replace(array(
            'é',
            'è',
            'ë',
            'ê',
            'É',
            'È',
            'Ê',
            'Ë'
        ), array(
            'e',
            'e',
            'e',
            'e',
            'E',
            'E',
            'E',
            'E'
        ), $string);
        
        $string = str_replace(array(
            'í',
            'ì',
            'ï',
            'î',
            'Í',
            'Ì',
            'Ï',
            'Î'
        ), array(
            'i',
            'i',
            'i',
            'i',
            'I',
            'I',
            'I',
            'I'
        ), $string);
        
        $string = str_replace(array(
            'ó',
            'ò',
            'ö',
            'ô',
            'Ó',
            'Ò',
            'Ö',
            'Ô'
        ), array(
            'o',
            'o',
            'o',
            'o',
            'O',
            'O',
            'O',
            'O'
        ), $string);
        
        $string = str_replace(array(
            'ú',
            'ù',
            'ü',
            'û',
            'Ú',
            'Ù',
            'Û',
            'Ü'
        ), array(
            'u',
            'u',
            'u',
            'u',
            'U',
            'U',
            'U',
            'U'
        ), $string);
        
        $string = str_replace(array(
            'ñ',
            'Ñ',
            'ç',
            'Ç'
        ), array(
            'n',
            'N',
            'c',
            'C'
        ), $string);
        
        //Esta parte se encarga de eliminar cualquier caracter extraño
        $string = str_replace(array(
            "\\",
            "¨",
            "º",
            "-",
            "~",
            "#",
            "@",
            "|",
            "!",
            "\"",
            "·",
            "$",
            "%",
            "&",
            "/",
            "(",
            ")",
            "?",
            "'",
            "¡",
            "¿",
            "[",
            "^",
            "`",
            "]",
            "+",
            "}",
            "{",
            "¨",
            "´",
            ">",
            "< ",
            ";",
            ",",
            ":",
            ".",
            " "
        ), '_', $string);
        return $string;
    }
}