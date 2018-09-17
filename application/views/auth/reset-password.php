<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<title><?php echo "Reset Password - ".$settings['title']; ?></title>
		<meta name="description" content="<?php echo $settings['description']; ?>">
		<meta name="keywords" content="<?php echo $settings['keywords']; ?>">
		<link href="<?php echo base_url("assets/bootstrap/css/bootstrap.min.css"); ?>" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url("assets/font-awesome/css/font-awesome.min.css"); ?>" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url("assets/css/admin-css-lte/adminlte.min.css"); ?>" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
		<style>
		.login-page, .register-page {
			background: linear-gradient(90deg,#271673 0,#523bb8);
		}
		</style>
	</head>
	<body class="hold-transition login-page">
		<div class="login-box">
			<div class="login-logo">
				<a href="<?php echo base_url(); ?>">
					<img src="<?php echo base_url("assets/images/".$settings['lightLogo']); ?>" alt="Logo">
				</a>
			</div>
			<div class="login-box-body">
				<p class="login-box-msg">Reset your password by entering new credentials</p>

				<form role="form" method="post" action="<?php echo base_url(AUTH_CONTROLLER."/reset-password/".$resetCode); ?>">
					<div class="form-group has-feedback">
						<input type="password" class="form-control login-controler" id="newPassword" name="newPassword" placeholder="Enter New Password" value="<?php echo(isset($newPassword) && $error == true ? $newPassword : ""); ?>" autocomplete="off" autofocus required />
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<input type="password" class="form-control login-controler" id="confirmNewPassword" name="confirmNewPassword" placeholder="Confirm New Password..." value="<?php echo(isset($confirmNewPassword) && $error == true ? $confirmNewPassword : ""); ?>" autocomplete="off" required />
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					</div>
					<?php
					if(isset($captchaCheck) && $captchaCheck == true) {
						?>
						<div class="form-group">
							<div class="col-md-12">
								<div style="display: inline-block;">
									<div class="g-recaptcha" data-sitekey="<?php echo $captchaSettings['siteKey']; ?>"></div>
								</div>
							</div>
						</div>
						<?php
					}
					?>
					<div class="row">
						<div class="col-xs-4">
							<button type="submit" name="submit" class="btn btn-success btn-block btn-flat"><i class="fa fa-window-restore"></i> Reset</button>
						</div>
					</div>
				</form>
				<div style="margin-top:10px">
					<a href="<?php echo base_url(AUTH_CONTROLLER."/login"); ?>">Back to Login</a>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="<?php echo base_url("assets/jquery/jquery.min.js"); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url("assets/bootstrap/js/bootstrap.min.js"); ?>"></script>
		<?php
		if(isset($captchaCheck) && $captchaCheck == true) {
			?> <script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script> <?php
		}
		?>
	</body>
</html>