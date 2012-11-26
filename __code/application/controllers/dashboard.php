<?php
/* * **************************************************\
 * 	Fichier			: controllers/dashboard.php
 * 	Projet			: CESAM
 * 	Version			: 2012/10/30 22:40
 *	Auteur			: Ryane Alla
 \*************************************************** */


class Dashboard extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$vars = array();
		
		$vars['pageId'] = PAGE_ID_DASHBOARD;
		$vars['leftBoxData'] = array();
		
		
		$this->bktemplate->write('title', 'Cesam - Tableau de bord', TRUE);
		$this->bktemplate->write_view('header', '_content/zones/_header', $vars);
		$this->bktemplate->write_view('content', '_content/dashboard', $vars);
		$this->bktemplate->write_view('footer', '_content/zones/_footer');
		$this->bktemplate->render();
	}
}

?>