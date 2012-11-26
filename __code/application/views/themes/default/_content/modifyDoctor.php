<?php
/* * **************************************************\
 *
 * 	fichier			: views/themes/default/_content/addNewPatient.php
 * 	projet			:
 * 	version			: 2012/03/10 10:40 JRA
 *
  \*************************************************** */ 

$infosDoctorObj = NULL;
//$allPatientsData = NULL;
if(!empty($recordData)){
	$infosDoctorObj = $recordData['infosDoctorObj'];
        //$allPatientsData = $recordData['arrayPatientsObj'];
}


?>


<div id="centralBox" class="centralBox">
    
	<?php
		if(empty($recordData)){
	?>
		
	<div id="centralBoxHeader" class="centralBoxHeader">
		Erreur : Médecin inexistant !
	</div>
        <div class="divErrorNoData">
	<center>
            <img width="50" height="50" src="<?php echo base_url(); ?>public/images/error.png">
            Le Médecin dont vous souhaitez consulter les données n'existe pas ou a été supprimé.
            <br/>
            <br/>
            <img width="25" height="25" src="<?php echo base_url(); ?>public/images/return.png">
            <a style="font-size: 15px!important;" href="<?php echo base_url().'doctors' ?>">Revenir à la liste des Médecins</a>
        </center>
        </div>
        
	</div>
	<?php	
			return;
		}
	?>

	<div id="centralBoxHeader" class="centralBoxHeader">
	Modification de la fiche médecin : les champs suivis de * sont obligatoires
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
	$attributes = array('class' => 'form-vertical', 'id' => 'cesamForm');
	echo form_open(base_url().'doctors/modifyDoctor', $attributes);
	?>
        
	<div class="reinitButtonClass">
                <button type="submit" class="btn">Enregistrer les modifications</button>
	</div>
	<div style="clear: both;"></div>
	<!--<form enctype="multipart/form-data" id="cesamForm" class="form-vertical"  method="post" action=""> -->
		<legend class="lengendForm"><label>Informations Médecin</label></legend>
		
	<fieldset>
                <input name="doctor_id" value="<?php echo $infosDoctorObj->id; ?>" style="display: none;">
		<div class="verticalSpaceAfterLengendForm"></div>
		
		<div class="span5">
			
		<div class="control-group">
			<label class="control-label" for="nom">Nom *</label>
			<div id="doctorLastNameErr" class="err"></div>
			<div class="controls">
			<input value="<?php echo $infosDoctorObj->last_name; ?>" maxlength="50" name="doctorLastName" type="text" id="doctorLastName" placeholder="Nom du doctor" />
			</div>
			
		</div>
		<div class="control-group">
			<label class="control-label" for="prenom">Prénom(s) *</label>
			<div id="doctorFirstNameErr" class="err"></div>
			<div class="controls">
				<input value="<?php echo $infosDoctorObj->first_name; ?>" maxlength="50" name="doctorFirstName" type="text" id="doctorFirstName" placeholder="Prénom du doctor">
			</div>
			
		</div>
		
		
		<div class="control-group">
			<label class="control-label" for="email">Adresse email</label>
			<div id="emailErr" class="err"></div>
			<div class="controls">
				<input value="<?php echo $infosDoctorObj->email; ?>"  maxlength="50" type="text" name="email" id="email" placeholder="Adresse electronique">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="tel">N° de Tel ou Cell
			</label>
			<div id="telCellErr" class="err"></div>
			<div class="controls">
				<input value="<?php echo $infosDoctorObj->cell; ?>" maxlength="15" type="text" name="telCell" id="telCell" placeholder="Numero de telephone ou cellulaire">
			</div>
		</div>
			
			
		</div>
		
		
		<div class="span5">
		
		
		<div class="control-group">
			<label class="control-label" for="code_permanent"><b>Code permanent *</b></label>
			<!--<label class="control-label" style="font-size: 11px;"><i>Entrez le nom et prenom avant la generation</i></label> -->
			<div id="code_permanentErr" class="err"></div>
			<div class="controls">
				<input value="<?php echo $infosDoctorObj->username; ?>" maxlength="15" type="text" name="code_permanent" id="code_permanent" placeholder="Code permanent" autocomplete="off" readonly>
                                <a href="javascript:;" onclick="generateCodePermanent();">Générer</a>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="password"><b>Mot de passe *</b></label>
			<div id="passwordErr" class="err"></div>
			<div class="controls">
				<input value="<?php echo $infosDoctorObj->password; ?>" maxlength="15" type="text" name="password" id="password" placeholder="Mot de passe" autocomplete="off" readonly>
                                <a href="javascript:;" onclick="generatePassword();">Générer</a>
			</div>
		</div>
		
		</div>
		<div style="clear: both;"></div>
		
		</fieldset>	

		
	</form>		
	
</div>





