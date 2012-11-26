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
	Consulter l'historique des connexions des médecins
	</div>

        <div class="connexionLogClass">
            <center><label>Historique des connexions médecins</label></center>
            <br/>
            <table class="table table-hover">
                        <tbody>
                            <?php
                            foreach ((array)$logArray as $objLog) {
                                $nb = 1;
                                $alternColor = '';
                                if($nb % 2 == 0) $alternColor = 'alternColor2';
                                else $alternColor = 'alternColor1';
                                if(count($logArray) == 1) $objLog = $logArray;
                            ?>
                                
                            <tr>
                                <td><?php echo $listDoctor[$objLog->id_user]; ?></td>
                                <td><?php echo Cesam_date_format_helper::sqlFormatToCesam($objLog->log_date); ?></td>
                            </tr>
                                
                            <?php    
                                if(count($logArray) == 1) break;
                                $nb ++;

                            }
                            ?>
                    
                        </tbody>
            </table>
                <?php 
                if(empty($logArray)){
                ?>        
                <div class="divErrorNoData">
                    <center>
                  
                        <img width="50" height="50" src="<?php echo base_url(); ?>public/images/empty.jpg">
                        Aucune connexion "Médecin" à ce jour !!.
                        
                    </center>
                </div>
                <?php
                }
                ?>
        </div>

	
	
</div>