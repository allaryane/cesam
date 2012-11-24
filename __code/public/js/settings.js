/****************************************************\
 *
 *
 *	fichier			: public/js/settings.js
 *	projet			:
 *	version			: 1.0.0 2012/11/10 11:00 JRA
 *
\****************************************************/


$(document).ready(function() { 
	validateCHANGE_PASSWORD();
        validateROOT_INFOS();
        validateSETTINGS_SYS();
}); 


$.validator.addMethod("checkTelCell", function(value) {
	if($.trim(value) == '') return true; // Le champ peut etre vide
	return cesam.checkCIPhoneNumber($.trim(value));
}, cesam.errorMessage.valErr_telCell);

$.validator.addMethod("checkEmail", function(value) {
	if($.trim(value) == '') return true; // Le champ peut etre vide
	return cesam.checkEmail($.trim(value));
}, cesam.errorMessage.valErr_email);



function focusPart(CHANGE_PASSWORD, ROOT_INFOS, SETTINGS_SYS){
    if(CHANGE_PASSWORD != null && CHANGE_PASSWORD != ''){
            $(window).scrollTop($('#CHANGE_PASSWORD').offset().top);
    }
    else if(ROOT_INFOS != null && ROOT_INFOS != ''){
            $(window).scrollTop($('#ROOT_INFOS').offset().top);
    }
    else if(SETTINGS_SYS != null && SETTINGS_SYS != ''){
            $(window).scrollTop($('#SETTINGS_SYS').offset().top);
    }
}





function validateCHANGE_PASSWORD(){	
	$("#CHANGE_PASSWORD").validate({
		ignore: "", // Permet de valider les champs cache
		rules: {
			currentPassword : "required",
			newPassword : {
                            required : true,
                            minlength : 6
                        },
			confirmNewPassword : {
                           equalTo: "#newPassword"
                        }			
		},
		messages : {
			currentPassword : {
				required : cesam.errorMessage.valErr_empty
			},
			newPassword : {
				required : cesam.errorMessage.valErr_empty,
                                minlength : cesam.errorMessage.valErr_passwordLength 
			},
		
			confirmNewPassword : {
				equalTo : cesam.errorMessage.valErr_confirmPassword
			}
		},
		errorPlacement: function(error, element) {
			error.appendTo('#'+element.attr('name')+'Err');
        }
		
	});
}

function validateROOT_INFOS(){	
	$("#ROOT_INFOS").validate({
		ignore: "", // Permet de valider les champs cache
		rules: {
			cell : {
                            checkTelCell: true
			},
			tel : {
                            checkTelCell: true
			},
			email :  {
                                required : true,
				checkEmail: true
			} 
		},
		messages : {
			tel : {
                            checkTelCell : cesam.errorMessage.valErr_telCell
			},
			cell : {
                            checkTelCell : cesam.errorMessage.valErr_telCell
			},
			email : {
                            checkEmail : cesam.errorMessage.valErr_email,
                            required : cesam.errorMessage.valErr_empty
			}
		},
		errorPlacement: function(error, element) {
			error.appendTo('#'+element.attr('name')+'Err');
        }
		
	});
}

function validateSETTINGS_SYS(){	
	$("#SETTINGS_SYS").validate({
		ignore: "", // Permet de valider les champs cache
		rules: {
			nbResultsByPageRoot : {
                            required : true,
                            number : true
                        } ,
			nbResultsByPageDoctor :{
                            required : true,
                            number : true
                        },
			purgeDateConnexionLog : "required"
		},
		messages : {
			nbResultsByPageRoot : {
				required : cesam.errorMessage.valErr_empty,
                                number : cesam.errorMessage.valErr_number
			},
			nbResultsByPageDoctor : {
                                number : cesam.errorMessage.valErr_number,
				required : cesam.errorMessage.valErr_empty                               
			},
			purgeDateConnexionLog : {
				required : cesam.errorMessage.valErr_empty
			}
		},
		errorPlacement: function(error, element) {
			error.appendTo('#'+element.attr('name')+'Err');
        }
		
	});
}
