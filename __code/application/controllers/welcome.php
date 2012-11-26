<?php
/* * **************************************************\
 * 	Fichier			: controllers/welcome.php
 * 	Projet			: PMU
 * 	Version			: 2012/02/14 22:40
 *	Auteur			: Ryane Alla
 \*************************************************** */

/**
 * @property User_model $user_model
 */
class Welcome extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->bktemplate->set_template('logout');
		$this->bktemplate->add_css('public/css/welcome.css');
		$this->bktemplate->add_js('public/js/welcome.js');
		
		if($this->session->userdata('logged_in')) redirect(base_url().'dashboard');
	}

	public function index() {
		$this->cesamLogin();
	}
	
	private function cesamLogin() {
		$vars = array();
		$vars['loginForm'] = false;
		$vars['divError'] = $this->session->userdata('loginDivError');
		
		$this->bktemplate->write('title', 'Cesam - Login', TRUE);
		$this->bktemplate->write_view('header', '_content/zones/_header_logout', $vars);
		$this->bktemplate->write_view('content', '_content/cesam_login', $vars);
		$this->bktemplate->write_view('footer', '_content/zones/_footer');
		$this->bktemplate->render();
	}

}

?>
