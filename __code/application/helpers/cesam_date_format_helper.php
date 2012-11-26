<?php

/* * ********************Encoding : UTF-8 ******************************\

 * 	Fichier			: cesamdateformat_helper.php
 * 	Projet			: cesam
 * 	Version			: 1 nov. 2012 22:17:29
 * 	Auteur			: Ryane Alla // allaryane@gmail.com
 *  \************************************************************************* */


class Cesam_date_format_helper {
	
	public static $monthsNamesMin = array("Jan", "Fév", "Mar", "Avr", "Mai", "Jui", "Juil", "Aoû", "Sep", "Oct", "Nov", "Déc");
	public static $monthsFullNames = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");

	
	public static function sqlFormatToCesam($toFormat){
		
		@list($_date, $_time) = preg_split('/ /', $toFormat);
		if(!empty($_time)){
			list($_hour, $_min, $_sec) = preg_split('/:/', $_time);
			$_time = ' à '.$_hour.' h '.$_min;
		}
		list($year, $month, $day) = preg_split('/-/', $_date);
		return $day.' '.Cesam_date_format_helper::$monthsFullNames[$month - 1].' '.$year.$_time;
	}
        
        public static function getAge($birthday){
            $_age = floor( (strtotime(date('Y-m-d')) - strtotime($birthday)) / 31556926);
            return $_age;
        }
	
	
	
}

	
