<?php 
session_start();
error_reporting(E_ALL);
if(!isset($_SESSION['installStep'])) {
	$_SESSION['installStep'] = 1;
}
include("includes/head.php");
?>
<title>Welcome - Cryptolio Script Installer</title>
<?php
include("includes/header.php");
include("includes/sidebar.php");
?>
<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
	<div class="bhoechie-tab-content active">
		<h1 class="welcome_title_main">
			Welcome To <strong>"Cryptolio Script"</strong> Installer
		</h1>
		<h4>Thanks for Purchasing Codiva's Product</h4>
		<p>Welcome to Installation Wizard</p>
		<p>
			If you face any problem while installation then drop us email at : 
			<strong>
				<a href="mailto:codeiva.support@gmail.com">help.codeiva@gmail.com</a>
			</strong>
		</p>
		<p>To start the intallation click on the button below</p>
		<div class="clearfix"></div>
		<br />
		<a href="./requirements.php" class="btn btn-primary btn-lg">Begin Installation!</a>
	</div>
</div>
<?php include("includes/footer.php"); ?>