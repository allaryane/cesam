<?php

/* * ********************Encoding : UTF-8 ******************************\

 * 	Fichier			: file_upload_helper.php
 * 	Projet			: cesam
 * 	Version			: 1 nov. 2012 22:17:29
 * 	Auteur			: Ryane Alla // allaryane@gmail.com
 *  \************************************************************************* */


class File_upload_helper {
	
	public static function displayFiles($arrayFiles){
            if(!empty($arrayFiles)){
                foreach ((array)$arrayFiles as $oneFileObj) {
                    if(count($arrayFiles) == 1) $oneFileObj = $arrayFiles;
                    echo '
               		<script type="text/javascript"> 
                            $(document).ready(function() {
                                displayFile(\''.$oneFileObj->name.'\', '.$oneFileObj->id.'); 
                            })
                        </script>
                        ';
                    if(count($arrayFiles) == 1) break;
                }   
            }
        }	
        
        public static function fileBrowser($inputName, $args = array('buttonValue' => 'Joindre un ficher examen', 'display' => '')){	
            echo '
                    <input type="button" onclick="$(\'#fileHidden\').trigger(\'click\');" class="typeFileButton" value="'.$args['buttonValue'].'" style="display:'.$args['display'].'"  />
                    <input type="file" name="'.$inputName.'" onchange="afterClosingFileBrowser(this);" id="fileHidden" style="display:none">
                    <div id="contentFiles" class="row">
                    </div>
                    <div style="display: none;" id="filesIdDiv">
                    <input id="countFiles" value="0" />
                    </div>
            '; 
	}
}

	
