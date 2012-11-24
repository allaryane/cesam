<?php
/* * **************************************************\
 *
 * 	fichier			: views/themes/default/_content/addNewPatient.php
 * 	projet			:
 * 	version			: 2012/03/10 10:40 JRA
 *
  \*************************************************** */ 

$infosDoctorObj = NULL;
$allPatientsData = NULL;
if(!empty($recordData)){
	$infosDoctorObj = $recordData['infosDoctorObj'];
        $allPatientsData = $recordData['arrayPatientsObj'];
}
//echo '<pre>';
//print_r($allPatientsData);
//echo '</pre>';
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
	Consultation de la fiche Médecin. Vous pouvez aussi modifier les informations de la fiche.
	</div>

        <?php
        if($addDoctorOK || $modifyDoctorOK){ 
            $message = '';
            if($addDoctorOK) $message = 'Médecin enregistré avec succès !';
            if($modifyDoctorOK) $message = 'Fiche Médecin modifié avec succès !';
        ?>

        <div class="divMessagesSucces">
                <div id="subContent">
                    <h1><img width="25" height="25" src="<?php echo base_url(); ?>public/images/success.png" /><?php echo $message; ?></h1>
                </div>
        </div>
        <?php
        }
        ?>

	<div class="reinitButtonClass">
            <?php 
                
                if(strtoupper($this->history->end()) == PAGE_ID_DOCTORS){
            ?>
                   <button class="btn" onclick="window.location = '<?php echo base_url().'doctors'; ?>';" type="button">Revenir à la liste des médecins</button>  
            <?php
                } 
            ?>
            <button class="btn" onclick="window.location = '<?php echo base_url().'doctors/modifyDoctor/'.$infosDoctorObj->id; ?>';" type="button"><b>Modifier la fiche médecin</b></button>
            <button class="btn" onclick="alert('Supprimer');" type="button">Supprimer la fiche médecin</button>

	</div>
	<div style="clear: both;"></div>	
	
	<div  id="cesamForm" class="form-vertical">
            <legend style="margin-bottom: 2px!important;" class="lengendForm"><label>Informations Médecin</label></legend>
                <label style="float: right; font-style: italic;">Ajouté le : <?php echo Cesam_date_format_helper::sqlFormatToCesam($infosDoctorObj->registration_date); ?></label>
                
                <div style="clear: both;"></div>
                
		<div class="verticalSpaceAfterLengendForm"></div>
		
		<div class="span5">
			
		<div class="control-group">
			<label class="recordLabelTitleFirst"><u>Nom : </u></label>
			<label class="recordLabelData"><?php echo $infosDoctorObj->last_name; ?></label>
		</div>
		<div class="control-group">
			<label class="recordLabelTitle"><u>Prénom(s) : </u></label>
			<label class="recordLabelData"><?php echo $infosDoctorObj->first_name; ?></label>
		</div>
		
                <div class="control-group">
			<label class="recordLabelTitle"><u>Adresse email : </u></label>
			<label class="recordLabelData"><?php echo $infosDoctorObj->email; ?></label>
		</div>
		
                    
		<div class="control-group">
			<label class="recordLabelTitle"><u>N° de Tel ou Cell : </u></label>
			<label class="recordLabelData"><?php echo $infosDoctorObj->cell; ?></label>
		</div>
		
		
		</div>
		
		
		<div class="span5">
                
                <div class="control-group">
			<label class="recordLabelTitle"><u>Code permanent : </u></label>
			<label class="recordLabelData bigText"><?php echo $infosDoctorObj->username; ?></label>
		</div>
		    
                <div class="control-group">
			<label class="recordLabelTitle"><u>Mot de passe : </u><font id ="loadingPassword"></font></label>
                        <?php //echo $infosDoctorObj->password; ?>
                        <label id="passwordLabel" class="recordLabelData bigText"><button class="btn" onclick="openDisplayPasswordModal(<?php echo $infosDoctorObj->id; ?>);" type="button">Afficher mot de passe</button></label>
                        
                </div>
                  
		</div>

		<div style="clear: both;"></div>
                
                <legend style="margin-top: 20px;" class="lengendForm"><label><?php echo count($allPatientsData); ?> patient(s) assigné(s)</label></legend>
                
                <div class="resultsPatientsTable">
                    <table class="table table-hover">
                            <thead>
                                    <tr>
                                    <th>N° dossier Cesam</th>
                                    <th>Nom et Prénom(s)</th>
                                    <th>Sexe</th>
                                    <th>Age</th>
                                    <th>Statut</th>
                                    <th>Ajouté le</th>
                                    </tr>
                            </thead>
                            <tbody>
                            <?php
                                $nb = 1;
                                $alternColor = '';
                                foreach ((array)$allPatientsData as $patient){
                                    if($nb % 2 == 0) $alternColor = 'alternColor2';
                                    else $alternColor = 'alternColor1';
                                    if(count($allPatientsData) == 1) $patient = $allPatientsData;
                            ?>
                                <tr onclick="window.location = '<?php echo base_url().'patients/recordPatient/'.$patient->id; ?>';" class="<?php echo $alternColor; ?>">
                                            <td><?php echo $patient->num_dossier_cesam; ?></td>
                                            <td><?php echo $patient->last_name.' '.$patient->first_name; ?></td>
                                            <td><?php echo $patient->sexe; ?></td>
                                            <td><?php echo Cesam_date_format_helper::getAge($patient->birthday); ?> ans</td>
                                            <td><?php echo str_replace('_', ' ',$patient->dossier_state); ?></td>
                                            <td><?php echo Cesam_date_format_helper::sqlFormatToCesam($patient->create_date); ?></td>
                                    </tr>
                            <?php
                                    if(count($allPatientsData) == 1) break;
                                    $nb ++;
                                }
                            ?>	
                            </tbody>
                    </table>
                    <?php 
                    if(empty($allPatientsData)){
                    ?>        
                    <div class="divErrorNoData" style="margin-bottom: 40px!important;">
                        <center>
                            <img width="50" height="50" src="<?php echo base_url(); ?>public/images/empty.jpg">
                            Aucun patient assigné à ce médecin.
                        </center>
                    </div>
                    <?php
                    }
                    ?>
            
            
	</div>

                
                 
	</div>

	
</div>
<?php $this->session->unset_userdata('addDoctorOK'); ?>
<?php $this->session->unset_userdata('modifyDoctorOK'); ?>