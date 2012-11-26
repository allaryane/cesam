<?php
/* * **************************************************\
 *
 * 	fichier			: views/themes/default/_content/mypatients.php
 * 	projet			:
 * 	version			: 2012/03/10 10:40 JRA
 *
  \*************************************************** */
?>



<div id="centralBox" class="centralBox">
	<div id="centralBoxHeader" class="centralBoxHeader">
	Consultez les fiches et les fichiers de vos patients  
	</div>
	
	
	<div class="searchTitle" style="margin-top: 50px;">
                <?php
                if($searchSate){
                ?>
                    <center><?php echo $nbPatients; ?> Patient(s) trouvé(s) pour cette recherche</center>
                <?php
                }
                else{
                ?>
                    <center>Vous avez <?php echo $nbPatients; ?> Patient(s)</center>
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
                            <tr onclick="window.location = '<?php echo base_url().'mypatients/recordPatient/'.$patient->id; ?>';" class="<?php echo $alternColor; ?>">
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
                <div class="divErrorNoData">
                    <center>
                        <?php
                        if($searchSate){
                        $options = array(SEARCH_BY_NAME => 'Nom et/ou Prénom(s)',
                                                     SEARCH_BY_CESAM_DOSSIER_NUM => 'N° dossier Cesam');
                        ?>
                        
                        !! Aucun resultat pour la recherche <b>"<?php echo $searchTerm; ?>"</b> dans la categorie <b>"<?php echo $options[$category]; ?>"</b>.
                      
                        <?php
                        }
                        else{
                        ?>
                        <img width="50" height="50" src="<?php echo base_url(); ?>public/images/empty.jpg">
                        Vous n'avez pas encore de patient(s).
                        <br/>
                                                
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