<?php
/* * ****************** Entête UTF-8 ******************\
 *
 * 	File			: models/user_model.php
 * 	Projet			: PMU
 * 	Version			: 2012-03-21 17:04:00
 *  Auteur			: Ryane Alla
  \*************************************************** */

class User_model extends CI_Model {

    private $table_user = 'user';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    private function __($searchTerm){
        $secureSql = mysql_real_escape_string(trim($searchTerm));
        return $secureSql;
    }
    
    public function insertNewUserData($data){
        $this->db->insert($this->table_user, $data);
        return $this->db->insert_id();
    }

    public function updateUserData($data, $idUser){
        $this->db->update($this->table_user, $data, array('id' => $idUser));
    }

    public function deleteUser($idUser){
        $this->db->delete($this->table_user, array('id' => $idUser)); 
    }

    public function disbaleUser($idUser){
        $data = array('active' => 0);
        $this->db->update($this->table_user, $data, array('id' => $idUser));
    }
    /*
     * Permet de recuperer tous les champs du user dont le id est passe en argument
     * return :
     */
    public function getUserData($idUser = 1, $is_doctor=false){
        $query = $this->db->select('*')
        ->from($this->table_user);
        
        if($is_doctor){
            $query = $query->where('id', $idUser)
                     ->where('active', 1);
            $query = $query->where('type' , USER_TYPE_DOCTOR);
        }
        else $query = $query->where('type' , USER_TYPE_ROOT);
            
        $query = $query->get();
        $array_objects_results = $query->result();
        return (!empty($array_objects_results)) ? ((count($array_objects_results) == 1) ? $array_objects_results[0] : $array_objects_results) : array();
    }

    public function searchDoctorByName($searchTerm){
        $queryString = "SELECT * FROM user WHERE type = 'DOCTOR' AND active = 1 AND
                        (first_name LIKE '%".$this->__($searchTerm)."%' OR
                        last_name LIKE '%".$this->__($searchTerm)."%' ) 
                        ORDER BY registration_date desc";
        $query = $this->db->query($queryString);
        //echo $this->db->last_query(); 

        $array_objects_results = $query->result();
        return (!empty($array_objects_results)) ? ((count($array_objects_results) == 1) ? $array_objects_results[0] : $array_objects_results) : array();
    }
        
    public function getAllActiveDoctors(){
        $query = $this->db->select('id,first_name,last_name,username,password,email,tel,registration_date,is_connected')
        ->from($this->table_user)
        ->where('type', USER_TYPE_DOCTOR)
        ->where('active', 1)
        ->order_by("registration_date", "desc")
        ->get();
        $array_objects_results = $query->result();
        return (!empty($array_objects_results)) ? ((count($array_objects_results) == 1) ? $array_objects_results[0] : $array_objects_results) : array();
    }
 
	
    public function getListActiveDoctor($forLog = false){
        $listDoctor = array();
        $query = $this->db->select('id,first_name,last_name')
        ->from($this->table_user);
        
        if(!$forLog) $query = $query->where('active', 1);
        
        $query = $query->where('type', USER_TYPE_DOCTOR)
        ->order_by("registration_date", "desc")
        ->get();
        $array_objects_results = $query->result();
        $array_objects_results = (!empty($array_objects_results)) ? ((count($array_objects_results) == 1) ? $array_objects_results[0] : $array_objects_results) : array();

        if(!empty($array_objects_results)){
                foreach ($array_objects_results as $doctor) {
                    if(count($array_objects_results) == 1) $doctor = $array_objects_results;
                    $listDoctor[$doctor->id] = $doctor->last_name.' '.$doctor->first_name;
                    if(count($array_objects_results) == 1) break;
                }
                return $listDoctor;
        }
        return array();
    }
	
	
	
    public function usernameExist($username){
            $query = $this->db->select('username')
                ->from($this->table_user)
                ->where('username', $username)
                ->get();	
		
            if ($query->num_rows() > 0) return true;
            else return false;
	}


	/*
	 * Verifie si les donnees d'authentification sont correctes
	 * return : int. idUser donnees corrects - 0 dans le cas contraire
	 */
	public function isLoginOk($username , $password){
            $query = $this->db->select('*')
            ->from($this->table_user)
            ->where('username', $username)
            ->where('password', $password)
            ->get();	
            if ($query->num_rows() > 0) {
                    $row = $query->row();
                    return $row->id; 
            }
            else return 0;
	}
	
	
	/*
	 * Verifie si le user est connecte : le champ is_connected est a 0000-00-00 00:00:00 si le user est deconnecte.
	 * return : boolean. True si le user est connecte - False dans le cas contraire
	 */
	public function isConnected($idUser){
		$query = $this->db->select()
                ->from($this->table_user)
				->where('id', $idUser)
                ->where('is_connected IS NOT NULL')
                ->get();	
		if ($query->num_rows() > 0) return true;
		else return false;		
	}

	/*
	 * Set le datetime de connexion dans le champ is_connected.
	 */
	public function setConnected($idUser){
		$data = array('is_connected' => date("Y-m-d H:i:s"));
        $this->db->update($this->table_user, $data, array('id' => $idUser));
	}

	/*
	 * Retourne l'adresse IP correspondant a l'idUser
	 */
	public function getIpAdress($idUser){
		$query = $this->db->select('ip_address')
                ->from($this->table_user)
                ->where('id', $idUser)
                ->get();	
		if ($query->num_rows() > 0) {
			$row = $query->row();
			return long2ip($row->ip_address); 
		}
		else return 0;		
	}

	/*
	 * Set l'adresse ip de l'utilisateur dans le champ ip_address.
	*/
	public function setIpAddress($idUser){
		$data = array('ip_address' => ip2long($this->input->ip_address()));
        $this->db->update($this->table_user, $data, array('id' => $idUser));
	}
	

	/*
	 * Deconnecte le user en mettant le champ is_connected a 0000-00-00 00:00:00.
	 * La librairie User s'occupera de detruire la variable de session et eventuellement les cookiees
	 * return : boolean. True si l'operation s'est bien passee - False dans le cas contraire
	 */
	public function disconnect($iduser){
            $data = array('is_connected' => NULL);
            $this->db->update($this->table_user, $data, array('id' => $idUser));
	}
}

?>
