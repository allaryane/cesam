<?php
/* * ********************Encoding : UTF-8 ******************************\

 * 	Fichier			: connexionlog_model.php
 * 	Projet			: cesam
 * 	Version			: 23 nov. 2012 14:43:02
 * 	Auteur			: Ryane Alla // allaryane@gmail.com
 *  \************************************************************************* */


class Connexionlog_model extends CI_Model{

    private $table_log = 'log';

    public function __construct() {
            parent::__construct();
            $this->load->database();
    }
    
    public function insertNewLog($data){
            $this->db->insert($this->table_log, $data);
            return $this->db->insert_id();
    }
    
    public function deleteLogByIdUser($idUser){
            $this->db->delete($this->table_log, array('id_user' => $idUser)); 
    }
    
    public function deleteLogByIdLog($idLog){
            $this->db->delete($this->table_log, array('id' => $idLog)); 
    }
        
    public function getAllLog(){
        $query = $this->db->select('*')
        ->from($this->table_log)
        ->order_by("log_date", "desc")
        ->get();
        $array_objects_results = $query->result();
        return (!empty($array_objects_results)) ? ((count($array_objects_results) == 1) ? $array_objects_results[0] : $array_objects_results) : array();
    }
    
    public function purgeLog($purgeDate){
        $this->db->delete($this->table_log, "DATE(log_date) < '".$purgeDate."'");
        //echo $this->db->last_query();
    }
    
}

?>
