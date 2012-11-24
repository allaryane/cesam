<?php
/* * ****************** Entête UTF-8 ******************\
 *
 * 	fichier			: views/themes/default/template.php
 * 	projet			: 
 * 	version			: 
 *
  \*************************************************** */
?><!DOCTYPE HTML>
<html itemscope itemtype="http://schema.org/LocalBusiness">
	<head>
		<title><?php echo $title; ?></title>
		<meta itemprop="name" content="Cesam">
		<meta itemprop="description" content="Cesam est un intranet permettant un echange de donnees entre medecin.">
		<meta itemprop="image" content="http://healthynbalanced.files.wordpress.com/2011/12/pick-me-up1.jpg">

		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<meta name="site_url" content="<?php echo base_url(); ?>" />
		<link type="image/x-icon" rel="shortcut icon"  href="<?php echo base_url(); ?>favicon.ico" />
		<link type="text/css" rel="stylesheet" media="screen" href="<?php echo base_url(); ?>public/css/mainLogout.css" />
		<link type="text/css" rel="stylesheet" media="screen" href="<?php echo base_url(); ?>public/css/footer.css" />
		<link type="text/css" rel="stylesheet" media="screen" href="<?php echo base_url(); ?>public/css/modals.css" />
				
		<link type="text/css" rel="stylesheet" media="screen" href="<?php echo base_url(); ?>public/lib/bootstrap/css/bootstrap-responsive.css" />
		<link type="text/css" rel="stylesheet" media="screen" href="<?php echo base_url(); ?>public/lib/bootstrap/css/bootstrap.css" />

		
		<?php echo $_styles . "\n"; ?>
		
		<script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery/jquery-1.7.min.js" ></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery/jquery.inherit-1.3.2.M.js" ></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery/jquery.validate.js" ></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>public/lib/bootstrap/js/bootstrap.min.js" ></script>

		
		<script type="text/javascript" src="<?php echo base_url();?>public/js/cesam.js" ></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>public/js/mainLogout.js" ></script>
		
		<?php echo $_scripts . "\n"; ?>
	</head>
	
	<body>

		<?php
		echo $header;
		?>
		
			
		<div id="contentPart" class="container-fluid">
			<div  class="row-fluid">
			
				<!--Body content-->	  
				<?php
				echo $content;
				?>
				
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
