<?php

/* * ********************Encoding : UTF-8 ******************************\

 * 	Fichier			: patients.php
 * 	Projet			: pickmeup
 * 	Version			: 30 oct. 2012 05:16:40
 * 	Auteur			: Ryane Alla // allaryane@gmail.com
 *  \************************************************************************* */

/**
 * @property CesamFile $cesamfile
 * @property CesamPatient $cesampatient
*/
class Mypatients extends CI_Controller {
	
	private $pageID = PAGE_ID_MYPATIENTS;
	
	public function __construct() {
		parent::__construct();
		$this->bktemplate->add_css('public/css/patients.css');
		$this->bktemplate->add_js('public/js/patients.js');
	}

	public function index() {
		$vars = array();
		$vars['pageId'] = $this->pageID;
		$vars['leftBoxData'] = array();
                $dataDashPatient = $this->cesampatient->getPatientsDashData();
                $vars['allPatientsData'] = $dataDashPatient['allPatientsData'];
                $vars['nbPatients'] = $dataDashPatient['nbPatients'];
                $vars['searchSate'] = false;
                
                if(!empty($_POST)){
                    $vars['category'] = $_POST['category'];
                    $vars['searchTerm'] = $_POST['searchTerm'];
                    $vars['allPatientsData'] = $this->cesampatient->dashPatientSearch($_POST);
                    $vars['nbPatients'] = count($vars['allPatientsData']);
                    $vars['searchSate'] = true;
                }
           
                
		$this->bktemplate->write('title', 'Cesam - Patients', TRUE);
		$this->bktemplate->write_view('header', '_content/zones/_header', $vars);
		$this->bktemplate->write_view('content', '_content/mypatients', $vars);
		$this->bktemplate->write_view('footer', '_content/zones/_footer');
		$this->bktemplate->render();
	}
	
	
	public function recordPatient() {		
		$this->bktemplate->add_js('public/js/patientFileUpload.js');
		$this->bktemplate->add_js('public/lib/jqueryformplugin/jquery.form.js');
				
		$vars = array();
		$vars['pageId'] = $this->pageID;
		$vars['leftBoxData'] = array();
		$vars['addPatientOK'] = '';
                $vars['modifyPatientOK'] = '';

                $idPatient = $this->uri->segment(3);
		if(!empty($idPatient) && is_numeric($idPatient)){
			// tester si l'id passe est numeric
			$recordData = $this->cesampatient->getPatientRecordData($idPatient);
			$vars['recordData'] = $recordData;
		}
              		
                
		$this->bktemplate->write('title', 'Cesam - Fiche Patient', TRUE);
		$this->bktemplate->write_view('header', '_content/zones/_header', $vars);
		$this->bktemplate->write_view('content', '_content/recordPatient', $vars);
		$this->bktemplate->write_view('footer', '_content/zones/_footer');
		$this->bktemplate->render();
	}        
        
}

?>