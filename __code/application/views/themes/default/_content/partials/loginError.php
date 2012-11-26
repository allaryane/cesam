<?php

/* * ********************Encoding : UTF-8 ******************************\

 * 	Fichier			: loginError.php
 * 	Projet			: pickmeup
 * 	Version			: 25 oct. 2012 00:18:03
 * 	Auteur			: Ryane Alla // allaryane@gmail.com
 *  \************************************************************************* */
?>
<?php

if(!empty($divError)){
	switch ($divError) {
	
		case LOGIN_FAILED_FIELDS_REQUIRED:
			?>

			<div class="loginFailedErrorClass">
				<div id="errorContent">
					<h1>Nom d'utilisateur et mot de passe obligatoire(s)</h1>
					Assurez vous que le nom d'utilisateur et le password saisis sont correctes.<br/>
					Veuillez réessayer (vérifiez aussi que le verrouillage des majuscules est désactivé).
				</div>
			</div>

			<?php
			break;

		case LOGIN_FAILED_USERNAME_NOT_VALID:
			?>

			<div class="loginFailedErrorClass">
				<div id="errorContent">
					<h1>Nom d'utilisateur incorrecte</h1>
					Le nom d’utilisateur n’est associé à aucun compte.<br/>
					Veuillez réessayer (vérifiez aussi que le verrouillage des majuscules est désactivé).
				</div>
			</div>

			<?php
			break;


		case LOGIN_FAILED_PASSWORD_NOT_VALID:
			?>
			
			<div class="loginFailedErrorClass">
				<div id="errorContent">
					<h1>Mot de passe incorrecte</h1>
					Le mot de passe que vous avez saisi est incorrecte.<br/>
					Veuillez réessayer (vérifiez aussi que le verrouillage des majuscules est désactivé).
					<br/><br/>
					Mot de passe oublié ? <a href="#">En demander un nouveau.</a>
				</div>
			</div>


			<?php
			break;

		default:
			break;
	}
}
		
?>