<?php
/* * ********************Encoding : UTF-8 ******************************\

 * 	Fichier			: settings_model.php
 * 	Projet			: cesam
 * 	Version			: 23 nov. 2012 02:43:02
 * 	Auteur			: Ryane Alla // allaryane@gmail.com
 *  \************************************************************************* */



class Settings_model extends CI_Model{

    private $table_settings = 'settings';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function updateSettings($data){
        $this->db->update($this->table_settings, $data, array('id' =>  1));
    }
    
    public function getSettings($fieldName = ''){
        $query = $this->db->select('*')
                ->from($this->table_settings)
                ->where('id', 1)		
                ->get();	
		if ($query->num_rows() > 0) {
                    $row = $query->row_array();
                    if(!empty($fieldName)) return $row[$fieldName];
                    else return $row;
		}
		else return NULL;
        
    }
    
    
    
    
    
    
}

?>
