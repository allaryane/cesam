<?php

/* * ********************Encoding : UTF-8 ******************************\

 * 	Fichier			: CesamDoctor.php
 * 	Projet			: cesam
 * 	Version			: 10 nov. 2012 13:50:30
 * 	Auteur			: Ryane Alla // allaryane@gmail.com
 *  \************************************************************************* */


/**
 * @property CI_Controller $CI
 * @property User_model $user_model
 * @property File_model $file_model
 * @property Patient_model $patient_model
 */
class CesamDoctor {
    public function __construct(){
		// Ne pas recuperer l'instance du controleur dans le constructeur
		// car l'objet peut etre instancier par un controleur et etre manipuler
		// par un autre
    }
    
    public function displayPassword($dataPost){
        $CI = & get_instance();
        $CI->load->model(array('user_model'));
        if(!empty($_POST) && !empty($_POST['idDoctor']) && !empty($_POST['password'])){
                $idDoctor = $_POST['idDoctor'];
                $password = $_POST['password'];
                if($CI->user_model->isLoginOk('root' , $password) != 0){
                    $objDoctor = $CI->user_model->getUserData($idDoctor);
                    echo $objDoctor->password;
                }
                else echo '0';
        }
        else echo '-1';
    }
    
    public function dashDoctorSearch($dataPost){
        $CI = & get_instance();
        $CI->load->model(array('user_model'));
        $searchTerm = $dataPost['searchTerm'];
        
        return $CI->user_model->searchDoctorByName($searchTerm);    
    }
    
    public function getDoctorListData(){
         $CI = & get_instance();
         $CI->load->model(array('user_model'));
         return $CI->user_model->getAllActiveDoctors();
    }

    public function getDoctorsDashData(){
        $CI = & get_instance();
        $CI->load->model(array('user_model'));
        $allDoctors = $this->getDoctorListData();
        $dataDashDoctors['allDoctorsData'] = $allDoctors;
        $dataDashDoctors['nbDoctors'] = count($allDoctors);
        return $dataDashDoctors;
    }
    
    public function getDoctorRecordData($idDoctor){
        $CI = & get_instance();
        $CI->load->model(array('patient_model','user_model'));
        // Objet contenant les informations sur le docteur
        $infosDoctorObj = $CI->user_model->getUserData($idDoctor);
        if(empty($infosDoctorObj)) return array();
        
        $arrayPatients = $CI->patient_model->getAllActivePatientsByDoctorId($idDoctor);
        $recordData = array('infosDoctorObj' => $infosDoctorObj,
                            'arrayPatientsObj' => $arrayPatients);
        return $recordData;
        
    }
    
    private function validateRules($CI){

        $CI->form_validation->set_rules('doctorLastName', 'Nom', 'required');
        $CI->form_validation->set_rules('doctorFirstName', 'Prénom(s)', 'required');
        $CI->form_validation->set_rules('code_permanent', 'Code permanent', 'required|callback_codePermanent_check');
        $CI->form_validation->set_rules('password', 'Mot de passe', 'required');
        $CI->form_validation->set_rules('email', 'Adresse email', 'valid_email');
        $CI->form_validation->set_rules('telCell', 'N° de Tel ou Cell', 'callback_telCell_check');
       
        // Configuration des messages d'erreurs
        $CI->form_validation->set_message('required', '<li>Le champ <b>%s</b> est obligatoire</li>');
        $CI->form_validation->set_message('valid_email', '<li>Le champ <b>%s</b> doit etre une adresse email valide : monadressemail@gmail.com</li>');		            
    }
	
    public function addNewDoctor($dataPost){
        $CI = & get_instance();
        $CI->load->model(array('user_model'));
        $CI->load->helper(array('form', 'url'));
        $CI->load->library('form_validation');
        
        $this->validateRules($CI);
        // Echec de la validation
        if ($CI->form_validation->run() == FALSE) return $dataPost;
        // Succes de la validation
        else
        {
            //echo '<pre>';
            //print_r($dataPost);
            //echo '</pre>';
            //die();
            
            $dataToInsert = array('first_name' => $dataPost['doctorFirstName'],
                                                      'last_name' => $dataPost['doctorLastName'],
                                                      'email' => $dataPost['email'],
                                                      'cell' => $dataPost['telCell'],
                                                      'type' => USER_TYPE_DOCTOR,
                                                      'ip_address' => ip2long($CI->input->ip_address()), 
                                                      'registration_date' => date('Y-m-d H:i:s'),
                                                      'password' => $dataPost['password'],
                                                      'username' => $dataPost['code_permanent']);

            $idDoctor = $CI->user_model->insertNewUserData($dataToInsert);


            $CI->session->set_userdata(array('addDoctorOK' => true));
            redirect(base_url().'doctors/recordDoctor/'.$idDoctor);			
        }
		
    }

    public function modifyDoctor($dataPost){
        $CI = & get_instance();
        $CI->load->model(array('user_model'));
        $CI->load->helper(array('form', 'url'));
        $CI->load->library('form_validation');
        //echo '<pre>';
        //print_r($dataPost);
        //echo '</pre>';

        $this->validateRules($CI);
        // Echec de la validation
        if ($CI->form_validation->run() == FALSE) return $dataPost;
        // Succes de la validation
        else
        {
    
                $dataToInsert = array('first_name' => $dataPost['doctorFirstName'],
                                                      'last_name' => $dataPost['doctorLastName'],
                                                      'email' => $dataPost['email'],
                                                      'cell' => $dataPost['telCell'],
                                                      'type' => USER_TYPE_DOCTOR,
                                                      'ip_address' => ip2long($CI->input->ip_address()), 
                                                      'registration_date' => date('Y-m-d H:i:s'),
                                                      'password' => $dataPost['password'],
                                                      'username' => $dataPost['code_permanent']);

            
                $idDoctor = $dataPost['doctor_id'];
                $CI->user_model->updateUserData($dataToInsert, $idDoctor);

                $CI->session->set_userdata(array('modifyDoctorOK' => true));
                redirect(base_url().'doctors/recordDoctor/'.$idDoctor);			
        }
		            
    }

}


?>
