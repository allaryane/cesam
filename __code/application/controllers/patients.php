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
class Patients extends CI_Controller {
	
	private $pageID = PAGE_ID_PATIENTS;
	
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
                $vars['nbFiles'] = $dataDashPatient['nbFiles'];
                $vars['searchSate'] = false;
                $vars['doctorList'] = $this->cesampatient->getDoctorsList();
                
                if(!empty($_POST)){
                    $vars['category'] = $_POST['category'];
                    $vars['searchTerm'] = $_POST['searchTerm'];
                    $vars['allPatientsData'] = $this->cesampatient->dashPatientSearch($_POST);
                    $vars['nbPatients'] = count($vars['allPatientsData']);
                    $vars['searchSate'] = true;
                }
           
                
		$this->bktemplate->write('title', 'Cesam - Patients', TRUE);
		$this->bktemplate->write_view('header', '_content/zones/_header', $vars);
		$this->bktemplate->write_view('content', '_content/patients', $vars);
		$this->bktemplate->write_view('footer', '_content/zones/_footer');
		$this->bktemplate->render();
	}
	
	public function uploadFileAjax(){
		$this->cesamfile->uploadFile($_FILES, "patientFile");
	}
	/*
	 * Supprime un fichier du repertoire des upload et de la base de donnees
	 */
	public function deleteFileAjax(){
		if(!empty($_POST) && !empty($_POST['idFile'])){
			$idFile = $_POST['idFile'];
			$this->cesamfile->deleteFile($idFile);
			echo '1';
		}
		else echo '0';
	}
	
	public function telCell_check($str){
		$this->load->library('form_validation');
		if(empty($str)) return true;
		
		if (!preg_match("/^\d{2}[- .]?\d{2}[- .]?\d{2}[- .]?\d{2}$/", $str))
		{
			$this->form_validation->set_message('telCell_check', '<li>Le format du <b>%s</b> est : 07 97 23 50 , 07-97-23-50 ou 07.97.23.50</li>');
			return FALSE;
		}
		else return TRUE;
	}

	public function date_check($str){
		$this->load->library('form_validation');
		
		if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $str))
		{
			$this->form_validation->set_message('date_check', '<li>Le format du champ <b>%s</b> est : AAAA-MM-JJ</li>');
			return FALSE;
		}
		else return TRUE;
	}

        
	public function datetime_check($str){
		$this->load->library('form_validation');
		
		if (!preg_match("/^([0-9]{2,4})-([0][0-9]|1[0-2])-([0-2][0-9]|3[0-1]) (?:([0-1][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9]))?$/", $str))
		{
			$this->form_validation->set_message('datetime_check', '<li>Le format du <b>%s</b> est : 2012-11-23 12:30:11</li>');
			return FALSE;
		}
		else return TRUE;
	}
	
	public function addNewPatient() {		
		$this->bktemplate->add_js('public/js/patientFileUpload.js');
		$this->bktemplate->add_js('public/lib/jqueryformplugin/jquery.form.js');
		
		$dataPost = array();
		
		// Creation d'un nouveau patient
		if(!empty($_POST)){    
                    $dataPost = $this->cesampatient->addNewPatient($_POST);
		}
                
		// Permet de supprimer les fichiers sans patient
		$this->cesamfile->cleanDirAndDb(date('Y-m-d'));
		
		$vars = array();
		$vars['pageId'] = $this->pageID;
		$vars['leftBoxData'] = array();
                $vars['doctorsList'] = $this->cesampatient->getDoctorsList(); 
		$vars['dataPatient'] = $dataPost;
		
		$this->bktemplate->write('title', 'Cesam - Ajouter Patient', TRUE);
		$this->bktemplate->write_view('header', '_content/zones/_header', $vars);
		$this->bktemplate->write_view('content', '_content/addNewPatient', $vars);
		$this->bktemplate->write_view('footer', '_content/zones/_footer');
		$this->bktemplate->render();
	}
	
	public function recordPatient() {		
		$this->bktemplate->add_js('public/js/patientFileUpload.js');
		$this->bktemplate->add_js('public/lib/jqueryformplugin/jquery.form.js');
				
		$vars = array();
		$vars['pageId'] = $this->pageID;
		$vars['leftBoxData'] = array();
		$vars['addPatientOK'] = $this->session->userdata('addPatientOK');
                $vars['modifyPatientOK'] = $this->session->userdata('modifyPatientOK');

                $idPatient = $this->uri->segment(3);
		if(!empty($idPatient) && is_numeric($idPatient)){
			// tester si l'id passe est numeric
			$recordData = $this->cesampatient->getPatientRecordData($idPatient);
			//echo '<pre>';
			//print_r($recordData);
			//echo '</pre>';
			$vars['recordData'] = $recordData;
		}
                
		// Permet de supprimer les fichiers sans patient
		$this->cesamfile->cleanDirAndDb(date('Y-m-d'));
		
                
		$this->bktemplate->write('title', 'Cesam - Fiche Patient', TRUE);
		$this->bktemplate->write_view('header', '_content/zones/_header', $vars);
		$this->bktemplate->write_view('content', '_content/recordPatient', $vars);
		$this->bktemplate->write_view('footer', '_content/zones/_footer');
		$this->bktemplate->render();
	}
        
        public function modifyPatient(){
            		
		$this->bktemplate->add_js('public/js/patientFileUpload.js');
		$this->bktemplate->add_js('public/lib/jqueryformplugin/jquery.form.js');
		$vars = array();
                $idPatient = $this->uri->segment(3);

                if(!empty($_POST)){  
                    $idPatient = $_POST['patient_id'];
                    $this->cesampatient->modifyPatient($_POST);
		}
                
                
		if(!empty($idPatient) && is_numeric($idPatient)){
			
			$recordData = $this->cesampatient->getPatientRecordData($idPatient);
			$vars['recordData'] = $recordData;
		}
                
                
		// Permet de supprimer les fichiers sans patient
		$this->cesamfile->cleanDirAndDb(date('Y-m-d'));
		
		
		$vars['pageId'] = $this->pageID;
		$vars['leftBoxData'] = array();
                $vars['doctorsList'] = $this->cesampatient->getDoctorsList(); 
                
		$this->bktemplate->write('title', 'Cesam - Modifier fiche', TRUE);
		$this->bktemplate->write_view('header', '_content/zones/_header', $vars);
		$this->bktemplate->write_view('content', '_content/modifyPatient', $vars);
		$this->bktemplate->write_view('footer', '_content/zones/_footer');
		$this->bktemplate->render();
        }

}

?>