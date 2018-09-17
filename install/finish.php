<?php
session_start();
error_reporting(E_ALL);
if(!isset($_SESSION['installStep']) || $_SESSION['installStep'] < 4) {
	header("location:./website.php");
	exit();
}
include("db/connect.php");
$mysqli->query("UPDATE `general-settings` SET `installed`='1'");
unset($_SESSION['install_step']);

$dir = '../application/cache';
$leave_files = array('.htaccess', 'index.html');
foreach(glob("$dir/*") as $file) {
    if(!in_array(basename($file), $leave_files)) {
		unlink($file);
	}
}

$baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on"? 'https://' : 'http://').$_SERVER['SERVER_NAME'] . str_replace("/install","",dirname($_SERVER['SCRIPT_NAME']));
include("includes/head.php");
?>
<title>Finsh Installation - Cryptolio Script Installer</title>
<?php include("includes/header.php"); ?>
<?php include("includes/sidebar.php"); ?>
<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
	<div class="bhoechie-tab-content active">
		<div class="tab-content shadow-1">
			<div role="tabpanel" class="tab-pane finish text-center active">
				<div class="alert alert-success">
					<i class="fa fa-exclamation-circle fa-lg"></i> Script has been installed successfully.
				</div>
				<p>Note : Don't forget to delete the <strong>install</strong> directory.</p>
				<div class="form-group">
					<a href="<?php echo $baseUrl; ?>" class="btn btn-primary btn-lg"><i class="fa fa-link"></i> &nbsp;Visit Website</a>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include("includes/footer.php"); ?>