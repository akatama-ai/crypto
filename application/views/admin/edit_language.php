<?php $this->load->view("admin/includes/lte/head"); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/bootstrap-toggle/css/bootstrap-toggle.min.css"); ?>">
<title>Edit Language - <?php echo $name ." - ". $settings['title']; ?></title>
<?php $this->load->view("admin/includes/lte/header"); ?>
<?php $this->load->view("admin/includes/lte/sidebar"); ?> 
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Edit Language (<?php echo $name; ?>)
			<small>Edit this Language (<?php echo $name; ?>)</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_CONTROLLER."/dashboard"); ?>">Dashboard</a></li>
			<li><a href="<?php echo base_url(ADMIN_CONTROLLER."/languages"); ?>">languages</a></li>
			<li class="active">Edit Language</li>
		</ol>
	</section>
	<section class="content">		
		<?php
		if(isset($_POST['submit'])) {
			if($error == false) {
				?>
				<div class="alert alert-success">
					<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<i class="fa fa-check-square-o"></i> Language updated successfully.
				</div>
				<?php
			}
			else {
				?>
				<div class="alert alert-danger">
					<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<i class="fa fa-warning"></i> Some error occured cannot update language.
				</div>
				<?php
			}
		}
		?>
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-pencil-square-o"></i> Edit Language (<?php echo $name; ?>)</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
				</div>
			</div>
			<div class="box-body">
				<form method="post" action="<?php echo base_url(ADMIN_CONTROLLER."/edit-language/".$id); ?>">
					<div class="form-group">
						<label>Name</label>
						<input type="text" name="name" class="form-control" placeholder="Enter Language Name..." value="<?php echo (isset($name) ? $name : ""); ?>" />
						<?php
						if(isset($nameError)) {
							?>
							<div class="m-t-5 text-danger"><small><?php echo $nameError; ?></small></div>
							<?php
						}
						?>
					</div>
					<div class="form-group">
						<label>Code</label>
						<input type="hidden" name="oldCode" value="<?php echo(isset($oldCode) ? $oldCode : $code); ?>"/>
						<input type="text" name="code" class="form-control" placeholder="Enter Language Code..." value="<?php echo (isset($code) ? $code : ""); ?>" />
						<?php
						if(isset($codeError)) {
							?>
							<div class="m-t-5 text-danger"><small><?php echo $codeError; ?></small></div>
							<?php
						}
						?>
					</div>
					<div class="form-group">
						<label>Flag</label>
						<div>
							<img style="max-width:100px;" id="countryFlagShow" class="img-responsive img-thumbnail" src="<?php echo base_url("assets/images/flags/".$flag.".svg"); ?>" />
						</div>
						<div class="m-t-10">
							<select id="countries" class="form-control" name="flag">
								<?php
								foreach($countries as $index => $value) {
									?>
									<option value="<?php echo $index; ?>" <?php echo(isset($flag) && $flag == $index ? "selected" : ""); ?>><?php echo $value; ?></option>
									<?php
								}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label>Status</label>
						<div>
							<input type="checkbox" name="status" data-toggle="toggle" data-size="small" data-onstyle="success" <?php echo(isset($status) && $status == 1 ? "checked" : ""); ?> />
						</div>
					</div>
					<div class="form-group m-b-0">
						<button type="submit" name="submit" class="btn btn-primary">
							<i class="fa fa-pencil-square-o"></i> Update
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
		$("#countries").change(function() {
			var value = $(this).val();
			$("#countryFlagShow").attr("src",baseURL+"assets/images/flags/"+value+".svg");
		});
	});
</script>
<?php $this->load->view("admin/includes/lte/footer-end"); ?>