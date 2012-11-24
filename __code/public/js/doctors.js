/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var stateLoading = '<img width="14" height="14" style="margin-left: 13px;"  src="'+cesam.url + 'public/images/loading.gif" />';
var delayToHidePassword = 30000; // 20 secondes


$(document).ready(function() { 
	validateAddDoctor();
}); 


function openDisplayPasswordModal(idDoctor){
    // On passe le id a la modal
    $('#idDoctor').val(idDoctor);
    $('#passwordDisplayModal').modal({show: true,  backdrop: 'static'});
}


function displayPassword(password){
    var idDoctor = $('#idDoctor').val();
    var buttonDisplayPassword = '<button class="btn" onclick="openDisplayPasswordModal('+idDoctor+');" type="button">Afficher mot de passe</button>';
    //alert(password + ' - '+idDoctor);
    if($.trim(password) != ''){
        $('#loadingPassword').html(stateLoading);
        $('#passwordDisplayModal').modal('hide');
    }
    else {
        $('#passwordModalErr').html(cesam.beforeErrorText + 'Erreur : le mot de passe entrez est vide !');
    }

    dataPost = 'idDoctor='+idDoctor+'&password='+password;
    $.ajax({
        cache: false,
        type: "POST",
        url: cesam.url +'doctors/displayPassword',
        data: dataPost,
        success: function(response){ 
            $('#loadingPassword').html('');
            $('#password').val('');
            if(response != '0' && response != '-1') {
                
                $("#passwordLabel").html(response);
                setTimeout(function() {
                    
                    $("#passwordLabel").html(buttonDisplayPassword);
                
                }, delayToHidePassword);
            }
            else if(response == '0') cesam.alertInfo('Cesam - Mot de passe incorrecte', 'Oops !!!', 'Le mot de passe que vous avez saisi est incorrecte.<br/>Veuillez réessayer (vérifiez aussi que le verrouillage des majuscules est désactivé).');
            else ('Cesam - Mot de passe (Erreur système)', 'Oops !!!', 'Erreur lors de l\'envoi du mot de passe ! Veuillez reéssayer.');
        },
        complete: function() {},
        error: function(xhr, textStatus, errorThrown) {
                    alert('Erreur lors de l\'envoi du mot de passe ! Veuillez reéssayer.');
       }
    });

}

$.validator.addMethod("checkTelCell", function(value) {
	if($.trim(value) == '') return true; // Le champ peut etre vide
	return cesam.checkCIPhoneNumber($.trim(value));
}, cesam.errorMessage.valErr_telCell);

$.validator.addMethod("checkEmail", function(value) {
	if($.trim(value) == '') return true; // Le champ peut etre vide
	return cesam.checkEmail($.trim(value));
}, cesam.errorMessage.valErr_email);

function validateAddDoctor(){	
	$("#cesamForm").validate({
		ignore: "", // Permet de valider les champs cache
		rules: {
			doctorLastName : "required" ,
			doctorFirstName : "required",
			code_permanent : "required",
			password : "required",
			telCell : {
				checkTelCell: true
			},
			email :  {
				checkEmail: true
			} 
		},
		messages : {
			doctorLastName : {
				required : cesam.errorMessage.valErr_empty
			},
			doctorFirstName : {
				required : cesam.errorMessage.valErr_empty
			},
			code_permanent : {
				required : cesam.errorMessage.valErr_empty
			},
			password : {
				required : cesam.errorMessage.valErr_empty
			},
			telCell : {
				checkTelCell : cesam.errorMessage.valErr_telCell
			},
		
			email : {
				checkEmail : cesam.errorMessage.valErr_email
			}
		},
		errorPlacement: function(error, element) {
			error.appendTo('#'+element.attr('name')+'Err');
        }
		
	});
}

function generateCodePermanent(){
    $('#code_permanent').val(cesam.generateRandom(8,false));
}

function generatePassword(){
    $('#password').val(cesam.generateRandom(8,false));
}