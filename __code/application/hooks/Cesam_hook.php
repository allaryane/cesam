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

    private function checkJS(){
        
        /*$CI = get_instance();
        $CI->load->library('browscap');
        
        $brower = $CI->getBrowser();
        echo '<pre>';
        print_r($brower);
        echo '</pre>';*/
        //redirect(base_url().'error/jsDisabled');
        
    }
    
    // automatically load the history library before the
    // controller action is executed and then automatically
    // push the page into the history cache after the action
    // has executed.

    private function setup_history() {
        $ci = get_instance();
        $ci->load->library('history');
    }
    
    private function push_history() {
        $ci = get_instance();
        //if(!preg_match('/.php/', $uriH)) $ci->history->push($ci->uri->uri_string());
        $ci->history->push($ci->uri->uri_string());
    } 
    
    public function post_controller(){
        $this->push_history();
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
		
                $this->setup_history();
                
		if(!in_array($class,$redirectArray) && !$CI->session->userdata('logged_in')){	
			redirect(base_url());
		}
                $this->checkJS();
    }

    public function post_system() {
        
    }

}

