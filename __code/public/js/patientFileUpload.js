/****************************************************\
 *
 *
 *	fichier			: public/js/patientFileUpload.js
 *	projet			:
 *	version			: 1.0.0 2012/11/10 11:00 JRA
 *
\****************************************************/
var FILE_UPLOAD_DIR = 'upload/';
var controllerName = 'patients';
var stateOK = '<i style="margin-right: 2px; margin-top: 2px; float: right;" class="icon-ok"></i>';
var stateWarning = '<i style="margin-right: 2px; margin-top: 2px; float: right;" class="icon-warning-sign"></i>';
var stateLoading = '<img width="14" height="14" style="margin-right: 2px; margin-top: 2px; float: right;"  src="'+cesam.url + 'public/images/loading.gif" />';


function _cmpct(filename){
	var newFilename = filename.replace(/\s/gi, '_');
	newFilename = newFilename.replace(/\./gi, '_');
	return newFilename;
}

function truncateFileName(filename, limitTotal,limitLine){
	var tab = filename.split(" ");
	if(tab.length == 1){
		if(filename.length > limitLine){
			var part_ = Math.round(limitLine / 3);
			var last_ = filename.length - (2 * part_) - 1;
			return filename.substring(0, part_) + "..." + filename.substring(last_, filename.length);
		}
	}
	else if(filename.length >= limitTotal){
		var part = Math.round(limitTotal / 3);
		var last = filename.length - (2 * part) - 1;
		return filename.substring(0, part) + "..." + filename.substring(last, filename.length);
	}

	return filename;
}

function changeCSSMouseOver(idDiv){
	$('#'+idDiv).css('background-color','#F2F2F2');
	$('#'+idDiv).css('border-color','#3BB9FF');
}

function changeCSSMouseOut(idDiv){
	$('#'+idDiv).css('background-color','white');
	$('#'+idDiv).css('border-color','graytext');
}

function getFileCounter(){
	return parseInt($('#countFiles').val());
}

function setFileCounter(count){
	$('#countFiles').val(count);
}

function incrementFileCounter(){
	var counter = parseInt($('#countFiles').val());
	counter = counter + 1;
	$('#countFiles').val(counter);
}

function decrementFileCounter(){
	var counter = parseInt($('#countFiles').val());
	counter = counter - 1;
	$('#countFiles').val(counter);
}


function deleteFileUploaded(filename){
	if (confirm('Etes vous sur de vouloir effacer ce fichier ?')) {
		// Ajout de l'icon de loading
		$('#fileStateIcon'+filename).html(stateLoading);
		
		if ($("#file_"+filename).length > 0){
			//On recupere l'id du fichier dans la base de donnees
			var filenameId = $("#file_"+filename).val();
			var tab = filenameId.split(';');
			var idFile = tab[1];
			// Requete asynchrone permettant de supprimer le fichier 
			// du repertoire upload et aussi de la db
			dataPost = 'idFile='+idFile;
			$.ajax({
                            cache: false,
                            type: "POST",
                            url: cesam.url + controllerName+'/deleteFileAjax',
                            data: dataPost,
                            success: function(data){ 
					if(data == '1') {
						$('#divImgFile'+filename).remove();
						$("#file_"+filename).remove();
						alert('Fichier Effacé avec succes.');
						decrementFileCounter();
					}
					else alert('Erreur lors de la suppression du fichier ! Veuillez reéssayer.');
			    },
			    complete: function() {},
			    error: function(xhr, textStatus, errorThrown) {
					alert('Erreur lors de la suppression du fichier ! Veuillez reéssayer.');
			   }
			});

		}
		else{
			$('#divImgFile'+filename).remove();
			alert('Fichier Effacé avec succes.');
			decrementFileCounter();
		}
				
		
	}
}
	
function manageResponseFileUpload(responseText, statusText, xhr, $form){
	//alert(responseText);
	var tab = responseText.split(';');
	var filename = tab[0];
	var idFile = tab[1];
	var code = tab[2];
	var filename_ = _cmpct(filename);
	
	if(code > 0){
		$('.icon-trash').show();
		$('#fileStateIcon' + filename_).html(stateOK);
		var valueInput = filename + ';' + idFile;
		$('#filesIdDiv').append('<input name="filesUpload[]" id="file_'+filename_+'" value="'+valueInput+'">');
		incrementFileCounter();
	}
	else if(code == 0){
		alert('Une erreur est survenue lors de l\'ajout du fichier. Veuillez reessayez!');
	}
	else if(code == -1){
		$('.icon-trash').show();
		$('#fileStateIcon' + filename_).html(stateWarning);
		alert('Ce nom de fichier existe deja dans la base de données.Renomer le et reessayez ! Dans le cas contraire le fichier ne sera pas ajouté au patient.');
	}
}

