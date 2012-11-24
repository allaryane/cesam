<?php

/* * ********************Encoding : UTF-8 ******************************\

 * 	Fichier			: faq.php
 * 	Projet			: pickmeup
 * 	Version			: 30 oct. 2012 02:16:49
 * 	Auteur			: Ryane Alla // allaryane@gmail.com
 *  \************************************************************************* */

class Faq extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$vars = array();
		
		$vars['pageId'] = PAGE_ID_FAQ;
		$vars['leftBoxData'] = array();
		
		
		$this->bktemplate->write('title', 'Cesam - Aide', TRUE);
		$this->bktemplate->write_view('header', '_content/zones/_header', $vars);
		$this->bktemplate->write_view('content', '_content/faq', $vars);
		$this->bktemplate->write_view('footer', '_content/zones/_footer');
		$this->bktemplate->render();
	}

}

?>