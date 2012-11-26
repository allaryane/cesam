<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$userdata = $this->session->userdata('userLoginData');

//echo $userdata->type;
if($userdata->type == USER_TYPE_ROOT){
?>

<div class="leftBoxUserData">
	<div id="leftBoxUserDataHeader" class="leftBoxUserDataHeader">
		Espace ROOT
	</div>

	<div id="leftBoxUserDataContent" class="boxUserDataContent">

		
		<div style="display: block;">
			<div class="dataUserImgLeft">
				<img style="opacity:1; width: 60px; height: 60px;" src="<?php echo base_url(); ?>public/images/root.png" />
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
                
                <div style="clear: both">&nbsp;</div>
	</div>
</div>

<?php
}
else {
?>

<div class="leftBoxUserData">
	<div id="leftBoxUserDataHeader" class="leftBoxUserDataHeader">
		Espace personnel
	</div>

	<div id="leftBoxUserDataContent" class="boxUserDataContent">

		
		<div style="display: block;">
			<div class="dataUserImgLeft">
				<img style="opacity:1; width: 60px; height: 60px;" src="<?php echo base_url(); ?>public/images/doctor.png" />
			</div>

			<div class="dataUserImgRight">
				Dr <?php echo $userdata->last_name.' '.$userdata->first_name ; ?><br/>
				<?php if(!empty($userdata->email)) echo $userdata->email; ?>
				<br/>
				<a href="<?php echo base_url(); ?>login/disconnect"><span class="icon-off"></span> Déconnexion</a>
			</div>

			<div style="clear: both">&nbsp;</div>
		</div>
		
                <br/>
                
                <a href="<?php echo base_url(); ?>mypatients" style="float: right"><span class="icon-list-alt"></span> Liste des patients</a>
		
	
        	
                <div style="float: left; margin-top: 50px;">
		Vous avez <b>2 notifications</b> non consultées :<br/>
		<a href="#"> Le faire maintenant</a>
                </div>
		
		<div style="float: right; margin-top: 30px;">
                    Notifications par Email : <a href="#">Activer</a>
                </div>

                
                <a href="<?php echo base_url(); ?>contact" style="float: left; margin-top: 100px;"><img src="<?php echo base_url(); ?>public/images/contact.png" width="25" height="25"> Contactez Cesam</a>
			
                
                <div style="clear: both">&nbsp;</div>
	</div>
</div>


<?php
}
?>