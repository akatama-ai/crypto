<?php $this->load->view("admin/includes/lte/head"); ?>
<title>Profile Settings - <?php echo $settings['title']; ?></title>
<?php $this->load->view("admin/includes/lte/header"); ?>
<?php $this->load->view("admin/includes/lte/sidebar"); ?> 
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Profile Settings
			<small>Change Username and Email</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_CONTROLLER."/dashboard"); ?>">Dashboard</a></li>
			<li class="active">Profile Settings</li>
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
							<i class="fa fa-check-square-o"></i> Profile Settings updated successfully.
						</div>
						<?php
					}
					else {
						?>
						<div class="alert alert-danger">
							<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<i class="fa fa-warning"></i> Some error occured cannot update profile.
						</div>
						<?php
					}
				}
				?>
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-user-o"></i> Profile Settings</h3>
						<a href="<?php echo base_url(ADMIN_CONTROLLER."/change-password"); ?>" class="pull-right btn btn-primary btn-md"><i class="fa fa-key fa-fw"></i> Change Password</a>
					</div>
					<div class="box-body">
						<form method="post" action="<?php echo base_url(ADMIN_CONTROLLER."/profile"); ?>">
							<div class="form-group">
								<label>Username</label>
								<input type="text" name="username" class="form-control" placeholder="Enter Username..." value="<?php echo (isset($username) ? $username : ""); ?>" />
								<?php
								if(isset($usernameError)) {
									?>
									<div class="m-t-5 text-danger"><small><?php echo $usernameError; ?></small></div>
									<?php
								}
								?>
							</div>
							<div class="form-group">
								<label>Email</label>
								<input type="text" name="email" class="form-control" placeholder="Enter Email..." value="<?php echo (isset($email) ? $email : ""); ?>" />
								<?php
								if(isset($emailError)) {
									?>
									<div class="m-t-5 text-danger"><small><?php echo $emailError; ?></small></div>
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
			</div>
		</div>
		
	</section>
</div>
<?php $this->load->view("admin/includes/lte/footer-tag"); ?>
<?php $this->load->view("admin/includes/lte/footer-script-files"); ?>
<?php $this->load->view("admin/includes/lte/footer-end"); ?>