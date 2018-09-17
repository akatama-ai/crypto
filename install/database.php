<?php 
session_start();
error_reporting(E_ALL);
if(!isset($_SESSION['installStep']) || $_SESSION['installStep'] < 2) {
	header("location:./requirements.php");
	exit();
}

function SplitSQL($file,$mysqli,$delimiter = ';') {
	$templine = "";
	$lines = file($file);
	foreach ($lines as $line) {
		if (substr($line, 0, 2) == '--' || $line == '') {
			continue;
		}
		$templine .= $line;
		if(substr(trim($line), -1, 1) == ';')	{		
			$mysqli->query($templine) or die($mysqli->error);
			$templine = '';
		}
	}
}

function paste_file($source,$server,$username,$password,$database,$destination) {
	$sampleFile = file_get_contents($source);
	$sampleFile = str_replace("{{server}}",$server,$sampleFile);
	$sampleFile = str_replace("{{username}}",$username,$sampleFile);
	$sampleFile = str_replace("{{password}}",$password,$sampleFile);
	$sampleFile = str_replace("{{database}}",$database,$sampleFile);
	file_put_contents($destination,$sampleFile);
}

if(isset($_POST['submit'])) {
	$error = false;
	
	$server = $_POST['server'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$database = $_POST['database'];
	
	$mysqli = @new mysqli($server, $username, $password, $database);
	
	if($mysqli->connect_error) {
		$error = true;
	}
	else {
		paste_file("samples/connect.sample",$server,$username,$password,$database,"db/connect.php");
		paste_file("samples/database.sample",$server,$username,$password,$database,"../application/config/database.php");
		SplitSQL('db/db.sql',$mysqli);
		$_SESSION['installStep'] = 3;
		header("location:./website.php");
		exit();
	}
}

include("includes/head.php");
?>
<title>Database Details - Cryptolio Script Installer</title>
<?php include("includes/header.php"); ?>
<?php include("includes/sidebar.php"); ?>
<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
	<div class="bhoechie-tab-content active">
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<?php
			if(isset($_POST['submit']) && $error == true) {
				?>
				<div class="alert alert-danger alert-dismissable">
					<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Error!</strong> Unable to connect to database.
				</div>
				<?php
			}
			?>
			<div class="form-group">
				<label class="control-label">Database Server</label>
				<input name="server" placeholder="e.g: localhost" class="form-control inputTxt" required type="text" />
			</div>
			<div class="form-group">
				<label class="control-label">Database Name</label>
				<input name="database" placeholder="Database Name..." class="form-control inputTxt" required type="text" />
			</div>
			<div class="form-group">
				<label class="control-label">Database User</label>
				<input name="username" placeholder="Database User..." class="form-control inputTxt" required type="text" />
			</div>
			<div class="form-group">
				<label class="control-label">Database Password</label>
				<input name="password" placeholder="Database Password..." class="form-control inputTxt" required type="password" />
			</div>
			<button type="submit" name="submit" class="btn btn-primary btn-lg">Submit</a>
		</form>
	</div>
</div>
<?php include("includes/footer.php"); ?>