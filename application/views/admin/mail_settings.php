<?php $this->load->view("admin/includes/lte/head"); ?>
<link href="<?php echo base_url("assets/bootstrap-toggle/css/bootstrap-toggle.min.css"); ?>" rel="stylesheet" type="text/css">
<title>Mail Settings - <?php echo $settings['title']; ?></title>
<?php $this->load->view("admin/includes/lte/header"); ?>
<?php $this->load->view("admin/includes/lte/sidebar"); ?> 
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Mail Settings
			<small>Manage mail and contact settings</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_CONTROLLER."/dashboard"); ?>">Dashboard</a></li>
			<li class="active">Mail Settings</li>
		</ol>
	</section>
	<section class="content">
		<?php
		if(isset($_POST['submit'])) {
			if($error == false) {
				?>
				<div class="alert alert-success">
					<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<i class="fa fa-check-square-o"></i> Mail settings updated successfully.
				</div>
				<?php
			}
			else {
				?>
				<div class="alert alert-danger">
					<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<i class="fa fa-warning"></i> Some error occured cannot update mail settings.
				</div>
				<?php
			}
		}
		?>
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-envelope-o"></i> Mail Settings</h3>
			</div>
			<div class="box-body">
				<form method="post" action="<?php echo base_url(ADMIN_CONTROLLER."/mail-settings"); ?>">
					<div class="form-group">
						<label>SMTP Status</label>
						<div>
							<input id="status-check" type="checkbox" name="smtpStatus" data-toggle="toggle" data-size="small" data-onstyle="success" <?php echo(isset($smtpStatus) && $smtpStatus == 1 ? "checked" : ""); ?> />
						</div>
					</div>
					<div id="settings-panel" class="<?php echo (isset($smtpStatus) && $smtpStatus != 1 ? "hide" : ""); ?>">
						<div class="row">
							<div class="form-group col-md-6">
								<label>Host</label>
								<input type="text" name="host" class="form-control" placeholder="Enter SMTP Host..." value="<?php echo (isset($host) ? $host : ""); ?>" />
								<?php
								if(isset($hostError)) {
									?>
									<div class="m-t-5 text-danger"><small><?php echo $hostError; ?></small></div>
									<?php
								}
								?>
							</div>
							<div class="form-group col-md-6">
								<label>Port</label>
								<input type="number" name="port" class="form-control" placeholder="Enter SMTP Port..." value="<?php echo (isset($port) ? $port : ""); ?>" />
								<?php
								if(isset($portError)) {
									?>
									<div class="m-t-5 text-danger"><small><?php echo $portError; ?></small></div>
									<?php
								}
								?>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-6">
								<label>Username</label>
								<input type="text" name="username" class="form-control" placeholder="Enter SMTP Username..." value="<?php echo (isset($username) ? $username : ""); ?>" />
								<?php
								if(isset($usernameError)) {
									?>
									<div class="m-t-5 text-danger"><small><?php echo $usernameError; ?></small></div>
									<?php
								}
								?>
							</div>
							<div class="form-group col-md-6">
								<label>Password</label>
								<input type="password" name="password" class="form-control" placeholder="Enter SMTP Password..." value="<?php echo (isset($password) ? $password : ""); ?>" />
								<?php
								if(isset($passwordError)) {
									?>
									<div class="m-t-5 text-danger"><small><?php echo $passwordError; ?></small></div>
									<?php
								}
								?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Contact Email</label>
						<input type="text" name="contactEmail" class="form-control" placeholder="Enter Contact Email..." value="<?php echo (isset($contactEmail) ? $contactEmail : ""); ?>" />
						<?php
						if(isset($contactEmailError)) {
							?>
							<div class="m-t-5 text-danger"><small><?php echo $contactEmailError; ?></small></div>
							<?php
						}
						?>
					</div>
					<div class="form-group m-b-0">
						<button type="submit" name="submit" class="btn btn-primary">
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
<script type="text/javascript">
	$(document).ready(function() {
		$('#status-check').change(function() {
			if($(this).prop('checked') == true) {
				$("#settings-panel").removeClass("hide");
			}
			else {
				$("#settings-panel").addClass("hide");
			}
		})
	});
</script>
<?php $this->load->view("admin/includes/lte/footer-end"); ?>