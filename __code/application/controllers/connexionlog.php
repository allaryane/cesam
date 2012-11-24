<?php

/* * ********************Encoding : UTF-8 ******************************\

 * 	Fichier			: notifications.php
 * 	Projet			: pickmeup
 * 	Version			: 30 oct. 2012 05:17:12
 * 	Auteur			: Ryane Alla // allaryane@gmail.com
 *  \************************************************************************* */

/**
 * @property Connexionlog_model $connexionlog_model
 * @property User_model $user_model
 */

class Connexionlog extends CI_Controller {

	public function __construct() {
            parent::__construct();
            $this->bktemplate->add_css('public/css/connexionLog.css');
            $this->bktemplate->add_js('public/js/connexionLog.js');
	}

        private function purgeLog(){
            $this->load->model(array('connexionlog_model', 'settings_model'));
            $purgeDate = $this->settings_model->getSettings('purge_date_connexion_log');
            if(!empty($purgeDate) && $purgeDate != '0000-00-00 00:00:00') $this->connexionlog_model->purgeLog($purgeDate);
        }
        
	public function index() {
		$vars = array();
                
                $this->purgeLog();
                
		$this->load->model(array('connexionlog_model','user_model'));
		
		$vars['pageId'] = PAGE_ID_CONNEXION_LOG;
		$vars['leftBoxData'] = array();
                $vars['logArray'] = $this->connexionlog_model->getAllLog();
                $vars['listDoctor'] = $this->user_model->getListActiveDoctor(true);
                
		$this->bktemplate->write('title', 'Cesam - Log', TRUE);
		$this->bktemplate->write_view('header', '_content/zones/_header', $vars);
		$this->bktemplate->write_view('content', '_content/connexionlog', $vars);
		$this->bktemplate->write_view('footer', '_content/zones/_footer');
		$this->bktemplate->render();
	}

}

?>