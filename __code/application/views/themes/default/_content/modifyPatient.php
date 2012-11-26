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
$doctorId = '';
if(!empty($recordData)){
	$infosPatientObj = $recordData['infosPatientObj'];
        $arrayFiles = $recordData['arrayFiles'];
        $doctorId = $recordData['doctorId'];

}
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
            Le patient dont vous souhaitez modifier les données n'existe pas ou a été supprimé.
            <br/>
            <br/>
            <img width="25" height="25" src="<?php echo base_url(); ?>public/images/return.png">
            <a style="font-size: 15px!important;" href="<?php echo base_url().'patients' ?>">Revenir à la liste des patients</a>
        </center>
        </div>
        
	</div>
	<?php	
			return;
		}
	?>

	<div id="centralBoxHeader" class="centralBoxHeader">
	Modification de la fiche patient : les champs suivis de * sont obligatoires
	</div>
	
	
	<?php
	// Gestion des erreurs de validation cote serveur
	$display = "none";
	$errors = validation_errors();
	if(!empty($errors)) $display = '';
	?>
	<div class="errorValidationServer" style="display: <?php echo $display; ?>;">
	<h1>Erreur(s) : </h1>
	<?php echo validation_errors('<div class="errorValidationServerContent">', '</div>'); ?>
	<br/>
	</div>
	
	
	
	<?php
	$attributes = array('class' => 'form-vertical', 'id' => 'cesamForm', 'enctype' => "multipart/form-data");
	echo form_open(base_url().'patients/modifyPatient', $attributes);
	?>
        
	<div class="reinitButtonClass">
                <button type="submit" class="btn">Enregistrer les modifications</button>
	</div>
	<div style="clear: both;"></div>
	<!--<form enctype="multipart/form-data" id="cesamForm" class="form-vertical"  method="post" action=""> -->
		<legend class="lengendForm"><label>Informations Patient</label></legend>
		
		<fieldset>
		<div class="verticalSpaceAfterLengendForm"></div>
                
                <input style="display: none;" name="patient_id" value="<?php echo $infosPatientObj->id; ?>" />
                
		<div class="span5">
			
		<div class="control-group">
			<label class="control-label" for="nom">Nom *</label>
			<div id="patientLastNameErr" class="err"></div>
			<div class="controls">
			<input value="<?php echo $infosPatientObj->last_name; ?>" maxlength="50" name="patientLastName" type="text" id="patientLastName" placeholder="Nom du patient" />
			</div>
			
		</div>
		<div class="control-group">
			<label class="control-label" for="prenom">Prénom(s) *</label>
			<div id="patientFirstNameErr" class="err"></div>
			<div class="controls">
				<input value="<?php echo $infosPatientObj->first_name ?>" maxlength="50" name="patientFirstName" type="text" id="patientFirstName" placeholder="Prénom du patient">
			</div>
			
		</div>
		
		<div class="control-group">
			<label class="control-label" for="sexe">Sexe *</label>
			<div id="sexeErr" class="err"></div>
			<div class="controls">
			<?php
			$options = array('F' => 'Féminin', 'M' => 'Masculin');
			Cesam_form_helper::makeSelectField('sexe', 'Sexe du patient', $infosPatientObj->sexe, $options);
			?>
			</div>
		</div>
		
			
		<div class="control-group">
			<label class="control-label" for="notes">Notes</label>
			<div class="controls">
				<textarea maxlength="500" style="width: 300px; max-width: 360px; max-height: 200px;" rows="4" type="text" id="notes" name="notes" placeholder="Details concernant le patient..." /><?php echo $infosPatientObj->notes; ?></textarea>
			</div>
		</div>
		
		</div>
		
		
		<div class="span5">
		
		<div class="control-group">
			<label class="control-label" for="date_naissance">Date de naissance *</label>
			<div id="date_naissanceErr" class="err"></div>
			<div class="controls">
				<?php Cesam_form_helper::renderInputBirthay('date_naissance',$infosPatientObj->birthday); ?>
			</div>
		</div>
			
			
		<div class="control-group">
			<label class="control-label" for="prelevement">Date et heure de prélèvement *</label>
			<div id="prelevementErr" class="err"></div>
			<div class="controls">
			<?php Cesam_form_helper::renderInputDateHour('prelevement',$infosPatientObj->prelevement); ?>
			</div>
		</div>
			
		<div class="control-group">
			<label class="control-label" for="ordonnance">Date de l'ordonnance *</label>
			<div id="ordonnanceErr" class="err"></div>
			<div class="controls">
			<?php Cesam_form_helper::renderInputDate('ordonnance', $infosPatientObj->ordonnance); ?>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="tel">N° de Tel ou Cell</label>
			<div id="telCellErr" class="err"></div>
			<div class="controls">
				<input value="<?php echo $infosPatientObj->tel_cell ?>" maxlength="15" type="text" name="telCell" id="telCell" placeholder="Numero de telephone ou cellulaire">
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="num_dossier">N° de dossier Cesam *</label>
			<div id="num_dossierErr" class="err"></div>
			<div class="controls">
				<input value="<?php echo $infosPatientObj->num_dossier_cesam ?>" maxlength="15" type="text" name="num_dossier" id="num_dossier" placeholder="Numero de dossier">
			</div>
		</div>
		
		</div>
		<div style="clear: both;"></div>
		
		</fieldset>

		<legend class="lengendForm subLengendForm"><label>Assignation et status</label></legend>
		
		<div class="span5">
			<div class="control-group">
				<label class="control-label" for="assignation">Assigner le patient au Dr. *</label>
				<div id="assignationErr" class="err"></div>
				<div class="controls">
					<?php
					$options = $doctorsList;
					Cesam_form_helper::makeSelectField('assignation', 'Nom du docteur', $doctorId, $options);
					?>
				</div>
			</div>
		</div>
		
		<div class="span5">
			<div class="control-group">
				<label class="control-label" for="statut">Statut examen(s) *</label>
				<div id="statutErr" class="err"></div>
				<div class="controls">
					<?php
					$options = array(STATE_PROGRESS => 'En cours',
									 STATE_PENDING => 'Suspendu',
									 STATE_DONE => 'Terminé');
					Cesam_form_helper::makeSelectField('statut', 'Satut examen', $infosPatientObj->dossier_state, $options);
					?>
				</div>
			</div>	
		</div>
		<div style="clear: both;"></div>
		

		<legend class="lengendForm subLengendForm"><label>Fichiers Examens et Facturation</label></legend>
		
		<div id="filesUploadDiv">
		<?php File_upload_helper::fileBrowser('patientFile'); ?>
		</div>
                <?php File_upload_helper::displayFiles($arrayFiles); ?>
		
		
	</form>		
	
</div>