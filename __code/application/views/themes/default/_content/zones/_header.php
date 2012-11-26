<?php

$userdata = $this->session->userdata('userLoginData');

?>

<div  class="container-fluid">
	<div id="headerCesam" class="row-fluid">
		<img  src="<?php echo base_url(); ?>public/images/microscope.png" />
		Laboratoire CE.S.A.M
	</div>
	<?php
        if($userdata->type == USER_TYPE_ROOT){
        ?>
	<div class="row-fluid">
        <div>
		<!--Header bar-->
		<div class="pmuNavBar">
			<div class="navbar">
				<div class="navbar-inner">
				<a class="brand" href="<?php echo base_url(); ?>dashboard"><font color="#3BB9FF"><b>Cesam</b></font></a>
				<ul class="nav">
				<?php
				$activeDashboard = "";
				$activePatients = "";
				$activeDoctors = "";
				$activeConnexionLog = "";
				$activeSettings = "";
				$activeFaq = "";
				
				switch ($pageId) {
					case PAGE_ID_DASHBOARD:
						$activeDashboard = 'active';
						break;

					case PAGE_ID_PATIENTS:
						$activePatients = 'active';
						break;

					case PAGE_ID_DOCTORS:
						$activeDoctors = 'active';
						break;

					case PAGE_ID_CONNEXION_LOG:
						$activeConnexionLog = 'active';
						break;

					case PAGE_ID_SETTINGS:
						$activeSettings = 'active';
						break;

					case PAGE_ID_FAQ:
						$activeFaq = 'active';
						break;
					
                                        
					default:
						break;
				}
				
				?>
				
				<li class="<?php echo $activePatients; ?>"><a href="<?php echo base_url(); ?>patients">Patients</a></li>			
				<li class="<?php echo $activeDoctors; ?>"><a href="<?php echo base_url(); ?>doctors">Médecins</a></li>
				<li class="<?php echo $activeConnexionLog; ?>"><a href="<?php echo base_url(); ?>connexionlog">Log connexions</a></li>
				<li class="<?php echo $activeSettings; ?>"><a href="<?php echo base_url(); ?>settings">Paramètres</a></li>
				<li class="<?php echo $activeFaq; ?>"><a href="<?php echo base_url(); ?>faq">Description du système</a></li>
				</ul>
			
				<form class="navbar-search pull-right">
					<input type="text" class="search-query" placeholder="Rechercher dans un document">
				</form>
			</div>
			</div>
		</div>
    </div>
  </div>

        <?php
        }
        else{
        ?>
        <div class="row-fluid">
        <div>
                <!--Header bar-->
                <div class="pmuNavBar">
                        <div class="navbar">
                                <div class="navbar-inner">
                                <a class="brand" href="<?php echo base_url(); ?>mypatients"><font color="#3BB9FF"><b>Cesam</b></font></a>
                
                                <form method="post" action="<?php echo base_url(); ?>mypatients" class="navbar-search pull-right divSearch">                         
                                    <input type="text" name="searchTerm" value="<?php echo @$searchTerm; ?>" placeholder="Rechercher un patient selon une catégorie"/>
                                    <?php
                                    $options = array(SEARCH_BY_NAME => 'Nom et/ou Prénom(s)',
                                                     SEARCH_BY_CESAM_DOSSIER_NUM => 'N° dossier Cesam');
                                    
                                    Cesam_form_helper::makeSelectField('category', '', @$category, $options);
                                    ?>
                                </form>
                        </div>
                        </div>
                </div>
        </div>
        </div>

    
    
    
    
        <?php
        }
        ?>
</div>
