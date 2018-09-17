<?php $this->load->view("admin/includes/lte/head"); ?>
<title>Analytics Settings - <?php echo $settings['title']; ?></title>
<?php $this->load->view("admin/includes/lte/header"); ?>
<?php $this->load->view("admin/includes/lte/sidebar"); ?> 
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Analytics Settings
			<small>Manage tracking code and analytics settings</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_CONTROLLER."/dashboard"); ?>">Dashboard</a></li>
			<li class="active">Analytics Settings</li>
		</ol>
	</section>
	<section class="content">
		<?php
		if(isset($_POST['submit'])) {
			if($error == false) {
				?>
				<div class="alert alert-success">
					<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<i class="fa fa-check-square-o"></i> Analytics updated successfully.
				</div>
				<?php
			}
			else {
				?>
				<div class="alert alert-danger">
					<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<i class="fa fa-warning"></i> Some error occured cannot update analytics.
				</div>
				<?php
			}
		}
		?>
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-line-chart"></i> Analytics Settings</h3>
			</div>
			<div class="box-body">
				<form method="post" action="<?php echo base_url(ADMIN_CONTROLLER."/analytics-settings"); ?>">
					<div class="form-group">
						<label>Code</label>
						<textarea name="code" class="form-control" placeholder="Enter Tracking Code..." rows="7"><?php echo (isset($code) ? stripcslashes($code) : ""); ?></textarea>
						<?php
						if(isset($codeError)) {
							?>
							<div class="m-t-5 text-danger"><small><?php echo $codeError; ?></small></div>
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
<?php $this->load->view("admin/includes/lte/footer-end"); ?>