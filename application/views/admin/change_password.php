<?php $this->load->view("admin/includes/lte/head"); ?>
<title>Change Password - <?php echo $settings['title']; ?></title>
<?php $this->load->view("admin/includes/lte/header"); ?>
<?php $this->load->view("admin/includes/lte/sidebar"); ?> 
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Change Password
			<small>Change admin Password</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_CONTROLLER."/dashboard"); ?>">Dashboard</a></li>
			<li class="active">Change Password</li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-6">
				<?php
				if(isset($_POST['submit'])) {
					if($error == false) {
						?>
						<div class="alert alert-success">
							<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<i class="fa fa-check-square-o"></i> Password changed successfully.
						</div>
						<?php
					}
					else {
						?>
						<div class="alert alert-danger">
							<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<i class="fa fa-warning"></i> Some error occured cannot update password.
						</div>
						<?php
					}
				}
				?>
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-key"></i> Change Password</h3>
					</div>
					<div class="box-body">
						<form method="post" action="<?php echo base_url(ADMIN_CONTROLLER."/change-password"); ?>">
							<div class="form-group">
								<label>Old Password</label>
								<input type="password" name="oldPassword" class="form-control" placeholder="Enter Old Password..." value="<?php echo (isset($oldPassword) && $error == true ? $oldPassword : ""); ?>" />
								<?php
								if(isset($oldPasswordError)) {
									?>
									<div class="m-t-5 text-danger"><small><?php echo $oldPasswordError; ?></small></div>
									<?php
								}
								?>
							</div>
							<div class="form-group">
								<label>New Password</label>
								<input type="password" name="newPassword" class="form-control" placeholder="Enter New Password..." value="<?php echo (isset($newPassword) && $error == true ? $newPassword : ""); ?>" />
								<?php
								if(isset($newPasswordError)) {
									?>
									<div class="m-t-5 text-danger"><small><?php echo $newPasswordError; ?></small></div>
									<?php
								}
								?>
							</div>
							<div class="form-group">
								<label>Confirm New Password</label>
								<input type="password" name="confirmNewPassword" class="form-control" placeholder="Confirm New Password..." value="<?php echo (isset($confirmNewPassword) && $error == true ? $confirmNewPassword : ""); ?>" />
								<?php
								if(isset($confirmNewPasswordError)) {
									?>
									<div class="m-t-5 text-danger"><small><?php echo $confirmNewPasswordError; ?></small></div>
									<?php
								}
								?>
							</div>
							<div class="form-group m-b-0">
								<button type="submit" name="submit" class="btn btn-primary">
									<i class="fa fa-check-square-o"></i> Update
								</button>
								<a href="<?php echo base_url(ADMIN_CONTROLLER."/profile"); ?>" class="pull-right btn btn-primary btn-md"><i class="fa fa-arrow-left"></i> Go Back</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		
	</section>
</div>
<?php $this->load->view("admin/includes/lte/footer-tag"); ?>
<?php $this->load->view("admin/includes/lte/footer-script-files"); ?>
<?php $this->load->view("admin/includes/lte/footer-end"); ?>