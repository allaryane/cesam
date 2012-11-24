<?php
/* * ****************** Entête UTF-8 ******************\
 *
 * 	fichier			: views/themes/default/template.php
 * 	projet			: 
 * 	version			: 1.0.4 2011/11/10 22:53 MB
 *
  \*************************************************** */
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo $title; ?></title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<meta name="site_url" content="<?php echo base_url(); ?>" />
		<link type="image/x-icon" rel="shortcut icon"  href="<?php echo base_url(); ?>favicon.ico" />
		<link type="text/css" rel="stylesheet" media="screen" href="<?php echo base_url(); ?>public/css/main.css" />
		<link type="text/css" rel="stylesheet" media="screen" href="<?php echo base_url(); ?>public/css/footer.css" />
		<link type="text/css" rel="stylesheet" media="screen" href="<?php echo base_url(); ?>public/css/modals.css" />
		<link type="text/css" rel="stylesheet" media="screen" href="<?php echo base_url(); ?>public/lib/bootstrap/css/bootstrap-responsive.min.css" />
		<link type="text/css" rel="stylesheet" media="screen" href="<?php echo base_url(); ?>public/lib/bootstrap/css/bootstrap.min.css" />
		<link type="text/css" rel="stylesheet" media="screen" href="<?php echo base_url(); ?>public/lib/timepicker/timePicker.css" />
		
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css">
		
		<?php echo $_styles . "\n"; ?>
		
		<script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery/jquery-1.8.2.min.js" ></script>	
		<script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery/jquery-ui.js" ></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery/jquery.inherit-1.3.2.M.js" ></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery/jquery.validate.js" ></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>public/lib/bootstrap/js/bootstrap.min.js" ></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>public/lib/timepicker/jquery.timePicker.js" ></script>
		<script type="text/javascript" src="<?php echo base_url();?>public/js/cesam.js" ></script>

				
		<?php echo $_scripts . "\n"; ?>
	</head>
	<body class="pmuBody">

		<?php
		echo $header;
		?>
		
		
		<div class="container-fluid">
		<div  class="row-fluid mainBox">

			<div class="span3">
				<!--Left Sidebar content-->
				<?php
				echo Bktemplate_helper::render_partial('_content/zones/_left_box', $leftBoxData);
				?>
			</div>

			<div class="span9">
				<!--Body content-->	  
				<div id="content" class="contentBox">		
					<?php
					echo $content;
					?>
				</div>

			</div>


			</div>
		</div>
	
		<?php
		echo $footer;
		?>
		
		<?php
		// Pour les modals
		echo Bktemplate_helper::render_partial('_content/partials/modals', array());
		?>
	</body>
</html>
