<?php

/* * ********************Encoding : UTF-8 ******************************\

 * 	Fichier			: _content/modals.php
 * 	Projet			: pickmeup
 * 	Version			: 1 sept. 2012 16:09:46
 * 	Auteur			: Ryane Alla // allaryane@gmail.com
 *  \************************************************************************* */
?>

<div id="cesamInfoModal" class="modal hide slide infoModal">
	<div class="modal-header headerModal">
	<h4 id="modalTitle"></h4>
	</div>
	
	<div class="modal-body contentModal">
            
            <div class="subContentTitle" id="subContentTitle">    
            </div>
           
            <div class="subContent" id="subContent">
            </div>
            
	</div>
	
	<div class="modal-footer">
		<a href="javascript:;" onclick="$('#cesamInfoModal').modal('hide');" class="btn">OK</a>
	</div>
</div>

<div id="passwordDisplayModal" class="modal hide slide infoModal">
	<div class="modal-header headerModal">
	<h4>Cesam - Mot de passe</h4>
	</div>
	
	<div class="modal-body contentModal">
            <input value=""  id="idDoctor" style="display: none;">
            
            <div class="control-group">
                <label class="control-label" for="password">Entrez le mot de passe <b>ROOT</b> :</label>
                <div id="passwordModalErr" class="err"></div>
                <div class="controls">
                    <input class="inputRadiusClass" maxlength="15" type="password" name="password" id="password" placeholder="Mot de passe" autocomplete="off">
                </div>
            </div>
            
	</div>
	
	<div class="modal-footer">

		<a href="javascript:;" onclick="$('#passwordDisplayModal').modal('hide');" class="btn">Annuler</a>
                <a href="javascript:;" onclick=" displayPassword($('#password').val());"  class="btn btn-primary">OK</a>
	</div>
</div>