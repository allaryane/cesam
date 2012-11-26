<?php

/* * ********************Encoding : UTF-8 ******************************
 * 	Fichier			: Cesam_hook.php
 * 	Projet			: cesam
 * 	Version			: 30 oct. 2012 16:37:09
 * 	Auteur			: Ryane Alla // allaryane@gmail.com
 *  \*******************************************************************/

class Cesam_hook {

    public function __construct() {
    }

    public function pre_system() {

    }

    public function pre_controller() {
		
        if (MAINTENANCE_MODE) {
            // Instantie une instance du controller pour avoir accès au librairie déjà loadé.
            //$CI = new CI_Controller();
            //$CI->load->view('themes/drivepink/maintenance');
            //echo $CI->output->get_output();
            echo 'Maintenance';
            exit();
        }
    }
    
    public function post_controller(){
    }

    private function force_ssl()
    {
		$CI =& get_instance();
		$CI->config->config['base_url'] = str_replace('http://', 'https://', $CI->config->config['base_url']);
		if ($_SERVER['SERVER_PORT'] != 443) redirect(base_url ().$CI->uri->uri_string());
    }

    private function unforce_ssl()
    {
		$CI =& get_instance();
		$CI->config->config['base_url'] = str_replace('https://', 'http://', $CI->config->config['base_url']);
		if ($_SERVER['SERVER_PORT'] == 443) redirect(base_url ().$CI->uri->uri_string());
    }

    private function checkUserRight(){
        $CI = & get_instance();		
        $CI->load->library(array('session'));
        $class = $CI->router->fetch_class();
        
        $userdata = $CI->session->userdata('userLoginData');
        $arrayControllersDoctor = array('mypatients', 'contact','login', 'error'); 
        
        if(!empty($userdata) && $userdata->type == USER_TYPE_DOCTOR){
            if(!in_array($class,$arrayControllersDoctor)) echo redirect(base_url().'error/error_404');
        }    
    }
    
    public function post_controller_constructor() {
        /* @var $CI CI_Controller */
        $CI = & get_instance();		
	$class = $CI->router->fetch_class();

        /*
        $ssl = array('dashboard','passenger');
        $partial =  array('welcome'); 

        if(in_array($class,$ssl)) $this->force_ssl();
        else if(in_array($class,$partial)) return;
        else $this->unforce_ssl();
        */

        $redirectArray = array('welcome','login');

        if(!in_array($class,$redirectArray) && !$CI->session->userdata('logged_in')){	
                redirect(base_url());
        }
        
        $this->checkUserRight();
    }

    public function post_system() {
        
    }

}

