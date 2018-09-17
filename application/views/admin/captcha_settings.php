<?php $this->load->view("admin/includes/lte/head"); ?>
<link href="<?php echo base_url("assets/bootstrap-toggle/css/bootstrap-toggle.min.css"); ?>" rel="stylesheet" type="text/css">
<title>Captcha Settings - <?php echo $settings['title']; ?></title>
<?php $this->load->view("admin/includes/lte/header"); ?>
<?php $this->load->view("admin/includes/lte/sidebar"); ?> 
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Captcha Settings
			<small>Manage Captcha Settings</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_CONTROLLER."/dashboard"); ?>">Dashboard</a></li>
			<li class="active">Captcha Settings</li>
		</ol>
	</section>
	<section class="content">
		<?php
		if(isset($_POST['submit'])) {
			if($error == false) {
				?>
				<div class="alert alert-success">
					<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<i class="fa fa-check-square-o"></i> Captcha settings updated successfully.
				</div>
				<?php
			}
			else {
				?>
				<div class="alert alert-danger">
					<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<i class="fa fa-warning"></i> Some error occured cannot update captcha settings.
				</div>
				<?php
			}
		}
		?>
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-user-secret"></i> Captcha Settings</h3>
			</div>
			<div class="box-body">
				<form method="post" action="<?php echo base_url(ADMIN_CONTROLLER."/captcha-settings"); ?>">
					<div class="row">
						<div class="form-group col-md-6">
							<label>Site Key</label>
							<input type="text" name="siteKey" class="form-control" placeholder="Enter Site Key..." value="<?php echo (isset($siteKey) ? $siteKey : ""); ?>" />
							<?php
							if(isset($siteKeyError)) {
								?>
								<div class="m-t-5 text-danger"><small><?php echo $siteKeyError; ?></small></div>
								<?php
							}
							?>
						</div>
						<div class="form-group col-md-6">
							<label>Secret Key</label>
							<input type="text" name="secretKey" class="form-control" placeholder="Enter Secret Key..." value="<?php echo (isset($secretKey) ? $secretKey : ""); ?>" />
							<?php
							if(isset($secretKeyError)) {
								?>
								<div class="m-t-5 text-danger"><small><?php echo $secretKeyError; ?></small></div>
								<?php
							}
							?>
						</div>
					</div>
					
					<div class="row">
						<div class="form-group col-md-6 text-right">
						
							<label class="pull-left">Captcha On Login Page</label>
							<input type="checkbox" name="loginCaptcha" data-toggle="toggle" data-size="small" data-onstyle="success" <?php echo(isset($loginCaptcha) && $loginCaptcha == 1 ? "checked" : ""); ?> />
							
						</div>
						
						<div class="form-group col-md-6 text-right">
							<label class="pull-left">Captcha On Password Reset Page</label>
							<input type="checkbox" name="forgotPasswordCaptcha" data-toggle="toggle" data-size="small" data-onstyle="success" <?php echo(isset($forgotPasswordCaptcha) && $forgotPasswordCaptcha == 1 ? "checked" : ""); ?> />
						</div>
					</div>
					
					<div class="row">
						<div class="form-group col-md-6 text-right">
							<label class="pull-left">Captcha On Contact Page</label>
							<input type="checkbox" name="contactCaptcha" data-toggle="toggle" data-size="small" data-onstyle="success" <?php echo(isset($contactCaptcha) && $contactCaptcha == 1 ? "checked" : ""); ?> />
						</div>
						<div class="form-group col-md-6 text-right">
							<label class="pull-left">Captcha On Reset Password Page</label>
							<input type="checkbox" name="resetPasswordCaptcha" data-toggle="toggle" data-size="small" data-onstyle="success" <?php echo(isset($resetPasswordCaptcha) && $resetPasswordCaptcha == 1 ? "checked" : ""); ?> />
						</div>
					</div>
					
					<div class="form-group">
						<label>Show CaptchaAfter Failed Login Attempts (<small>Only For Login Page</small>)</label>
						<input type="number" name="captchaShowFailedAttempts" class="form-control" placeholder="Enter Attempts..." value="<?php echo (isset($captchaShowFailedAttempts) ? $captchaShowFailedAttempts : ""); ?>" />
						<?php
						if(isset($captchaShowFailedAttemptsError)) {
							?>
							<div class="m-t-5 text-danger"><small><?php echo $captchaShowFailedAttemptsError; ?></small></div>
							<?php
						}
						?>
					</div>
					<div class="form-group m-b-0">
						<button type="submit" name="submit" class="btn btn-md btn-success">
							<i class="fa fa-check-square-o"></i> Update
						</button>
					</div>
				</form>
			</div>
		</div>
	</section>
</div>
<?php $this->load->view("admin/includes/lte/footer-tag"); ?>
<?php $this->load->view("admin/includes/lte/footer-script-files"); ?>
<script type="text/javascript" src="<?php echo base_url("assets/bootstrap-toggle/js/bootstrap-toggle.min.js"); ?>"></script>
<?php $this->load->view("admin/includes/lte/footer-end"); ?>