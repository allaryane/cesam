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
	Ajoutez un nouveau médecin ou Recherchez-en un
	</div>
	
	
	
	<div class="divSearch">
            <form method="post" action="" >
		<input name="searchTerm" value="<?php echo @$searchTerm; ?>" type="text" placeholder="Rechercher un médecin par son som et/ou prénom(s)"/>
            </form>
        </div>
	
	<div class="reinitButtonClass">
		<button class="btn" onclick="window.location = cesam.url+'doctors/addNewDoctor';" type="button"><span class="icon-plus"></span> Ajouter un medecin</button>
	</div>
	<div style="clear: both;"></div>
	
	
	<div class="searchTitle">
                    <?php
                if($searchSate){
                ?>
                    <center><?php echo $nbDoctors; ?> Médecin(s) trouvé(s) pour cette recherche</center>
                <?php
                }
                else{
                ?>
                    <center><?php echo $nbDoctors; ?> Médecin(s) au total</center>
                <?php     
                }
                ?>
		
		<hr/>
	</div>
	
	<div class="resultsPatientsTable">
		<table class="table table-hover">
			<thead>
				<tr>
				<th>Nom et Prénom(s)</th>
				<th>Dernière connexion</th>
				<th>Ajouté le</th>
				</tr>
			</thead>
			<tbody>
                        <?php
                            $nb = 1;
                            $alternColor = '';
                            foreach ((array)$allDoctorsData as $doctor){
                                if($nb % 2 == 0) $alternColor = 'alternColor2';
                                else $alternColor = 'alternColor1';
                                if(count($allDoctorsData) == 1) $doctor = $allDoctorsData;
                                $lastConnection = $doctor->is_connected;
                                if($lastConnection == '0000-00-00 00:00:00') $lastConnection = 'Jamais connecté';
                                else $lastConnection = Cesam_date_format_helper::sqlFormatToCesam($lastConnection);
                        ?>    
				<tr onclick="window.location = '<?php echo base_url().'doctors/recordDoctor/'.$doctor->id; ?>';" class="<?php echo $alternColor; ?>">
					<td>Dr. <?php echo $doctor->last_name.' '.$doctor->first_name; ?></td>
					<td><?php echo $lastConnection; ?></td>
					<td><?php echo Cesam_date_format_helper::sqlFormatToCesam($doctor->registration_date); ?></td>
				</tr>
			<?php
                                if(count($allDoctorsData) == 1) break;
                                $nb ++;
                            }
                        ?>
				
			</tbody>
		</table>
                <?php 
                if(empty($allDoctorsData)){
                ?>        
                <div class="divErrorNoData">
                    <center>
                               <?php
                        if($searchSate){
                        ?>
                        
                        !! Aucun resultat pour la recherche <b>"<?php echo $searchTerm; ?>"</b>.
                      
                        <?php
                        }
                        else{
                        ?>
                      
                        <img width="50" height="50" src="<?php echo base_url(); ?>public/images/empty.jpg">
                        Aucun Médecin dans la base de données.
                        <br/>
                        <br/>
                        <a style="font-size: 15px!important;" href="<?php echo base_url().'doctors/addNewDoctor' ?>"><i class="icon-plus"></i>Ajouter un nouveau médecin</a>
                    
                        
                        
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