<?php
/* * **************************************************\
 *
 * 	fichier			: views/themes/default/_content/dashboard.php
 * 	projet			:
 * 	version			: 2012/03/10 10:40 JRA
 *
  \*************************************************** */
?>



<div id="centralBox" class="centralBox">
	<div id="centralBoxHeader" class="centralBoxHeader">
	Ajoutez un nouveau patient ou Recherchez-en un 
	</div>
	
	<div class="divSearch">
                <form method="post" action="" >
                <input type="text" name="searchTerm" value="<?php echo @$searchTerm; ?>" placeholder="Rechercher un patient selon une catégorie"/>
                <?php
		$options = array(SEARCH_BY_NAME => 'Nom et/ou Prénom(s)',
                                 SEARCH_BY_CESAM_DOSSIER_NUM => 'N° dossier Cesam',
                                 SEARCH_BY_DOCTOR_NAME => 'Nom du médecin');
		Cesam_form_helper::makeSelectField('category', '', @$category, $options);
		?>
                </form>
	</div>
	
	<div class="reinitButtonClass">
		<button class="btn" onclick="window.location = cesam.url+'patients/addNewPatient';" type="button"><span class="icon-plus"></span> Ajouter un patient</button>
	</div>
	<div style="clear: both;"></div>
	
	
	<div class="searchTitle">
                <?php
                if($searchSate){
                ?>
                    <center><?php echo $nbPatients; ?> Patient(s) trouvé(s) pour cette recherche</center>
                <?php
                }
                else{
                ?>
                    <center><?php echo $nbPatients; ?> Patient(s) et <?php echo $nbFiles; ?> Fichier(s) attaché(s)</center>
                <?php     
                }
                ?>
                
                <hr/>
	</div>
	
	<div class="resultsPatientsTable">
		<table class="table table-hover">
			<thead>
				<tr>
				<th>N° dossier Cesam</th>
				<th>Nom et Prénom(s)</th>
				<th>Sexe</th>
				<th>Age</th>
				<th>Médecin</th>
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
                            <tr onclick="window.location = '<?php echo base_url().'patients/recordPatient/'.$patient->id_patient; ?>';" class="<?php echo $alternColor; ?>">
					<td><?php echo $patient->num_dossier_cesam; ?></td>
					<td><?php echo $patient->last_name.' '.$patient->first_name; ?></td>
					<td><?php echo $patient->sexe; ?></td>
                                        <td><?php echo Cesam_date_format_helper::getAge($patient->birthday); ?> ans</td>
					<td><?php echo $doctorList[$patient->id_doctor]; ?></td>
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
                <div class="divErrorNoData">
                    <center>
                        <?php
                        if($searchSate){
                        ?>
                        
                        !! Aucun resultat pour la recherche <b>"<?php echo $searchTerm; ?>"</b> dans la categorie <b>"<?php echo $options[$category]; ?>"</b>.
                      
                        <?php
                        }
                        else{
                        ?>
                        <img width="50" height="50" src="<?php echo base_url(); ?>public/images/empty.jpg">
                        Aucun patient dans la base de données.
                        <br/>
                        <br/>
                        <a style="font-size: 15px!important;" href="<?php echo base_url().'patients/addNewPatient' ?>"><i class="icon-plus"></i>Ajouter un nouveau patient</a>
                        
                        <?php
                        }
                        ?>
                    </center>
                </div>
                <?php
                }
                ?>
            
            
	</div>

</div>