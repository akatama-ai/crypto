<?php
session_start();
error_reporting(E_ALL); 
include("includes/head.php");
?>
<title>Server Requirements - Cryptolio Script Installer</title>
<?php
include("includes/header.php");
include("includes/sidebar.php");

function success($text) {
	?>
	<div class="alert alert-success" role="alert">
		<i class="fa fa-smile-o fa-lg req_icon"></i><?php echo $text; ?>
	</div>
	<?php
}

function error($text) {
	?>
	<div class="alert alert-danger" role="alert">
		<i class="fa fa-frown-o fa-lg req_icon"></i><?php echo $text; ?>
	</div>
	<?php
}

function isEnabled($func) {
	return is_callable($func) && false === stripos(ini_get('disable_functions'), $func);
}

function getMySQLVersion() { 
	$output = shell_exec('mysql -V'); 
	preg_match('@[0-9]+\.[0-9]+\.[0-9]+@', $output, $version); 
	return $version[0]; 
}
$error = false;
?>
<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
	<div class="bhoechie-tab-content active">
	
		<?php $operatingSystem = PHP_OS; ?>
		<label class="control-label">Operating System</label>
		<?php
		if($operatingSystem == "Linux") {
			success($operatingSystem);
		}
		else {
			error("Not Linux");
			$error = true;
		}

		$webServer = $_SERVER["SERVER_SOFTWARE"]; ?>
		<label class="control-label">Web Server</label>
		<?php
		if(($webServer == "Apache") || (strpos($webServer, "Apache") !== false)) {
			success($webServer);
		}
		else {
			success($webServer ." : Apache is recomended");
		}
		
		$phpVersion = phpversion(); ?>
		<label class="control-label">PHP Version</label>
		<?php
		if($phpVersion >= 5.6) {
			success($phpVersion);
		}
		else {
			error($phpVersion." : Less Than 5.6");
			$error = true;
		}
		?>
		
		<label class="control-label">PHP CURL</label>
		<?php
		if(function_exists('curl_version')) {
			success("Installed");
		}
		else {
			error("Not Installed");
			$error = true;
		}
		?>
		
		<label class="control-label">PHP GMP</label>
		<?php
		if(extension_loaded("gmp")) {
			success("Installed");
		}
		else {
			error("Not Installed");
			$error = true;
		}
		?>
		
		<label class="control-label">MYSQL Version</label>
		<?php
		if($operatingSystem == "Linux" && isEnabled('shell_exec')) {
			$mysqlVersion = getMySQLVersion();
			if($mysqlVersion > 5.1) {
				success($mysqlVersion);
			}
			else {
				error($mysqlVersion . " : Should be 5.1+");
				$error = true;
			}
		}
		?>
		
		<label class="control-label">Config File</label>
		<?php
		$fileName = "../application/config/config.php";
		if(is_writable($fileName)) {
			success("Writable");
		}
		else {
			error('Not Writable "application/config/config.php"');
			$error = true;
		}
		?>
		
		<label class="control-label">Database File</label>
		<?php
		$fileName = "../application/config/database.php";
		if(is_writable($fileName)) {
			success("Writable");
		}
		else {
			error('Not Writable "application/config/database.php"');
			$error = true;
		}
		
		if($error == true) {
			?>
			<div class="row">
				<div class="col-xs-12">
					<div class="alert alert-danger">
						Server Does not meet all the requirements.
					</div>
				</div>
			</div>
			<div class="form-group">
				<a href="./requirements.php" class="btn btn-info btn-md">Refresh</a>
			</div>
			<?php
		}
		else {
			$_SESSION['installStep'] = 2;
			?>
			<a href="./database.php" class="btn btn-primary btn-md">Next</a>
			<?php
		}
		?>
	</div>
</div>
<?php include("includes/footer.php"); ?>