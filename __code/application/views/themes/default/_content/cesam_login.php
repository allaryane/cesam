<?php
/* * **************************************************\
 *
 * 	fichier			: views/themes/default/_content/welcome.php
 * 	projet			:
 * 	version			: 1.0.2 2012/02/14 22:40 JRA
  \*************************************************** */
?>

<div id="contentWelcome" class="contentBox">

<div class="span4">
	<img style="opacity:1;height: 200px;padding-left: 50px;"  src="<?php echo base_url(); ?>public/images/microscope.png" />
	<img style="opacity:1;height: 140px;padding-left: 20px;"  src="<?php echo base_url(); ?>public/images/microscope.png" />
	<img style="opacity:1;height: 100px;padding-left: 20px;"  src="<?php echo base_url(); ?>public/images/microscope.png" />
</div>

	<div class="span8" style="padding-right: 70px!important;">

	<form class="registrationFormClass" id="loginFailedForm" action="<?php echo base_url(); ?>login/connect" method="POST">
		
		<div class="loginFailedTitle">
			<span>Connexion Cesam</span>
			<hr/>
		</div>
		
		<?php
		// Gestion des erreurs
		echo Bktemplate_helper::render_partial('_content/partials/loginError', array('divError' => $divError));
		?>
		
		<div class="loginFailedFormClass">

		<fieldset>
			<div><label for="username">Code permanent : </label><input type="text" name="username" id="username" value="" /></div>
			<div><label for="password">Mot de passe : </label><input name="password" type="password" id="password" value="" /></div>
			
			
			<div>
				<label for="empty">&nbsp;</label>
				<input class="inputRegistrationButton" id="connexionButton" type="submit" value="Connexion" />
			</div>
						

		</fieldset>
		</div>
	</form>

</div>
			
</div>
<?php $this->session->unset_userdata('loginDivError'); ?>