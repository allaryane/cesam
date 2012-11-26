<?php

/* * ********************Encoding : UTF-8 ******************************\

 * 	Fichier			: file_model.php
 * 	Projet			: cesam
 * 	Version			: 10 nov. 2012 02:42:48
 * 	Auteur			: Ryane Alla // allaryane@gmail.com
 *  \************************************************************************* */


class File_model extends CI_Model {

	private $table_file = 'file';
	private $table_patient_file = 'patient_file';
	
	public function __construct() {
            parent::__construct();
            $this->load->database();
	}

	public function insertNewFile($data){
            $this->db->insert($this->table_file, $data);
            return $this->db->insert_id();
	}
	
	public function linkFileToPatient($idPatient, $idFile){
            $data = array('id_patient' => $idPatient, 'id_file' => $idFile);
            $this->db->insert($this->table_patient_file, $data);
	}
	
	public function deleteFileLinkFromPatient($idFile){
            $this->db->delete($this->table_patient_file, array('id_file' => $idFile)); 
	}
	
	public function deleteFileById($idFile){
            $this->db->delete($this->table_file, array('id' => $idFile)); 
	}
	
	public function getActiveFileDataById($idFile){
            $query = $this->db->select('*')
            ->from($this->table_file)
            ->where('id', $idFile)
                            ->where('active', 1)
            ->get();
            $array_objects_results = $query->result();
            return (!empty($array_objects_results)) ? ((count($array_objects_results) == 1) ? $array_objects_results[0] : $array_objects_results) : NULL;
	}
	
	
	
	public function getAllPatientActiveFiles($idPatient){
            $query = $this->db->select('*')
            ->from($this->table_file)
            ->join($this->table_patient_file, 'file.id = id_file AND id_patient = '.$idPatient)
            ->order_by("add_date", "desc")
            ->get();
            $array_objects_results = $query->result();
            return (!empty($array_objects_results)) ? ((count($array_objects_results) == 1) ? $array_objects_results[0] : $array_objects_results) : array();    
	}

	public function getFileId($filename){
            $query = $this->db->select('id')
            ->from($this->table_file)
            ->where('name', $filename)
            ->get();
            if ($query->num_rows() > 0){
                    $row = $query->row(); 
                    return $row->id;
            }
            else return 0;
	}
	
	public function getPatientIdFromFilesId($idFile){
            $query = $this->db->select('id_patient')
                ->from($this->table_patient_file)
                ->where('id_file', $idFile)
                ->get();
            $array_objects_results = $query->result();
            return (!empty($array_objects_results)) ? ((count($array_objects_results) == 1) ? $array_objects_results[0] : $array_objects_results) : NULL;	
	}
	
	public function getAllDisableAndActiveFiles($cleanDate=''){
            $query = $this->db->select('*')->from($this->table_file);
            if(!empty($cleanDate)) $query = $query->where ('DATE(add_date)', $cleanDate);
            $query = $query->get();
            $array_objects_results = $query->result();
            return (!empty($array_objects_results)) ? ((count($array_objects_results) == 1) ? $array_objects_results[0] : $array_objects_results) : NULL;	
	}
	
	public function getAllDisableFiles(){
            $query = $this->db->select('*')
                ->from($this->table_file)
		->where('active', 0)
                ->get();
            $array_objects_results = $query->result();
            return (!empty($array_objects_results)) ? ((count($array_objects_results) == 1) ? $array_objects_results[0] : $array_objects_results) : NULL;
	}
	
        
	public function getAllActiveFiles(){
            $query = $this->db->select('*')
                ->from($this->table_file)
		->where('active', 1)
                ->get();
            $array_objects_results = $query->result();
            return (!empty($array_objects_results)) ? ((count($array_objects_results) == 1) ? $array_objects_results[0] : $array_objects_results) : NULL;
	}
	
	
	public function deleteAllPatientFiles($idPatient){
		$query = $this->db->select('id_file')
                ->from($this->table_patient_file)
                ->where('id_patient', $idPatient)
                ->get();
        $array_objects_results = $query->result();
         if(!empty($array_objects_results)) {
			$array_objects_results = (count($array_objects_results) == 1) ? $array_objects_results[0] : $array_objects_results;
			foreach ($array_objects_results as $object){
				$this->deleteFileById($object->id_file);
			}			
		 }
	}
	
	
	public function disableFileById($idFile){
		$data = array('active' => 0);
		$this->db->update($this->table_file, $data, array('id' => $idFile));
	}
	
	public function disbaleAllPatientFiles($idPatient){
				$query = $this->db->select('id_file')
                ->from($this->table_patient_file)
                ->where('id_patient', $idPatient)
                ->get();
        $array_objects_results = $query->result();
         if(!empty($array_objects_results)) {
			$array_objects_results = (count($array_objects_results) == 1) ? $array_objects_results[0] : $array_objects_results;
			foreach ($array_objects_results as $object){
				$this->disableFileById($object->id_file);
			}			
		 }
	}
	
	
}

?>
