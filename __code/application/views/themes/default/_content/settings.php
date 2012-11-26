<?php
/* * **************************************************\
 *
 * 	fichier			: views/themes/default/_content/settings.php
 * 	projet			:
 * 	version			: 2012/11/23 10:40 JRA
 *
  \*************************************************** */
?>

<div id="centralBox" class="centralBox">
	<div id="centralBoxHeader" class="centralBoxHeader">
	Parametrez l'application Cesam a votre guise
	</div>
	
	<div id="cesamForm">
            
            <?php
            $attributes = array('class' => 'form-vertical', 'id' => 'CHANGE_PASSWORD');
            echo form_open(base_url().'settings', $attributes);
            ?>
            <!-- <form id="CHANGE_PASSWORD" class="form-vertical" action="" method="post"> -->
            
		<legend class="lengendForm"><label>Changer mot de passe ROOT</label></legend>
                
                <?php
                if($CHANGE_PASSWORD_OK == 'OK'){ 
                ?>
                <div class="divMessagesSucces">
                        <div id="subContent">
                            <h1>
                                <img width="25" height="25" src="<?php echo base_url(); ?>public/images/success.png" />
                                Le mot de passe Root a été changé avec succès !
                            </h1>
                        </div>
                </div>
                <?php
                }
                ?>

                <?php
                // Gestion des erreurs de validation cote serveur
                $display = "none";
                $errors = validation_errors();
               
                if(!empty($errors) && $CHANGE_PASSWORD_OK == 'KO') $display = '';
                ?>
                <div class="errorValidationServer" style="display: <?php echo $display; ?>;">
                <h1>Erreur(s) : </h1>
                <?php echo validation_errors('<div class="errorValidationServerContent">', '</div>'); ?>
                <br/>
                </div>

                
                
                <div class="changePasswordClass">
		<input type="text" value="CHANGE_PASSWORD" name="section" style="display: none;" >
			<div class="control-group">
				<label class="control-label" for="currentPassword">Actuel mot de passe *</label>
				<div id="currentPasswordErr" class="err"></div>
				<div class="controls">
				<input value="" maxlength="20" name="currentPassword" type="password" id="currentPassword" placeholder="Actuel mot de passe" />
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label" for="newPassword">Nouveau mot de passe *</label>
				<div id="newPasswordErr" class="err"></div>
				<div class="controls">
					<input value="" maxlength="20" name="newPassword" type="password" id="newPassword" placeholder="Nouveau mot de passe">
				</div>		
			</div>
			<div class="control-group">
				<label class="control-label" for="confirmNewPassword">Confirmer nouveau mot de passe *</label>
				<div id="confirmNewPasswordErr" class="err"></div>
				<div class="controls">
					<input value="" maxlength="20" name="confirmNewPassword" type="password" id="confirmNewPassword" placeholder="Entrez encore le nouveau mot de passe">
				</div>		
			</div>
			<div on class="control-group">
				<div style="margin-left: 300px;" class="controls">
					<button type="submit" class="btn">Enregistrer</button>
				</div>
				<div style="clear: both;"></div>
			</div>	
                </div>
		</form>
		
	
            <?php
            $attributes = array('class' => 'form-vertical', 'id' => 'ROOT_INFOS');
            echo form_open(base_url().'settings', $attributes);
            ?>
            <!-- <form id="ROOT_INFOS" class="form-vertical" action="" method="post"> -->
		
		<legend class="lengendForm"><label>Mise à jour des informations du ROOT</label></legend>
		<?php
                if($ROOT_INFOS_OK == 'OK'){ 
                ?>
                <div class="divMessagesSucces">
                        <div id="subContent">
                            <h1>
                                <img width="25" height="25" src="<?php echo base_url(); ?>public/images/success.png" />
                                Les informations du Root ont été changées avec succès !
                            </h1>
                        </div>
                </div>
                <?php
                }
                ?>

                <?php
                // Gestion des erreurs de validation cote serveur
                $display = "none";
                $errors = validation_errors();
                if(!empty($errors) && $ROOT_INFOS_OK == 'KO') $display = '';
                ?>
                
                <div class="errorValidationServer" style="display: <?php echo $display; ?>;">
                <h1>Erreur(s) : </h1>
                <?php echo validation_errors('<div class="errorValidationServerContent">', '</div>'); ?>
                <br/>
                </div>

                
                        <p>
                            <img width="25" height="25" src="<?php echo base_url() ?>public/images/info.ico"> Cette section permet de changer les informations du root qui seront affichées aux Médecins au cas ou ceux
			ci aimeraient contacter le Root (Dr Alla Yeboue). Si vous ne souhaitez pas que certaines informations soient 
			publiées laissez les champs correspondant vides.
                        </p>
                        <div class="changePasswordClass">
			<input type="text" value="ROOT_INFOS" name="section" style="display: none;" >

			<div class="control-group">
				<label class="control-label" for="email">Adresse email *</label>
				<div id="emailErr" class="err"></div>
				<div class="controls">
				<input value="<?php echo $rootInfos->email; ?>" maxlength="50" name="email" type="text" id="email" placeholder="Adresse email root" />
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label" for="tel">Téléphone bureau </label>
				<div id="telErr" class="err"></div>
				<div class="controls">
					<input value="<?php echo $rootInfos->tel; ?>" maxlength="20" name="tel" type="text" id="tel" placeholder="Numero de telephone fixe">
				</div>		
			</div>
			<div class="control-group">
				<label class="control-label" for="cell">Téléphone cellulaire</label>
				<div id="cellErr" class="err"></div>
				<div class="controls">
					<input value="<?php echo $rootInfos->cell; ?>" maxlength="20" name="cell" type="text" id="cell" placeholder="Numero de telephone cellulaire">
				</div>		
			</div>
			<div on class="control-group">
				<div style="margin-left: 300px;" class="reinitButtonClass">
					<button type="submit" class="btn">Enregistrer les modifications</button>
				</div>
			</div>	

                        </div>
                        
		</form>

            
            
            <?php
            $attributes = array('class' => 'form-vertical', 'id' => 'SETTINGS_SYS');
            echo form_open(base_url().'settings', $attributes);
            ?>
            <!-- <form id="SETTINGS_SYS" class="form-vertical" action="" method="post"> -->
		
		<legend class="lengendForm"><label>Paramètres système</label></legend>

                <?php
                if($SETTINGS_SYS_OK == 'OK'){ 
                ?>
                <div class="divMessagesSucces">
                        <div id="subContent">
                            <h1>
                                <img width="25" height="25" src="<?php echo base_url(); ?>public/images/success.png" />
                                Les paramètres système ont été changés avec succès !
                            </h1>
                        </div>
                </div>
                <?php
                }
                ?>

                <?php
                // Gestion des erreurs de validation cote serveur
                $display = "none";
                $errors = validation_errors();
               
                if(!empty($errors) && $SETTINGS_SYS_OK == 'KO') $display = '';
                ?>
                <div class="errorValidationServer" style="display: <?php echo $display; ?>;">
                <h1>Erreur(s) : </h1>
                <?php echo validation_errors('<div class="errorValidationServerContent">', '</div>'); ?>
                <br/>
                </div>
                
                
                        <div class="changePasswordClass">
			<input type="text" value="SETTINGS_SYS" name="section" style="display: none;" >
                        
                        <div class="control-group">
                            <div id="nbResultsByPageRootErr" class="err"></div>
                            <label id="nbResultsByPageLabel" class="control-label" for="nbResultsByPageRoot">
                                Nombre de résultats de recherche par page pour le <b>Root</b> : &nbsp;
                                <input maxlength="2" value="<?php echo $settingsArray['root_nb_results_by_page']; ?>" style="width: 25px!important;" type="text" id="nbResultsByPageRoot" name="nbResultsByPageRoot" placeholder="">
                            </label>
                        </div>
                        
                        <br/>
                        
                        
                        <div class="control-group">
                            <div id="nbResultsByPageDoctorErr" class="err"></div>
                            <label id="nbResultsByPageLabel" class="control-label" for="nbResultsByPageDoctor">
                                Nombre de résultats de recherche par page pour le <b>Médecin</b> : &nbsp;
                            <input maxlength="2" value="<?php echo $settingsArray['doctor_nb_results_by_page']; ?>" style="width: 25px!important;" type="text" id="nbResultsByPageDoctor" name="nbResultsByPageDoctor" placeholder="">
                            </label>
                        </div>
                        
                        <br/>
                        <br/>
                        <div class="control-group">
                              <label class="nbResultsByPageLabel">
                                Notifications par Email : &nbsp;
                                <?php 
                                    $checked = 'checked="checked"';
                                    $selectedActiver = '';
                                    $selectedDesactiver = '';
                                    if($settingsArray['email_notifications'] == '1')$selectedActiver = $checked;
                                    else $selectedDesactiver = $checked;
                                ?>
                                <font style="margin-left: 40px;"></font>
                                <input type="radio" value="1" name="emailNotify" <?php echo $selectedActiver; ?> > <b>A</b>ctiver
                                <font style="margin-left: 30px;"></font>
                                <input type="radio" value="0" name="emailNotify" <?php echo $selectedDesactiver; ?> > <b>D</b>ésactiver
                              </label>
                           
                        </div>
                        
                        <br/>
                        <br/>
                        <div class="control-group">
                            <div id="purgeDateConnexionLogErr" class="err"></div>
                            <label id="nbResultsByPageLabel" class="control-label" for="purgeDateConnexionLog">
                                Supprimer les historiques de connexion ayant une date inferieure au  : &nbsp;
                                <?php Cesam_form_helper::renderInputDate('purgeDateConnexionLog', $settingsArray['purge_date_connexion_log']); ?>
                            </label>
                        </div>
                        
                        <br/>
                        
                        
                        
			<div on class="control-group">
				<div style="margin-left: 300px;" class="reinitButtonClass">
					<button type="submit" class="btn">Sauvegarder les paramètres</button>
				</div>
			</div>	

                        
                        
                        </div>
                        
		</form>

            
		
		
	</div>

	
	
	
</div>
<script type="text/javascript">
    focusPart('<?php echo $CHANGE_PASSWORD_OK ?>', '<?php echo $ROOT_INFOS_OK ?>', '<?php echo $SETTINGS_SYS_OK ?>');
</script>

<?php $this->session->unset_userdata('CHANGE_PASSWORD_OK'); ?>
<?php $this->session->unset_userdata('ROOT_INFOS_OK'); ?>
<?php $this->session->unset_userdata('SETTINGS_SYS_OK'); ?>
