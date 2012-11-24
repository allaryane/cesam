<?php

/* * ********************Encoding : UTF-8 ******************************\

 * 	Fichier			: error.php
 * 	Projet			: cesam
 * 	Version			: 3 sept. 2012 13:13:45
 * 	Auteur			: Ryane Alla // allaryane@gmail.com
 *  \************************************************************************* */

/**
 * @property CesamUser cesamuser
 */
class Error extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        
    }

    public function error_404() {

        $vars = array();
        $vars['pageId'] = PAGE_ID_ERROR_404;
        $vars['leftBoxData'] = array();


        $this->bktemplate->write('title', 'Cesam - Erreur 404', TRUE);
        $this->bktemplate->write_view('header', '_content/zones/_header', $vars);
        $this->bktemplate->write_view('content', '_content/error_404', $vars);
        $this->bktemplate->write_view('footer', '_content/zones/_footer');
        $this->bktemplate->render();
    }
    
    public function jsDisabled(){
        echo 'Js desactive';
    }

}

?>