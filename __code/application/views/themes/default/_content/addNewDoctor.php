<?php
/* * **************************************************\
 *
 * 	fichier			: views/themes/default/_content/addNewDoctor.php
 * 	projet			:
 * 	version			: 2012/03/10 10:40 JRA
 *
  \*************************************************** */ 
?>


<div id="centralBox" class="centralBox">
	<div id="centralBoxHeader" class="centralBoxHeader">
	Ajoutez un nouveau docteur : les champs suivis de * sont obligatoires
	</div>
	
	<div class="reinitButtonClass">
		<button class="btn" onclick="location.reload();" type="button">Réinitialiser le formulaire</button>
	</div>
	<div style="clear: both;"></div>	
	
        
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
	echo form_open(base_url().'doctors/addNewDoctor', $attributes);
	?>
	<!-- <form id="cesamForm" class="form-vertical"  method="post" action=""> -->
		<legend class="lengendForm"><label>Ajout nouveau medecin</label></legend>
		
		<fieldset>
		<div class="verticalSpaceAfterLengendForm"></div>
		
		<div class="span5">
			
		<div class="control-group">
			<label class="control-label" for="nom">Nom *</label>
			<div id="doctorLastNameErr" class="err"></div>
			<div class="controls">
			<input value="<?php echo @$dataPatient['doctorLastName'] ?>" maxlength="50" name="doctorLastName" type="text" id="doctorLastName" placeholder="Nom du doctor" />
			</div>
			
		</div>
		<div class="control-group">
			<label class="control-label" for="prenom">Prénom(s) *</label>
			<div id="doctorFirstNameErr" class="err"></div>
			<div class="controls">
				<input value="<?php echo @$dataPatient['doctorFirstName'] ?>" maxlength="50" name="doctorFirstName" type="text" id="doctorFirstName" placeholder="Prénom du doctor">
			</div>
			
		</div>
		
		
		<div class="control-group">
			<label class="control-label" for="email">Adresse email</label>
			<div id="emailErr" class="err"></div>
			<div class="controls">
				<input value="<?php echo @$dataPatient['email'] ?>"  maxlength="50" type="text" name="email" id="email" placeholder="Adresse electronique">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="tel">N° de Tel ou Cell
			</label>
			<div id="telCellErr" class="err"></div>
			<div class="controls">
				<input value="<?php echo @$dataPatient['telCell'] ?>" maxlength="15" type="text" name="telCell" id="telCell" placeholder="Numero de telephone ou cellulaire">
			</div>
		</div>
			
			
		</div>
		
		
		<div class="span5">
		
		
		<div class="control-group">
			<label class="control-label" for="code_permanent"><b>Code permanent *</b></label>
			<!--<label class="control-label" style="font-size: 11px;"><i>Entrez le nom et prenom avant la generation</i></label> -->
			<div id="code_permanentErr" class="err"></div>
			<div class="controls">
				<input value="<?php echo @$dataPatient['code_permanent'] ?>" maxlength="15" type="text" name="code_permanent" id="code_permanent" placeholder="Code permanent" autocomplete="off" readonly>
                                <a href="javascript:;" onclick="generateCodePermanent();">Générer</a>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="password"><b>Mot de passe *</b></label>
			<div id="passwordErr" class="err"></div>
			<div class="controls">
				<input value="<?php echo @$dataPatient['password'] ?>" maxlength="15" type="text" name="password" id="password" placeholder="Mot de passe" autocomplete="off" readonly>
                                <a href="javascript:;" onclick="generatePassword();">Générer</a>
			</div>
		</div>
		
		</div>
		<div style="clear: both;"></div>
		
		</fieldset>
		
			
		<hr/>
		<div on class="control-group">
			<div style="float: right; margin-right: 10%;" class="controls">
			<button type="submit" class="btn">Enregistrer</button>
			</div>
			<div style="clear: both;"></div>
		</div>
	</form>

	
	
	
</div>