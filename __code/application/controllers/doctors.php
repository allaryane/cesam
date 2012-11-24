<?php

/* * ********************Encoding : UTF-8 ******************************\

 * 	Fichier			: doctors.php
 * 	Projet			: pickmeup
 * 	Version			: 1 sept. 2012 05:17:12
 * 	Auteur			: Ryane Alla // allaryane@gmail.com
 *  \************************************************************************* */


/**
 * @property CesamDoctor $cesamdoctor
*/
class Doctors extends CI_Controller {

	private $pageID = PAGE_ID_DOCTORS;
	
	public function __construct() {
		parent::__construct();
		$this->bktemplate->add_css('public/css/doctors.css');
		$this->bktemplate->add_js('public/js/doctors.js');
	}

	public function index() {
		$vars = array();
		
		$vars['pageId'] = $this->pageID;
		$vars['leftBoxData'] = array();
                $dataDashPatient = $this->cesamdoctor->getDoctorsDashData();
                $vars['allDoctorsData'] = $dataDashPatient['allDoctorsData'];
                $vars['nbDoctors'] = $dataDashPatient['nbDoctors'];
                $vars['searchSate'] = false;
                
                if(!empty($_POST)){
                    $vars['searchTerm'] = $_POST['searchTerm'];
                    $vars['allDoctorsData'] = $this->cesamdoctor->dashDoctorSearch($_POST);
                    $vars['nbDoctors'] = count($vars['allDoctorsData']);
                    $vars['searchSate'] = true;
                }
           
                		
		$this->bktemplate->write('title', 'Cesam - Medecins', TRUE);
		$this->bktemplate->write_view('header', '_content/zones/_header', $vars);
		$this->bktemplate->write_view('content', '_content/doctors', $vars);
		$this->bktemplate->write_view('footer', '_content/zones/_footer');
		$this->bktemplate->render();
	}

        public function displayPassword(){
            $this->cesamdoctor->displayPassword($_POST);
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

	public function addNewDoctor() {		
            $vars = array();
            $vars['pageId'] = $this->pageID;
            $vars['leftBoxData'] = array();

            $dataPost = array();

            // Creation d'un nouveau docteur
            if(!empty($_POST)){    
                $dataPost = $this->cesamdoctor->addNewDoctor($_POST);
            }
            $vars['dataPatient'] = $dataPost;

            $this->bktemplate->write('title', 'Cesam - Ajouter Docteur', TRUE);
            $this->bktemplate->write_view('header', '_content/zones/_header', $vars);
            $this->bktemplate->write_view('content', '_content/addNewDoctor', $vars);
            $this->bktemplate->write_view('footer', '_content/zones/_footer');
            $this->bktemplate->render();
	}
        
        public function recordDoctor() {		
	
		$vars = array();
		$vars['pageId'] = $this->pageID;
		$vars['leftBoxData'] = array();
		$vars['addDoctorOK'] = $this->session->userdata('addDoctorOK');
                $vars['modifyDoctorOK'] = $this->session->userdata('modifyDoctorOK');

                $idDoctor = $this->uri->segment(3);
		if(!empty($idDoctor) && is_numeric($idDoctor)){
			// tester si l'id passe est numeric
			$recordData = $this->cesamdoctor->getDoctorRecordData($idDoctor);
			$vars['recordData'] = $recordData;
		}
                
                
		$this->bktemplate->write('title', 'Cesam - Fiche Médecin', TRUE);
		$this->bktemplate->write_view('header', '_content/zones/_header', $vars);
		$this->bktemplate->write_view('content', '_content/recordDoctor', $vars);
		$this->bktemplate->write_view('footer', '_content/zones/_footer');
		$this->bktemplate->render();
	}
        
        public function modifyDoctor(){
        
		$vars = array();
                $idDoctor = $this->uri->segment(3);

                if(!empty($_POST)){  
                    $idDoctor = $_POST['doctor_id'];
                    $this->cesamdoctor->modifyDoctor($_POST);
		}
                
                
		if(!empty($idDoctor) && is_numeric($idDoctor)){
			
			$recordData = $this->cesamdoctor->getDoctorRecordData($idDoctor);
			$vars['recordData'] = $recordData;
                }
                
		
		$vars['pageId'] = $this->pageID;
		$vars['leftBoxData'] = array();
                
		$this->bktemplate->write('title', 'Cesam - Modifier fiche', TRUE);
		$this->bktemplate->write_view('header', '_content/zones/_header', $vars);
		$this->bktemplate->write_view('content', '_content/modifyDoctor', $vars);
		$this->bktemplate->write_view('footer', '_content/zones/_footer');
		$this->bktemplate->render();
        }


}

?>