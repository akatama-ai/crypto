<?php 
session_start();
error_reporting(E_ALL);
if(!isset($_SESSION['installStep']) || $_SESSION['installStep'] < 3) {
	header("location:./database.php");
	exit();
}
include("db/connect.php");

function validEmail($email) {
	return preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $email) ? true : false;	
}

function isAlphaNum($val) {
	return (bool) preg_match("/^([a-zA-Z0-9])+$/i", $val);
}

function getDomain($url) {
	if(preg_match("#https?://#", $url) === 0) {
		$url = 'http://' . $url;
	}
	return strtolower(str_ireplace('www.', '', parse_url($url, PHP_URL_HOST)));
}

if(isset($_POST['submit'])) {
	$error = false;
	$basePath = $_POST['basePath'];
	$www = (isset($_POST['www']) && $_POST['www'] == "on" ? 1 : 0);
	$https = (isset($_POST['https']) && $_POST['https'] == "on" ? 1 : 0);
	if(empty($basePath)) {
		$error = true;
		$basePathError = "Should not be empty";
	}
	else {
		$basePathValue = ($https == 1 ? 'https://' : 'http://').($www == 1 ? 'www.' : '').getDomain($basePath);
		$directoryName = preg_replace('{/$}', '', dirname($_SERVER['SCRIPT_NAME']))."/";
		$directoryName = str_replace("/install","",$directoryName);
		$basePathValue = $basePathValue.$directoryName;
	}
	$title = $_POST['title'];
	if(empty($title)) {
		$titleError = "Should not be empty";
		$error = true;
	}
	$email = $_POST['email'];
	if(!validEmail($email)) {
		$emailError = "Invalid Email address.";
		$error = true;
	}
	$username = $_POST['username'];
	if(!isAlphaNum($username)) {
		$usernameError = "Only a-z and 0-9 allowed.";
		$error = true;
	}
	$password = $_POST['password'];
	$confirmPassword = $_POST['confirmPassword'];
	if(empty($password)) {
		$error = true;
		$passwordError = "Should not be empty";
	}
	else if(empty($confirmPassword)) {
		$error = true;
		$confirmPasswordError = "Should not be empty";
	}
	else if($password != $confirmPassword) {
		$error = true;
		$passwordError = "Passwords does not match";
	}
	$encryptionKey = $_POST['encryptionKey'];
	if(empty($encryptionKey)) {
		$encryptionKeyError = "Should not be empty";
		$error = true;
	}
	
	if(!$error) {
		$sampleFile = file_get_contents("samples/config.sample");
		$sampleFile = str_replace("{{base_url}}",$basePathValue,$sampleFile);
		$sampleFile = str_replace("{{encryption_key}}",md5($encryptionKey),$sampleFile);
		file_put_contents("../application/config/config.php",$sampleFile);
		$uPassword = md5($password);
		$mysqli->query("INSERT INTO `users` (`username`,`email`,`password`,`role`) VALUES ('$username','$email','$uPassword','admin')");
		$mysqli->query("UPDATE `mail-settings` SET `contactEmail`='$email'");
		$mysqli->query("UPDATE `general-settings` SET `title`='$title',`www`='$www',`https`='$https'");
		$_SESSION['installStep'] = 4;
		header("location:./finish.php");
		exit();
	}
}
include("includes/head.php");
?>
<title>Website Details - Cryptolio Script Installer</title>
<?php include("includes/header.php"); ?>
<?php include("includes/sidebar.php"); ?>
<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
	<div class="bhoechie-tab-content active">
		<form class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<?php
			if(isset($_POST['submit']) && $error == true) {
				?>
				<div class="alert alert-danger alert-dismissable">
					<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Error!</strong> Some error occured settings could not be update.
				</div>
				<?php
			}
			?>
			<div class="form-group">
				<label class="col-sm-3 control-label">Base Path</label>
				<div class="col-sm-9">
					<input readonly type="text" name="basePath" placeholder="BasePath" value="<?php echo (isset($basePath) ? $basePath : getDomain($_SERVER['SERVER_NAME']) . str_replace("/install","",dirname($_SERVER['SCRIPT_NAME']))); ?>" class="form-control" />
					<?php
					if(isset($basePathError)) {
						?>
						<span class="text-danger"><?php echo $basePathError; ?></span>
						<?php
					}
					?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Website Title</label>
				<div class="col-sm-9">
					<input type="text" name="title" placeholder="Website Title..." value="<?php echo (isset($title) ? $title : ""); ?>" class="form-control" />
					<?php
					if(isset($titleError)) {
						?>
						<span class="text-danger"><?php echo $titleError; ?></span>
						<?php
					}
					?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Admin Email</label>
				<div class="col-sm-9">
					<input type="text" name="email" placeholder="Admin Email..." class="form-control" value="<?php echo (isset($email) ? $email : ""); ?>" />
					<?php
					if(isset($emailError)) {
						?>
						<span class="text-danger"><?php echo $emailError; ?></span>
						<?php
					}
					?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Admin Username</label>
				<div class="col-sm-9">
					<input type="text" name="username" placeholder="Admin Username..." class="form-control" value="<?php echo (isset($username) ? $username : ""); ?>" />
					<?php
					if(isset($usernameError)) {
						?>
						<span class="text-danger"><?php echo $usernameError; ?></span>
						<?php
					}
					?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Admin Password</label>
				<div class="col-sm-9">
					<input type="password" name="password" placeholder="Admin Password..." class="form-control" value="<?php echo (isset($password) ? $password : ""); ?>" />
					<?php
					if(isset($passwordError)) {
						?>
						<span class="text-danger"><?php echo $passwordError; ?></span>
						<?php
					}
					?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Confirm Admin Password</label>
				<div class="col-sm-9">
					<input type="password" name="confirmPassword" placeholder="Confirm Admin Password" class="form-control" value="<?php echo (isset($confirmPassword) ? $confirmPassword : ""); ?>" />
					<?php
					if(isset($confirmPasswordError)) {
						?>
						<span class="text-danger"><?php echo $confirmPasswordError; ?></span>
						<?php
					}
					?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Encryption Key</label>
				<div class="col-sm-9">
					<input type="password" name="encryptionKey" placeholder="Encryption Key" class="form-control" value="<?php echo (isset($encryptionKey) ? $encryptionKey : ""); ?>" />
					<small>Could be any key for the encryption in the script, does not need to remember.</small>
					<?php
					if(isset($encryptionKeyError)) {
						?>
						<span class="text-danger"><?php echo $encryptionKeyError; ?></span>
						<?php
					}
					?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Force <strong>www</strong></label>
				<div class="col-sm-9">
					<div class="checkbox">
						<label><input name="www" type="checkbox" <?php echo(isset($www) && $www == 1 ? "checked" : ""); ?>></label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Force <strong>https</strong></label>
				<div class="col-sm-9">
					<div class="checkbox">
						<label><input name="https" type="checkbox" <?php echo(isset($https) && $https == 1 ? "checked" : ""); ?>></label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-8">
					<button type="submit" name="submit" class="btn btn-primary btn-lg">Submit</button>
				</div>
			</div>
		</form>
	</div>
</div>
<?php include("includes/footer.php"); ?>