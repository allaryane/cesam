<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$userdata = $this->session->userdata('userLoginData');

?>

<div class="leftBoxUserData">
	<div id="leftBoxUserDataHeader" class="leftBoxUserDataHeader">
		Espace ROOT
	</div>

	<div id="leftBoxUserDataContent" class="boxUserDataContent">

		
		<div style="display: block;">
			<div class="dataUserImgLeft">
				<img style="opacity:1; width: 60px; height: 60px;" src="<?php echo base_url(); ?>public/images/microscope.png" />
			</div>

			<div class="dataUserImgRight">
				Dr <?php echo $userdata->last_name.' '.$userdata->first_name ; ?><br/>
				<?php echo 'ROOT';//$userdata->email; ?>
				<br/>
				<a href="<?php echo base_url(); ?>login/disconnect"><span class="icon-off"></span> Déconnexion</a>
			</div>

			<div style="clear: both">&nbsp;</div>
		</div>
		
		<br/>
		
		<a href="<?php echo base_url(); ?>patients/addNewPatient" style="float: right"><span class="icon-plus"></span> Ajouter un patient</a>
		<br/><br/>
		
		<a href="<?php echo base_url(); ?>doctors/addNewDoctor"><span class="icon-plus"></span> Ajouter un médecin</a>
		<br/><br/>

		
		<a href="#" style="float: right"><span class="icon-trash"></span> Consulter la corbeille</a>
		<br/><br/>

		Vous avez <b>2 notifications</b> non consultées :<br/>
		<a href="#"> Le faire maintenant</a>

		<br/><br/>
		Notifications par Email : <a href="<?php echo base_url(); ?>settings#SETTINGS_SYS">Activer</a>

	</div>
</div>