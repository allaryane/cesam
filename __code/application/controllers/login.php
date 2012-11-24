<?php

/* * ********************Encoding : UTF-8 ******************************\

 * 	Fichier			: login.php
 * 	Projet			: cesam
 * 	Version			: 3 sept. 2012 13:13:45
 * 	Auteur			: Ryane Alla // allaryane@gmail.com
 *  \************************************************************************* */

/**
 * @property CesamUser cesamuser
*/
class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
	}

	public function connect(){
		$this->cesamuser->login($_POST);		
	}

	public function disconnect(){
		$this->cesamuser->logout();
	}
}

?>