/****************************************************\
 *
 *
 *	fichier			: public/js/patients.js
 *	projet			:
 *	version			: 1.0.0 2012/11/10 11:00 JRA
 *
\****************************************************/


$(document).ready(function() { 
    validateAddPatient();
}); 

$.validator.addMethod("checkTelCell", function(value) {
	if($.trim(value) == '') return true; // Le champ peut etre vide
	return cesam.checkCIPhoneNumber($.trim(value));
}, cesam.errorMessage.valErr_telCell);

$.validator.addMethod("checkBirthday", function(value) {
	if($('#date_naissancebDay').val() == '' || 
	   $('#date_naissancebMonth').val() == '' || 
	   $('#date_naissancebYear').val() == '') return false;
	return true;
}, cesam.errorMessage.valErr_birthday);





function validateAddPatient(){	
	$("#cesamForm").validate({
		ignore: "", // Permet de valider les champs cache
		rules: {
			patientLastName : "required" ,
			patientFirstName : "required",
			date_naissance : {
				checkBirthday : true
			},
			prelevement : "required",
			ordonnance : "required",
			sexe : "required",
			assignation : "required",
			statut : "required",
			telCell : {
				checkTelCell: true
			},
			num_dossier : "required" 
		},
		messages : {
			patientLastName : {
				required : cesam.errorMessage.valErr_empty
			},
			patientFirstName : {
				required : cesam.errorMessage.valErr_empty
			},
			date_naissance : {
				required : cesam.errorMessage.valErr_birthday
			},
			prelevement : {
				required : cesam.errorMessage.valErr_empty
			},
			ordonnance : {
				required : cesam.errorMessage.valErr_empty
			},
			telCell : {
				checkTelCell : cesam.errorMessage.valErr_telCell
			},
			sexe : {
				required : cesam.errorMessage.valErr_empty
			},
			
			statut : {
				required : cesam.errorMessage.valErr_empty
			},
			
			assignation : {
				required : cesam.errorMessage.valErr_empty
			},
			num_dossier : {
				required : cesam.errorMessage.valErr_empty
			}
		},
		errorPlacement: function(error, element) {
			error.appendTo('#'+element.attr('name')+'Err');
        }
		
	});
}