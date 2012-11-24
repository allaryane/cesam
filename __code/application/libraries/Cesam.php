<?php

/* * ********************Encoding : UTF-8 ******************************\

 * 	Fichier			: Cesam.php
 * 	Projet			: cesam
 * 	Version			: 13 nov. 2012 19:07:51
 * 	Auteur			: Ryane Alla // allaryane@gmail.com
 *  \************************************************************************* */

class Cesam{
		
    public function __construct(){
		// Ne pas recuperer l'instance du controleur dans le constructeur
		// car l'objet peut etre instancier par un controleur et etre manipuler
		// par un autre
    }
	
	public static function arrayTrim($array_){
		$arrayRet = array();
		foreach ($array_ as $key => $value) {
			$arrayRet[$key] = trim($value);
		}
		return $arrayRet;
	}
	
	public static function getSexe($sexe){
		if($sexe == 'F') return 'Féminin';
		else return 'Masculin';
	}
	
	public static function getState($state){
		switch ($state) {
			case STATE_DONE:
				return 'Terminé';
				break;
			
			case STATE_PENDING:
				return 'Suspendu';
				break;
			
			case STATE_PROGRESS:
				return 'En cours';
				break;
			
			default:
				return '';
				break;
		}
	}
        

}
?>
