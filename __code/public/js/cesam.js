/****************************************************\
 *
 *
 *	fichier			: public/js/cesam.js
 *	projet			:
 *	version			: 1.0.0 2012/11/10 11:00 JRA
 *
\****************************************************/

/*
 * Classe Cesam : Cette classe contient toutes les methodes statiques de l'application. 
 */
var Cesam = $.inherit({
	
	__constructor : function(){
		// Stocke l'url de base
		this.url = $('meta[name="site_url"]').attr('content');
		this.initDatePicker();
		this.initTimePicker();
		this.passwordLenght = 6;
		this.monthsCorrespondence = {
									 'Janvier': '01',
									 'Février' : '02',
									 'Mars' : '03',
									 'Avril' : '04',
									 'Mai' : '05',
									 'Juin' : '06',
									 'Juillet' : '07',
									 'Août' : '08',
									 'Septembre' : '09',
									 'Octobre' : '10',
									 'Novembre' : '11',
									 'Décembre' : '12'};
		this.monthsCorrespondenceNumber = {
									 '01' :'Janvier',
									 '02' :'Février',
									 '03' : 'Mars',
									 '04' : 'Avril',
									 '05' :'Mai',
									 '06' :'Juin',
									 '07' : 'Juillet',
									 '08' : 'Août',
									 '09' :'Septembre',
									 '10' :'Octobre',
									 '11' : 'Novembre',
									 '12' : 'Décembre'};
	
		
		this.monthNamesMin = ["Jan", "Fév", "Mar", "Avr", "Mai", "Jui", "Juil", "Aoû", "Sep", "Oct", "Nov", "Déc" ];
		this.beforeErrorText = '<span class="icon-arrow-down"></span>';
		this.errorMessage = {
				valErr_empty : this.beforeErrorText + 'Ce champ est obligatoire.',
                                valErr_passwordLength : this.beforeErrorText + 'Le mot de passe doit contenir au moins 6 caractères.',
                                valErr_number : this.beforeErrorText + 'Ce champ doit contenir un nombre.',
				valErr_confirmPassword : this.beforeErrorText + 'Le mot de passe confirmer ne correspond pas au champ Nouveau mot de passe',                                
				valErr_email : this.beforeErrorText + 'Adresse email invalide.',
				valErr_birthday : this.beforeErrorText + 'Ce champ est obligatoire.<br/> Entrez le jour, le mois et l\'année.',
				valErr_telCell : this.beforeErrorText + 'Le format du numero de tel ou cell est : 07 97 23 50 , 07-97-23-50 ou 07.97.23.50'
			};
	},
	
        
        alertInfo:function(modalTitle, subContentTitle, subContent){
            if(modalTitle != '') $('#modalTitle').html(modalTitle);
            else $('#modalTitle').html($('title').text());
                
            if(subContentTitle != '') $('#subContentTitle').html(subContentTitle);
            if(subContent != '') $('#subContent').html(subContent);
            $('#cesamInfoModal').modal({show: true,  backdrop: 'static'});
        },
        
        generateRandom:function(length, special) {
            var iteration = 0;
            var password = "";
            var randomNumber;
            if(special == undefined){
                var special = false;
            }
            while(iteration < length){
              randomNumber = (Math.floor((Math.random() * 100)) % 94) + 33;
              if(!special){
                if ((randomNumber >=33) && (randomNumber <=47)) { continue; }
                if ((randomNumber >=58) && (randomNumber <=64)) { continue; }
                if ((randomNumber >=91) && (randomNumber <=96)) { continue; }
                if ((randomNumber >=123) && (randomNumber <=126)) { continue; }
              }
              iteration++;
              password += String.fromCharCode(randomNumber);
            }
            return password;
        },

	formatDatePickerDateToSqlDateFormat:function(newDate){
		var tab = newDate.split(' ');
		//Le format retourne est 2012-05-30 17:39:05
		return tab[2] + '-' + this.monthsCorrespondence[tab[1]] + '-' + tab[0];
	},
	
	formatSqlDateFormatToDatePickerDate:function(newDate){
		var tab = newDate.split('-');
		//console.log(tab);
		return tab[2] + ' ' + this.monthsCorrespondenceNumber[tab[1]] + ' ' + tab[0];
	},


	renderInputDate:function(inputID, defaultDate){
		if(defaultDate != ''){
			$("#"+inputID+"TempDate").val(cesam.formatSqlDateFormatToDatePickerDate(defaultDate));
			$('#'+inputID).val(defaultDate);
		}
		
		$("#"+inputID+"TempDate").change( function() {
			var dateField = cesam.formatDatePickerDateToSqlDateFormat($("#"+inputID+"TempDate").val());
			$('#'+inputID).val(dateField);
		});
	},
	
	renderInputDateHour:function(inputID,defaultDate){
		var dateField = '';
		var hourField = '00:00';
		
		if(defaultDate != ''){
			var tab = defaultDate.split(' ');
			dateField = tab[0];
                        
			$("#"+inputID+"Date").val(dateField);
			var hTab = tab[1].split(':');
                        hourField = hTab[0] + ':' + hTab[1];
			$("#"+inputID+"Heure").val(hourField);
			$('#'+inputID).val(defaultDate);
		}
		
		
		$("#"+inputID+"Date").change( function() {
                        //alert(defaultDate);
			dateField = cesam.formatDatePickerDateToSqlDateFormat($("#"+inputID+"Date").val());
                        $('#'+inputID).val(dateField + ' ' + hourField + ':00');
		});
		$("#"+inputID+"Heure").change( function() {
			//alert(defaultDate);
                        hourField = $("#"+inputID+"Heure").val();
			$('#'+inputID).val(dateField + ' ' + hourField + ':00');
		});
	},
	
	renderInputBirthDay:function(inputID, defaultDate){
		var bDay = '';
		var bMonth = '';
		var bYear = '';
		
		if(defaultDate != ''){
			var tab = defaultDate.split('-');
			bDay = tab[2];
			bMonth = tab[1];
			bYear = tab[0];
			$('#'+inputID).val(bYear + '-' + bMonth + '-' + bDay);
		}
			
		$("#"+inputID+"bDay").change( function() {
			bDay = $("#"+inputID+"bDay").val();
			$('#'+inputID).val(bYear + '-' + bMonth + '-' + bDay);
		});

		$("#"+inputID+"bMonth").change( function() {
			bMonth = $("#"+inputID+"bMonth").val();
			$('#'+inputID).val(bYear + '-' + bMonth + '-' + bDay);
		});

		$("#"+inputID+"bYear").change( function() {
			bYear = $("#"+inputID+"bYear").val();
			$('#'+inputID).val(bYear + '-' + bMonth + '-' + bDay);
		});

		
		
	},

	initDatePicker : function(){
		$(document).ready(function() { 
			$( ".datePicker" ).datepicker({ 
			dateFormat: "dd MM yy",
			prevText: "Suivant" ,
			dayNamesMin: [ "Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa" ],
			dayNames: [ "Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi" ],
			monthNames: [ "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre" ]
			});
		}); 	
	},
	
	initTimePicker : function(){
		$(document).ready(function() { 
			$(".timePicker").timePicker();
		});
	},
  
	checkCIPhoneNumber : function(ciPhone){
		var phoneNumberRegEx = /^\d{2}[- .]?\d{2}[- .]?\d{2}[- .]?\d{2}$/;
		return phoneNumberRegEx.test(ciPhone);
	},
	
	checkEmail : function(email){
		var emailRegEx =  /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		return emailRegEx.test(email);
	}

});

var cesam = new Cesam();