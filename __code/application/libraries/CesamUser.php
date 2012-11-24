<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* * **************************************************\
 * 	Fichier			: librairies/PmuUser.php
 * 	Projet			: PMU
 * 	Version			: 2012/06/01 17:19
 *	Auteur			: Ryane Alla
 \*************************************************** */

/**
 * @property CI_Controller $CI
 * @property User_model $user_model
 */
class CesamUser  {
		
    public function __construct(){
		// Ne pas recuperer l'instance du controleur dans le constructeur
		// car l'objet peut etre instancier par un controleur et etre manipuler
		// par un autre
    }

	private function manageRedirection($action, $redirectionCode){
		switch ($action) {
			case LOGIN:
				switch ($redirectionCode){
					case 'OK':
						redirect(base_url().LOGIN_OK_URL);
						break;
					case 'FAILED':
						redirect(base_url().LOGIN_FAILED_URL);
						break;

					case 'ACTIVATE_REGISTRATION_REQUIRED':
						redirect(base_url().LOGIN_ACTIVATE_REGISTRATION);
						break;
					
					default:
						// Attention : Ajout d'un message d'erreur lors de la redirection
						redirect(base_url().ERROR_URL);
						break;
				}
				break;
			
			case LOGOUT:
				switch ($redirectionCode){
					case 'OK':
						redirect(base_url().LOGOUT_OK_URL);
						break;
					
					default:
						// Attention : Ajout d'un message d'erreur lors de la redirection
						redirect(base_url().ERROR_URL);
						break;
				}
				break;

			default:
				// Attention : Ajout d'un message d'erreur lors de la redirection
				redirect(ERROR_URL);
				break;
		}
	}
		
    /**
     * Login and sets session variables
     * @param    string
     * @param    string
     * @return    void
     */
    public function login($dataPost) {
		$CI =  & get_instance();
		$CI->load->model(array('user_model'));
		$CI->load->library("session");
		$CI->load->helper('email');

		$sessionID = $CI->session->userdata('session_id');

		if(empty($sessionID)) $this->manageRedirection (LOGIN, 'FAILED');
		
		
		//Check if user is already logged in
		if($CI->session->userdata('logged_in')) $this->manageRedirection(LOGIN, 'OK');
		
		//Make sure login info was sent
		$username = '';
		$password = '';
		
		if(!isset($dataPost) OR empty($dataPost)){
			$CI->session->set_userdata(array('loginDivError' => LOGIN_FAILED_FIELDS_REQUIRED));
			$this->manageRedirection (LOGIN, 'FAILED');
		}
		else{
			$username = $dataPost['username'];
			$password = $dataPost['password'];	
		}
	
		// Verifie si le username et le password ont ete saisis
        if($username == '' OR $password == ''){
			$CI->session->set_userdata(array('loginDivError' => LOGIN_FAILED_FIELDS_REQUIRED));
			$this->manageRedirection(LOGIN, 'FAILED');		
		}		
		
		$idUser = $CI->user_model->isLoginOk($username , $password);
        if ($idUser > 0) {			
			$CI->user_model->setConnected($idUser);
			$CI->user_model->setIpAddress($idUser);
			$CI->session->set_userdata(array('loginDivError' => ''));
			// Remet a 0 le nb de tentative pour ce compte
			
				
			//Set session data
			$userData = $CI->user_model->getUserData($idUser);
			unset($userData->password);
			
			$CI->session->set_userdata(array('userLoginData' => $userData));
            //Set logged_in to true
            $CI->session->set_userdata(array('logged_in' => true));  
			
            //Login was successful            
			$this->manageRedirection(LOGIN, 'OK');
			
        } else {
			if(!$CI->user_model->usernameExist($username)){
				$CI->session->set_userdata(array('loginDivError' => LOGIN_FAILED_USERNAME_NOT_VALID));
			}else{
				$CI->session->set_userdata(array('loginDivError' => LOGIN_FAILED_PASSWORD_NOT_VALID));
				// Incremente le nb de tentative pour ce compte
				
			}
            //No database result found
            $this->manageRedirection(LOGIN, 'FAILED');
        }    
    }

    /**
     * Logout user
     * @return    void
     */
    function logout() {
        $CI = & get_instance();
        $CI->load->model(array('user_model'));
        $CI->load->library("session");
        //Destroy session
        $CI->session->sess_destroy();
        $this->manageRedirection(LOGOUT, 'OK');
    }
}

?>
