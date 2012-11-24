<?php
/* * ********************Encoding : UTF-8 ******************************\

 * 	Fichier			: CesamPatient.php
 * 	Projet			: cesam
 * 	Version			: 10 nov. 2012 13:50:19
 * 	Auteur			: Ryane Alla // allaryane@gmail.com
 *  \************************************************************************* */

/**
 * @property CI_Controller $CI
 * @property User_model $user_model
 * @property File_model $file_model
 * @property Patient_model $patient_model
 */
class CesamPatient {
		
    public function __construct(){
		// Ne pas recuperer l'instance du controleur dans le constructeur
		// car l'objet peut etre instancier par un controleur et etre manipuler
		// par un autre
    }

    public function dashPatientSearch($dataPost){
        $CI = & get_instance();
        $CI->load->model(array('patient_model'));
        $searchTerm = $dataPost['searchTerm'];
        $category = $dataPost['category'];
        
        switch ($category) {
            case SEARCH_BY_NAME:
                return $CI->patient_model->searchPatientByName($searchTerm);
                break;
            
            case SEARCH_BY_CESAM_DOSSIER_NUM:
                return $CI->patient_model->searchByCesamDossierNum($searchTerm);
                break;

            case SEARCH_BY_DOCTOR_NAME:
                $doctors = $CI->user_model->searchDoctorByName($searchTerm);
                if(!empty($doctors)){
                    $doctorIdList = array();
                    foreach ($doctors as $doc){ 
                        if(count($doctors) == 1) $doc = $doctors;
                        array_push($doctorIdList, $doc->id);
                        if(count($doctors) == 1) break;
                    }
                    $doctorIdListForInCLause = implode(',', $doctorIdList);
                    return $CI->patient_model->searchByDoctorIdList($doctorIdListForInCLause);
                }
                else return array(); 
                
                break;

            
            default:
                return array();
                break;
        }
    }
    
    public function getDoctorsList(){
         $CI = & get_instance();
         $CI->load->model(array('user_model'));
         return $CI->user_model->getListActiveDoctor();
    }

    
    public function getPatientsList(){
         $CI = & get_instance();
         $CI->load->model(array('patient_model'));
         return $CI->patient_model->getAllActivePatients();
    }
    
    public function getPatientsDashData(){
        $CI = & get_instance();
        $CI->load->model(array('patient_model','file_model'));
        $allPatients = $this->getPatientsList();
        $dataDashPatient['allPatientsData'] = $allPatients;
        $dataDashPatient['nbPatients'] = count($allPatients);
        $dataDashPatient['nbFiles'] = count($CI->file_model->getAllActiveFiles());
        return $dataDashPatient;
    }
    
    public function getPatientRecordData($idPatient){
        $CI = & get_instance();
        $CI->load->model(array('patient_model','file_model','user_model'));
        // Objet contenant les informations sur le patient
        $infosPatientObj = $CI->patient_model->getActivePatientData($idPatient);
        if(empty($infosPatientObj)) return array();
        // Tableau des fichiers attaches au patient avec la structure:
        //  [idFile1] => objetDateFile1,[idFile2] => objetDateFile2
        $arrayFiles = $CI->file_model->getAllPatientActiveFiles($idPatient);
        $doctorId = $CI->patient_model->getPatientDoctorId($idPatient);
        $userObj = $CI->user_model->getUserData($doctorId, true);
        if(empty($userObj)) $doctorName = ''; 
        else $doctorName = $userObj->last_name.' '.$userObj->first_name; 
        $recordData = array('infosPatientObj' => $infosPatientObj,
                                                'doctorName' => $doctorName,
                                                'doctorId' => $doctorId,
                                                'arrayFiles' => $arrayFiles);
        return $recordData;
    }

