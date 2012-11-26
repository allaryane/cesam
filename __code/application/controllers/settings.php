<?php

/* * ********************Encoding : UTF-8 ******************************\

 * 	Fichier			: settings.php
 * 	Projet			: pickmeup
 * 	Version			: 1 sept. 2012 05:17:12
 * 	Auteur			: Ryane Alla // allaryane@gmail.com
 *  \************************************************************************* */


/**
 * @property Settings_model $settings_model
 * @property User_model $user_model
 */

class Settings extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->bktemplate->add_css('public/css/settings.css');
        $this->bktemplate->add_js('public/js/settings.js');

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

    public function password_check($pwd){
        $this->load->library('form_validation');
        $this->load->model(array('user_model'));

        if ($this->user_model->isLoginOk('root', $pwd) == 0)
        {
                $this->form_validation->set_message('password_check', "<li>L'<b>%s</b> entré est erroré</li>");
                return FALSE;
        }
        else return TRUE;
    }


    private function validateCHANGE_PASSWORD(){
        $this->form_validation->set_rules('currentPassword', 'Actuel mot de passe', 'required|callback_password_check');
        $this->form_validation->set_rules('newPassword', 'Nouveau mot de passe', 'required|min_length[6]');
        $this->form_validation->set_rules('confirmNewPassword', 'Confirmation nouveau mot de passe', 'required|matches[newPassword]');
    }
    
    private function validateROOT_INFOS(){
        $this->form_validation->set_rules('email', 'Adresse email', 'required|valid_email');
        $this->form_validation->set_rules('tel', 'Téléphone bureau', 'callback_telCell_check');
        $this->form_validation->set_rules('cell', 'Téléphone cellulaire', 'callback_telCell_check');
    }
    
    private function validateSETTINGS_SYS(){
        $this->form_validation->set_rules('nbResultsByPageRoot', 'Nb resultats par page pour le Root', 'required|numeric');
        $this->form_validation->set_rules('nbResultsByPageDoctor', 'Nb resultats par page pour le Médecin', 'required|numeric');
        $this->form_validation->set_rules('emailNotify', 'Notifications par email', 'required');
        $this->form_validation->set_rules('purgeDateConnexionLog', 'Date de suppresion de l\'historique de connexion', 'callback_date_check');
    }
    
    private function manageUpdateSettings($dataPost){
        $this->load->model(array('user_model', 'settings_model'));
        $this->load->library('form_validation');
        
        // Configuration des messages d'erreurs
        $this->form_validation->set_message('required', '<li>Le champ <b>%s</b> est obligatoire</li>');
        $this->form_validation->set_message('numeric', '<li>Le champ <b>%s</b> doit être un nombre entier entre 1 et 99</li>');
        $this->form_validation->set_message('min_length', '<li>Le <b>mot de passe</b> doit contenir au moins 6 caractères</li>');
        $this->form_validation->set_message('matches', '<li>Le champ <b>%s</b> et <b>Confirmation doivent etre les mêmes</b>');
        $this->form_validation->set_message('valid_email', '<li>Le champ <b>%s</b> doit etre une adresse email valide : monadressemail@gmail.com</li>');		            

        
        switch ($dataPost['section']) {
            case 'CHANGE_PASSWORD':
                $this->validateCHANGE_PASSWORD();
                // Succes de la validation
                if ($this->form_validation->run() == TRUE)
                {
                    $data = array('password' => $dataPost['newPassword']);
                    $this->user_model->updateUserData($data, 1);
                    $this->session->set_userdata(array('CHANGE_PASSWORD_OK' => 'OK'));
                }
                else $this->session->set_userdata(array('CHANGE_PASSWORD_OK' => 'KO'));

                break;
            
                
            case 'ROOT_INFOS':
                $this->validateROOT_INFOS();
                // Succes de la validation
                if ($this->form_validation->run() == TRUE)
                {
                    $data = array('email' => $dataPost['email'],
                                  'tel'   => $dataPost['tel'],
                                  'cell'  => $dataPost['cell']);
                    $this->user_model->updateUserData($data, 1);
                    $this->session->set_userdata(array('ROOT_INFOS_OK' => 'OK'));
                }
                else $this->session->set_userdata(array('ROOT_INFOS_OK' => 'KO'));
                break;
            
                
            case 'SETTINGS_SYS':
                $this->validateSETTINGS_SYS();
                // Succes de la validation
                if ($this->form_validation->run() == TRUE)
                {
                    $data = array('root_nb_results_by_page' => $dataPost['nbResultsByPageRoot'],
                                  'doctor_nb_results_by_page'   => $dataPost['nbResultsByPageDoctor'],
                                  'email_notifications'  => $dataPost['emailNotify'],
                                  'purge_date_connexion_log' => $dataPost['purgeDateConnexionLog']);
                    
                    $this->settings_model->updateSettings($data);
                    $this->session->set_userdata(array('SETTINGS_SYS_OK' => 'OK'));
                }
                else $this->session->set_userdata(array('SETTINGS_SYS_OK' => 'KO'));
                break;

                
            default:
                //Erreur Inconnue. Surement un rebot qui essaie de faire des post sans passer par le formulaire.
                //redirect()
                break;
        }
        
    }
    
    public function index() {
        $this->load->model(array('user_model', 'settings_model'));
        $vars = array();
        $vars['pageId'] = PAGE_ID_SETTINGS;
        $vars['leftBoxData'] = array();
 
        if(!empty($_POST) && !empty($_POST['section'])){
            $this->manageUpdateSettings($_POST);
        }
        
        $vars['CHANGE_PASSWORD_OK'] = $this->session->userdata('CHANGE_PASSWORD_OK');
        $vars['ROOT_INFOS_OK'] = $this->session->userdata('ROOT_INFOS_OK');
        $vars['SETTINGS_SYS_OK'] = $this->session->userdata('SETTINGS_SYS_OK');
        
        $vars['rootInfos'] = $this->user_model->getUserData(1);
        $vars['settingsArray'] = $this->settings_model->getSettings();
        

        $this->bktemplate->write('title', 'Cesam - Parametres', TRUE);
        $this->bktemplate->write_view('header', '_content/zones/_header', $vars);
        $this->bktemplate->write_view('content', '_content/settings', $vars);
        $this->bktemplate->write_view('footer', '_content/zones/_footer');
        $this->bktemplate->render();
    }

}

?>