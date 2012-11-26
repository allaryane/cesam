<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div id="headerLogoutPart"  class="container-fluid headerPart">
	<div class="row-fluid">
		<div class="logoText span4">
			<a href="<?php echo base_url(); ?>">Cesam</a>
		</div>
		<?php if(isset($loginForm) && $loginForm) { ?>
		<div class="loginBox span8">
			<form id="loginForm" name="loginForm" action="<?php echo base_url(); ?>login/connect" method="post">
			<table class="loginTable" cellspacing="0">
				<tr>
					<td>Adresse électronique</td>
					<td>Mot de passe</td>
				</tr>
				<tr>
					<td><input class="inputLogin" name="username" id="username" type="text" value="" /></td>
					<td><input class="inputLogin" name="password" id="password" type="password" value="" /></td>
					<td><input class="inputConnexionButton" id="connexionButton" type="submit" value="Connexion" /></td>
				</tr>
				<tr>
					<td><input type="checkbox" name="keepMeLogin" id="keepMeLogin"/><label class="keepMySession">Garder ma session active</label></td>
					<td><a class="linkForgotPass" onclick="$('#passwordForgotModal').modal({show: true,  backdrop: 'static'});" href="javascript:;">Mot de passe oublié ?</a></td>
				</tr>
			</table>
			
				<div style="clear: both"></div>
			</form>
		</div>
		<?php } ?>
	</div>
</div>