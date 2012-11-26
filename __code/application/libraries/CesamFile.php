<?php

/* * ********************Encoding : UTF-8 ******************************\

 * 	Fichier			: CesamFile.php
 * 	Projet			: cesam
 * 	Version			: 10 nov. 2012 13:50:05
 * 	Auteur			: Ryane Alla // allaryane@gmail.com
 *  \************************************************************************* */


/**
 * @property CI_Controller $CI
 * @property User_model $user_model
 * @property File_model $file_model
 * @property Patient_model $patient_model
 */
class CesamFile  {
		
    public function __construct(){
		// Ne pas recuperer l'instance du controleur dans le constructeur
		// car l'objet peut etre instancier par un controleur et etre manipuler
		// par un autre
    }
	
	public function uploadFile($filesArray, $fieldname){
		$CI = & get_instance();
		$CI->load->model(array('file_model'));
		
		if ($filesArray[$fieldname]["error"] > 0){
			//echo "Error Code: " . $_FILES[$fieldname]["error"];
			echo $filesArray[$fieldname]["name"].';NULL;0';
		}
		else
		{
			if (file_exists(FILE_UPLOAD_DIR . $filesArray[$fieldname]["name"])) {
				echo $filesArray[$fieldname]["name"].';NULL;-1';
			}
			else{
				
				move_uploaded_file($filesArray[$fieldname]["tmp_name"],
								   FILE_UPLOAD_DIR . $filesArray[$fieldname]["name"]);
				
				$data = array('name' => $filesArray[$fieldname]["name"],
							  'type' => $filesArray[$fieldname]["type"],
							  'extension' => end(explode(".", $filesArray[$fieldname]["name"])),
							  'size' => $filesArray[$fieldname]["size"],
							  'add_date' => date("Y-m-d H:i:s")); 
				
				$idFile = $CI->file_model->insertNewFile($data);
				echo $filesArray[$fieldname]["name"].';'.$idFile.';1';			
			}
		}
	}
	
	public function disableFileInDb($idFileOrFilename){
		$CI = & get_instance();
		$CI->load->model(array('file_model'));
		
		if(!is_numeric($idFileOrFilename)) $idFile = $CI->file_model->getFileId($idFileOrFilename);
		else $idFile = $idFileOrFilename;
		
		$CI->file_model->disableFileById($idFile);
	}
	
	/**
	 *
	 * @param type $idFileOrFilename : id du fichier a supprimer. 
	 * Peut correspondre soit a l'id ou au nom du fichier.
	 */
	public function deleteFileInDirAndInDb($idFileOrFilename){
		$CI = & get_instance();
		$CI->load->model(array('file_model'));
		
		if(!is_numeric($idFileOrFilename)) $idFile = $CI->file_model->getFileId($idFileOrFilename);
		else $idFile = $idFileOrFilename;
		
		$obj = $CI->file_model->getActiveFileDataById($idFile);
		$filename = $obj->name;
			
		$CI->file_model->deleteFileLinkFromPatient($obj->id);
		$CI->file_model->deleteFileById($idFile);
		@unlink(FILE_UPLOAD_DIR.$filename);
	}
	
	/**
	 * Cette fonction permet de supprimer un fichier de la basee de donnees et du repertoire upload.
	 * Si le fichier est deja lie a un patient la fonction desactivera seulement le fichier.
	 * Dans le cas contraire c'est une suppression totale.
	
	 * @param $idFileOrFilename : id du fichier a supprimer. 
	 * Peut correspondre soit a l'id ou au nom du fichier.
	 */
	public function deleteFile($idFileOrFilename){
		$CI = & get_instance();
		$CI->load->model(array('file_model'));
		if(!is_numeric($idFileOrFilename)) $idFile = $CI->file_model->getFileId($idFileOrFilename);
		else $idFile = $idFileOrFilename;
		
		
		$patient = $CI->file_model->getPatientIdFromFilesId($idFile);
		// On supprime les fichiers qui n'ont pas de patient de la db et du repertoire.
		if(empty($patient)){
			$this->deleteFileInDirAndInDb($idFile);
		}
		// On desactive juste les fichiers qui ont des patients
		// L'admin pourra purger plus tard les fichiers airant.
		else $this->disableFileInDb($idFile); 
	}
	
	public function cleanDirAndDb($cleanDate){
		$CI = & get_instance();
		$CI->load->model(array('file_model'));
		
		$allFiles = $CI->file_model->getAllDisableAndActiveFiles($cleanDate);
		
		// Le cast (array) permet d'eviter une erreur quand $allFiles est vide	
		foreach ((array)$allFiles as $oneFile) {
			if(count($allFiles) == 1) $oneFile = $allFiles;
			$patient = $CI->file_model->getPatientIdFromFilesId($oneFile->id);
			// On supprime les fichiers qui n'ont pas de patient
			if(empty($patient)){
				$this->deleteFileInDirAndInDb($oneFile->id);
			}
			if(count($allFiles) == 1) break;
		}

		
	}
}
?>