function displayFile(filename, idFile){
        //alert(filename + ' - ' + idFile);
	var ext = filename.substr( (filename.lastIndexOf('.') +1) );
	var src = '';
	if(ext == 'png' || ext == 'jpg' || ext == 'jpeg' || ext == 'gif' ||
		ext == 'PNG' || ext == 'JPG' || ext == 'JPEG' || ext == 'GIF') {
		src = cesam.url + FILE_UPLOAD_DIR + filename;
	}
	else if(ext == 'pdf' || ext == 'PDF') src = cesam.url + 'public/images/pdf.png';
	else if(ext == 'doc' || ext == 'DOC') src = cesam.url + 'public/images/doc.png';
	else if(ext == 'docx' || ext == 'DOCX') src = cesam.url + 'public/images/docx.png';
	else if(ext == 'xls' || ext == 'XLS') src = cesam.url + 'public/images/xls.png';	
	else src = cesam.url + 'public/images/inconnu.png';

	constructContent(filename, src);
        var filename_ = _cmpct(filename);
	$('.icon-trash').show();
	$('#fileStateIcon' + filename_).html(stateOK);
	var valueInput = filename + ';' + idFile + ';ALREADY_IN_DB';
	$('#filesIdDiv').append('<input name="filesUpload[]" id="file_'+filename_+'" value="'+valueInput+'">');
	incrementFileCounter();
}

	
	
	
function constructContent(filename, src){
	var filename_ = _cmpct(filename);
	var fileLink = cesam.url + FILE_UPLOAD_DIR + filename;
	var content = '<div id="divImgFile'+filename_+'" onmouseout="changeCSSMouseOut(\'divImgFile'+filename_+'\');" onmouseover="changeCSSMouseOver(\'divImgFile'+filename_+'\');" class="span1 divImgFile">'+
					'<i onclick="deleteFileUploaded(\''+filename_+'\');" style="display:none ;margin-left: 2px; margin-top: 2px; float: left;" class="icon-trash"></i>'+							  
					'<div id="fileStateIcon'+filename_+'">' + stateLoading + '</div>'+
					
					'<div style="clear: both"></div>'+
					'<center>'+
					'<img class="imgFileClass" id="imgFile'+filename_+'"  src="'+src+'"/>'+
					'<div class="textDivFileClass"><a target="blank" href="'+fileLink+'">'+ truncateFileName(filename, 35, 20) +'</a></div>'+
					'</center>'+
					'</div>';

	$("#contentFiles").append(content);
}	
	
	
function afterClosingFileBrowser(input){
		
		if(getFileCounter() >= 5){
			alert('Desole 5 fichiers maximum par patient. Vous pouvez en supprimer afin de pouvoir en ajouter !');
			return;
		} 
		
		var path = $(input).attr('value');
		var ext = path.substr( (path.lastIndexOf('.') +1) );
		var filename = path.substr((path.lastIndexOf('\\') +1));

		if (input.files && input.files[0]) {
				
				var reader = new FileReader();

				reader.onload = function (e) {
					var src = '';

					if(ext == 'png' || ext == 'jpg' || ext == 'jpeg' || ext == 'gif' ||
						ext == 'PNG' || ext == 'JPG' || ext == 'JPEG' || ext == 'GIF') src = e.target.result;

					else if(ext == 'pdf' || ext == 'PDF') src = cesam.url + 'public/images/pdf.png';
					else if(ext == 'doc' || ext == 'DOC') src = cesam.url + 'public/images/doc.png';
					else if(ext == 'docx' || ext == 'DOCX') src = cesam.url + 'public/images/docx.png';
					else if(ext == 'xls' || ext == 'XLS') src = cesam.url + 'public/images/xls.png';	
					else src = cesam.url + 'public/images/inconnu.png';

					constructContent(filename, src);
					
					var options = { 
						success : manageResponseFileUpload, 
						url : cesam.url + controllerName + '/uploadFileAjax',          
						type : 'post'
						
					};
					
					$('#cesamForm').ajaxSubmit(options); 
					
				};
				reader.readAsDataURL(input.files[0]);
			}
	}