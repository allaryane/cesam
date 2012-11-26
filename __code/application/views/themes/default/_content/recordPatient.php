<?php
/* * **************************************************\
 *
 * 	fichier			: views/themes/default/_content/addNewPatient.php
 * 	projet			:
 * 	version			: 2012/03/10 10:40 JRA
 *
  \*************************************************** */ 

$infosPatientObj = NULL;
$arrayFiles = array();
$doctorName = '';
$doctorId = '';
if(!empty($recordData)){
	$infosPatientObj = $recordData['infosPatientObj'];
        $arrayFiles = $recordData['arrayFiles'];
        $doctorName = $recordData['doctorName'];
        $doctorId = $recordData['doctorId'];
}
$userdata = $this->session->userdata('userLoginData');
$controllerPatient = 'patients';
if($userdata->type == USER_TYPE_DOCTOR) $controllerPatient = 'mypatients';
?>


<div id="centralBox" class="centralBox">
	
	<?php
		if(empty($recordData)){
	?>
		
	<div id="centralBoxHeader" class="centralBoxHeader">
		Erreur : patient inexistant !
	</div>
        <div class="divErrorNoData">
	<center>
            <img width="50" height="50" src="<?php echo base_url(); ?>public/images/error.png">
            Le patient dont vous souhaitez consulter les données n'existe pas ou a été supprimé.
            <br/>
            <br/>
            <img width="25" height="25" src="<?php echo base_url(); ?>public/images/return.png">
            <a style="font-size: 15px!important;" href="<?php echo base_url().$controllerPatient ?>">Revenir à la liste des patients</a>
        </center>
        </div>
        
	</div>
    
    
    
	<?php	
			return;
		}
	?>

	<div id="centralBoxHeader" class="centralBoxHeader">
	Consultation de la fiche patient. Vous pouvez modifier les informations de la fiche ou joindre des nouveaux fichiers.
	</div>

        <?php
        if($addPatientOK || $modifyPatientOK){ 
            $message = '';
            if($addPatientOK) $message = 'Patient enregistré avec succès !';
            if($modifyPatientOK) $message = 'Fiche patient modifié avec succès !';
        ?>

        <div class="divMessagesSucces">
                <div id="subContent">
                    <h1><img width="25" height="25" src="<?php echo base_url(); ?>public/images/success.png" /><?php echo $message; ?></h1>
                </div>
        </div>
        <?php
        }
        ?>
        
        <?php
        if($userdata->type == USER_TYPE_ROOT){
        ?>
	<div class="reinitButtonClass">
          
            <button class="btn" onclick="window.location = '<?php echo base_url().'patients/modifyPatient/'.$infosPatientObj->id; ?>';" type="button"><b>Modifier la fiche patient</b></button>
            <button class="btn" onclick="alert($('#countFiles').val());" type="button">Supprimer la fiche patient</button>

	</div>
	<div style="clear: both;"></div>	
	<?php
        }
        else echo '<br/><br/>';
        ?>
	<form enctype="multipart/form-data" id="cesamForm" class="form-vertical"  method="post" action="">
		<legend style="margin-bottom: 2px!important;" class="lengendForm"><label>Informations Patient</label></legend>
                <label style="float: right; font-style: italic;">Ajouté le : <?php echo Cesam_date_format_helper::sqlFormatToCesam($infosPatientObj->create_date); ?></label>
                <div style="clear: both;"></div>

                
		<fieldset>
		<div class="verticalSpaceAfterLengendForm"></div>
		
		<div class="span5">
			
		<div class="control-group">
			<label class="recordLabelTitleFirst"><u>Nom : </u></label>
			<label class="recordLabelData"><?php echo $infosPatientObj->last_name; ?></label>
		</div>
		<div class="control-group">
			<label class="recordLabelTitle"><u>Prénom(s) : </u></label>
			<label class="recordLabelData"><?php echo $infosPatientObj->first_name; ?></label>
		</div>
		
		<div class="control-group">
			<label class="recordLabelTitle"><u>Sexe : </u></label>
			<label class="recordLabelData"><?php echo Cesam::getSexe($infosPatientObj->sexe); ?></label>
		</div>
		
			
		<div class="control-group">
			<label class="recordLabelTitle"><u>Notes : </u></label>
			<div class="recordDivNotes">
				<label><?php echo $infosPatientObj->notes; ?></label>
			</div>
		</div>
		
		</div>
		
		
		<div class="span5">
		
		<div class="control-group">
			<label class="recordLabelTitleFirst"><u>Date de naissance : </u></label>
			<label class="recordLabelData"><?php echo Cesam_date_format_helper::sqlFormatToCesam($infosPatientObj->birthday); ?></label>
		</div>
			
			
		<div class="control-group">
			<label class="recordLabelTitle"><u>Date et heure de prélèvement : </u></label>
			<label class="recordLabelData"><?php echo Cesam_date_format_helper::sqlFormatToCesam($infosPatientObj->prelevement); ?></label>
		</div>
			
		<div class="control-group">
			<label class="recordLabelTitle"><u>Date de l'ordonnance : </u></label>
			<label class="recordLabelData"><?php echo Cesam_date_format_helper::sqlFormatToCesam($infosPatientObj->ordonnance); ?></label>
		</div>
		
		<div class="control-group">
			<label class="recordLabelTitle"><u>N° de Tel ou Cell : </u></label>
			<label class="recordLabelData"><?php echo $infosPatientObj->tel_cell; ?></label>
		</div>
		
		<div class="control-group">
			<label class="recordLabelTitle"><u>N° de dossier Cesam : </u></label>
			<label class="recordLabelData specialStyleText"><?php echo $infosPatientObj->num_dossier_cesam; ?></label>
		</div>
		
		</div>
		<div style="clear: both;"></div>
		
		</fieldset>

		<legend class="lengendForm subLengendForm"><label>Assignation et status</label></legend>
		
		<div class="span5">
			<div class="control-group">
			<label class="recordLabelTitleFirst"><u>Assigne au  : </u></label>
                        <label class="recordLabelData"><b><a href="<?php echo base_url().'doctors/recordDoctor/'.$doctorId; ?>"><?php echo $doctorName;  ?></a></b></label>
			</div>
		</div>
		
		<div class="span5">
			<div class="control-group">
			<label class="recordLabelTitleFirst"><u>Statu examen : </u></label>
                        <label class="recordLabelData"><font style="font-size: 26px!important;"><?php echo Cesam::getState($infosPatientObj->dossier_state); ?></font></label>
			</div>	
		</div>
		<div style="clear: both;"></div>
		
                <br/>
		<legend class="lengendForm subLengendForm"><label>Fichiers Examens et Facturation</label></legend>
		
                
                    
		<div id="filesUploadDiv">
		<?php
                    $args = array('buttonValue' => 'Joindre un ficher examen', 'display' => 'none');
                    File_upload_helper::fileBrowser('patientFile', $args);
                ?>
		</div>
                
		<?php File_upload_helper::displayFiles($arrayFiles); ?>
	</form>

	
	
	
</div>
<?php $this->session->unset_userdata('addPatientOK'); ?>
<?php $this->session->unset_userdata('modifyPatientOK'); ?>