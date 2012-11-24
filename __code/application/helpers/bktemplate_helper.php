<?php
/******************** Entête UTF-8 ******************\
*
*	fichier			: helpers/bktemplate_helper.php
*	projet			: 
*	version			: 1.0.0 2011/07/05 13:50 EV
*
\****************************************************/

class Bktemplate_helper {

	/**
	 * Retourne une vue partielle
	 *
	 * @param string	$partial_view		Relatif au thème choisi
	 * @param array		$args				OPTIONNEL
	 * @return string
	 */
	public static function render_partial($partial_view, $args = array()) {
		$CI =& get_instance();
		return $CI->bktemplate->render_view($partial_view, $args);
	}

}