<?php

/* * ********************Encoding : UTF-8 ******************************\

 * 	Fichier			: patient_model.php
 * 	Projet			: cesam
 * 	Version			: 10 nov. 2012 02:43:02
 * 	Auteur			: Ryane Alla // allaryane@gmail.com
 *  \************************************************************************* */


class Patient_model extends CI_Model {
        private $patientFields = 'patient.id, num_dossier_cesam,first_name,last_name,sexe,notes,birthday,prelevement,ordonnance,tel_cell,create_date,active,dossier_state';
	private $table_patient = 'patient';
	private $table_patient_doctor = 'patient_doctor';
	
	public function __construct() {
            parent::__construct();
            $this->load->database();
	}

        private function __($searchTerm){
            $secureSql = mysql_real_escape_string(trim($searchTerm));
            return $secureSql;
        }
        
	public function insertNewPatientData($data){
            $this->db->insert($this->table_patient, $data);
            return $this->db->insert_id();
	}
        
        
	public function updatePatientData($data, $idPatient){
            $this->db->update($this->table_patient, $data, array('id' => $idPatient));
	}
	
	public function deletePatient($idPatient){
            $this->db->delete($this->table_patient, array('id' => $idPatient)); 
	}
	
	public function disbalePatient($idPatient){
            $data = array('active' => 0);
            $this->db->update($this->table_patient, $data, array('id' => $idPatient));
	}
	
        
        public function getAllActivePatientsByDoctorId($idDoctor){
            $query = $this->db->select($this->patientFields)
            ->from($this->table_patient)
            ->join($this->table_patient_doctor, 'patient.id = id_patient AND id_doctor = '.$idDoctor)
            ->get();
             $array_objects_results = $query->result();
            return (!empty($array_objects_results)) ? ((count($array_objects_results) == 1) ? $array_objects_results[0] : $array_objects_results) : NULL;    
        }
        
        
	public function linkPatientToDoctor($idPatient, $idDoctor){
            
            $data = array('id_patient' => $idPatient, 'id_doctor' => $idDoctor);
            $this->db->insert($this->table_patient_doctor, $data);
	}
	
        
        
	public function deleteDoctorLinkFromPatient($idPatient){
            $this->db->delete($this->table_patient_doctor, array('id_patient' => $idPatient)); 
	}
	
	public function getPatientDoctorId($idPatient){
            $query = $this->db->select('id_doctor')
            ->from($this->table_patient_doctor)
            ->where('id_patient', $idPatient)
            ->get();

            $obj = $query->result();
            if((count($obj) == 1)){
                    $obj =   $obj[0];
                    return $obj->id_doctor;
            }
            else return 0;	
	}

        public function getAllActivePatients(){
            $query = $this->db->select('*')
            ->from($this->table_patient)
            ->join($this->table_patient_doctor, 'patient.id = id_patient')
            ->where('active', 1)
            ->order_by("create_date", "desc")
            ->get();
            $array_objects_results = $query->result();
            return (!empty($array_objects_results)) ? ((count($array_objects_results) == 1) ? $array_objects_results[0] : $array_objects_results) : NULL;
	}
        
	public function getActivePatientData($idPatient){
            $query = $this->db->select('*')
            ->from($this->table_patient)
            ->where('id', $idPatient)
            ->where('active', 1)
            ->get();
            $array_objects_results = $query->result();
            return (!empty($array_objects_results)) ? ((count($array_objects_results) == 1) ? $array_objects_results[0] : $array_objects_results) : NULL;
	}
	
	public function setDossierState($idPatient, $state){
            $arrayState = array(STATE_PENDING, STATE_DONE, STATE_PROGRESS);
            if(in_array($state, $arrayState)){
                    $data = array('dossier_state' => $state);
                    $this->db->update($this->table_patient, $data, array('id' => $idPatient));
                    return true;
            }
            else return false;
	}
	
        
        public function searchByDoctorIdList($idDoctorList){
            $query = $this->db->select('*')
            ->from($this->table_patient)
            ->join($this->table_patient_doctor, 'patient.id = id_patient AND id_doctor IN('.$idDoctorList.')')
            ->order_by("create_date", "desc")
            ->get();
            $array_objects_results = $query->result();
            return (!empty($array_objects_results)) ? ((count($array_objects_results) == 1) ? $array_objects_results[0] : $array_objects_results) : NULL;    
        }
        
        
        public function searchByCesamDossierNum($searchTerm, $idDoctor = ''){
            $restriction = '';
            if(!empty($idDoctor)) $restriction = ' AND id_doctor = '.$idDoctor;
            $query = $this->db->select('*')
            ->from($this->table_patient)
            ->join($this->table_patient_doctor, 'patient.id = id_patient'.$restriction)
            ->where('active', 1)
            ->like('num_dossier_cesam', $searchTerm)
            ->order_by("create_date", "desc")
            ->get();

            $array_objects_results = $query->result();
            return (!empty($array_objects_results)) ? ((count($array_objects_results) == 1) ? $array_objects_results[0] : $array_objects_results) : NULL; 
        }
        
        
        
        
	public function searchPatientByName($searchTerm, $idDoctor = ''){
            $restriction = '';
            if(!empty($idDoctor)) $restriction = ' AND id_doctor = '.$idDoctor;
            $queryString = "SELECT * FROM patient
                            JOIN patient_doctor ON patient.id = id_patient ".$restriction."
                            WHERE active = 1 AND 
                            (first_name LIKE '%".$this->__($searchTerm)."%' OR last_name LIKE '%".$this->__($searchTerm)."%' ) 
                            ORDER BY create_date desc";
            $query = $this->db->query($queryString);

            //echo $this->db->last_query(); 

            $array_objects_results = $query->result();
            return (!empty($array_objects_results)) ? ((count($array_objects_results) == 1) ? $array_objects_results[0] : $array_objects_results) : NULL;
	}
	

}

?>