    private function validateRules($CI){

        $CI->form_validation->set_rules('patientLastName', 'Nom', 'required');
        $CI->form_validation->set_rules('patientFirstName', 'Prénom(s)', 'required');
        $CI->form_validation->set_rules('sexe', 'Sexe', 'required');
        $CI->form_validation->set_rules('notes', 'Notes', 'max_length[500]');

        $CI->form_validation->set_rules('date_naissance', 'Date de naissance', 'required|callback_date_check');
        $CI->form_validation->set_rules('prelevement', 'Date et heure de prélèvement', 'required|callback_datetime_check');
        $CI->form_validation->set_rules('ordonnance', 'Date de l\'ordonnance', 'required|callback_date_check');
        $CI->form_validation->set_rules('telCell', 'N° de Tel ou Cell', 'callback_telCell_check');
        $CI->form_validation->set_rules('num_dossier', 'N° de dossier Cesam', 'required');
        $CI->form_validation->set_rules('assignation', 'Assigner le patient au Dr', 'required');
        $CI->form_validation->set_rules('statut', 'Statut examen(s)', 'required');

        // Configuration des messages d'erreurs
        $CI->form_validation->set_message('required', '<li>Le champ <b>%s</b> est obligatoire</li>');
        $CI->form_validation->set_message('max_length', '<li>Le champ <b>%s</b> doit contenir maximum 500 caractères</li>');		            
        }
	
    public function addNewPatient($dataPost){
        $CI = & get_instance();
        $CI->load->model(array('patient_model','file_model'));
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
                $dataToInsert = array('first_name' => $dataPost['patientFirstName'],
                                                          'last_name' => $dataPost['patientLastName'],
                                                          'sexe' => $dataPost['sexe'],
                                                          'notes' => $dataPost['notes'],
                                                          'birthday' => $dataPost['date_naissance'],
                                                          'prelevement' => $dataPost['prelevement'],
                                                          'ordonnance' => $dataPost['ordonnance'],
                                                          'tel_cell' => $dataPost['telCell'],
                                                          'create_date' => date('Y-m-d H:i:s'),
                                                          'num_dossier_cesam' => $dataPost['num_dossier'],
                                                          'dossier_state' => $dataPost['statut']);

                $idPatient = $CI->patient_model->insertNewPatientData($dataToInsert);
                $CI->patient_model->linkPatientToDoctor($idPatient, $dataPost['assignation']);

                if(!empty($dataPost['filesUpload'])){
                        $arrayFiles = $dataPost['filesUpload'];
                        foreach ((array)$arrayFiles as $oneFile) {
                                $tab = preg_split('/;/',$oneFile);
                                $idFile = $tab[1];
                                $CI->file_model->linkFileToPatient($idPatient, $idFile);
                        }	
                }

                $CI->session->set_userdata(array('addPatientOK' => true));
                redirect(base_url().'patients/recordPatient/'.$idPatient);			
        }
		
    }
	
    public function modifyPatient($dataPost){
        $CI = & get_instance();
        $CI->load->model(array('patient_model','file_model'));
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
                $dataToInsert = array('first_name' => $dataPost['patientFirstName'],
                                                          'last_name' => $dataPost['patientLastName'],
                                                          'sexe' => $dataPost['sexe'],
                                                          'notes' => $dataPost['notes'],
                                                          'birthday' => $dataPost['date_naissance'],
                                                          'prelevement' => $dataPost['prelevement'],
                                                          'ordonnance' => $dataPost['ordonnance'],
                                                          'tel_cell' => $dataPost['telCell'],
                                                          //'modify_date' => date('Y-m-d H:i:s'),
                                                          'num_dossier_cesam' => $dataPost['num_dossier'],
                                                          'dossier_state' => $dataPost['statut']);
                $idPatient = $dataPost['patient_id'];
                $CI->patient_model->updatePatientData($dataToInsert, $idPatient);
                $CI->patient_model->deleteDoctorLinkFromPatient($idPatient);
                $CI->patient_model->linkPatientToDoctor($idPatient, $dataPost['assignation']);

                if(!empty($dataPost['filesUpload'])){
                        $arrayFiles = $dataPost['filesUpload'];
                        foreach ((array)$arrayFiles as $oneFile) {
                                $tab = preg_split('/;/',$oneFile);
                                $idFile = $tab[1];
                                if(count($tab) < 3){
                                    $CI->file_model->linkFileToPatient($idPatient, $idFile);
                                } 

                        }	
                }

                $CI->session->set_userdata(array('modifyPatientOK' => true));
                redirect(base_url().'patients/recordPatient/'.$idPatient);			
        }
		            
    }
        
}


?>
