<?php

/* * ********************Encoding : UTF-8 ******************************\

 * 	Fichier			: cesamForm_helper.php
 * 	Projet			: cesam
 * 	Version			: 31 oct. 2012 22:52:29
 * 	Auteur			: Ryane Alla // allaryane@gmail.com
 *  \************************************************************************* */

class Cesam_form_helper {

	public static $monthsNamesMin = array("Jan", "Fév", "Mar", "Avr", "Mai", "Jui", "Juil", "Aoû", "Sep", "Oct", "Nov", "Déc");
	
	public static function renderInputDate($inputName, $defaultDate, $args = array())
	{
		echo '
		<script type="text/javascript">$(document).ready(function() {cesam.renderInputDate("'.$inputName.'","'.$defaultDate.'");});</script>
		<input type="text" class="datePicker" id="'.$inputName.'TempDate" placeholder="Ordonnance" readonly>
		<input type="text" id="'.$inputName.'" name="'.$inputName.'" style="display: none;" >
		';
	}

	public static function renderInputDateHour($inputName, $defaultDatetime, $args = array('sizeDate'=> 120,'sizeHour'=> 60)){
		echo '
		<script type="text/javascript">$(document).ready(function() {cesam.renderInputDateHour("'.$inputName.'","'.$defaultDatetime.'");});</script>
		<input style="width: '.$args['sizeDate'].'px!important;" type="text" class="datePicker" id="'.$inputName.'Date" placeholder="Date" readonly/>
		<input style="width: '.$args['sizeHour'].'px!important;" type="text" class="timePicker" id="'.$inputName.'Heure" placeholder="Heure" readonly/>
		<input type="text" id="'.$inputName.'" name="'.$inputName.'" style="display: none;" >
		';
	}

	public static function renderInputBirthay($inputName, $defaultOption, $args = array('sizeJJ'=> 70, 'sizeMM'=> 85, 'sizeAA'=> 90)) {
		$defaultDay = '';
		$defaultMonth = '';
		$defaultYear = '';
		if(!empty($defaultOption)){
			$tab = preg_split('/-/', $defaultOption);
			$defaultDay = $tab[2];
			$defaultMonth = $tab[1];
			$defaultYear = $tab[0];
		}
		
		
		$days = range(1, 31);
		$daysOptions = '';
		$months = range(1, 12);
		$monthsOptions = '';
		$years = range(1920, date('Y'));
		$yearsOptions = '';
		
		foreach($days as $day) {
			if($day < 10) $d = '0'.$day;
			else $d = $day;
			$selected = '';
			if($d == $defaultDay) $selected = 'selected="selected"';
			$daysOptions .= '<option '.$selected.' value="'.$d.'">'.$d.'</option>';
		}
		foreach($months as $month) {
			if($month < 10) $m = '0'.$month;
			else $m = $month;
			$selected = '';
			if($m == $defaultMonth) $selected = 'selected="selected"';
			$monthsOptions .= '<option '.$selected.' value="'.$m.'">'.Cesam_form_helper::$monthsNamesMin[$month - 1].'('.$m.')</option>';
		}
		foreach($years as $year) {
			$selected = '';
			if($year == $defaultYear) $selected = 'selected="selected"';
			$yearsOptions .= '<option '.$selected.' value="'.$year.'">'.$year.'</option>';
		}
		
		
		
		echo '
			<script type="text/javascript">$(document).ready(function() {cesam.renderInputBirthDay("'.$inputName.'","'.$defaultOption.'");});</script>
			
			<select style="width: '.$args['sizeJJ'].'px!important;" id="'.$inputName.'bDay">
				<option value="">Jour</option>
				'.$daysOptions.'
			</select>
			
			<select style="width: '.$args['sizeMM'].'px!important;" id="'.$inputName.'bMonth">
				<option value="">Mois</option>
				'.$monthsOptions.'
			</select>
				
			<select style="width: '.$args['sizeAA'].'px!important;" id="'.$inputName.'bYear">
				<option value="">Année</option>
				'.$yearsOptions.'
			</select>
			
			<input type="text" id="'.$inputName.'" name="'.$inputName.'" style="display: none;" >
		'; 
	}
	
	
	
	public static function makeSelectField($inputName,$firstOptionLabel, $defaultOption, $args = array()){
		echo '<select name="'.$inputName.'" id="'.$inputName.'">';
		if(!empty($firstOptionLabel)) echo '<option value="">'.$firstOptionLabel.'</option>';
		if(!empty($args))
		{
			foreach ($args as $value => $label) {
				$selected = '';
				if($defaultOption == $value) $selected = 'selected="selected"';
				echo '<option '.$selected.'  value="'.$value.'">'.$label.'</option>';
			}
		}		
		echo '</select>';
	}
}