<?php $this->load->view("admin/includes/lte/head"); ?>
<title>Add Currency - <?php echo $settings['title']; ?></title>
<?php $this->load->view("admin/includes/lte/header"); ?>
<?php $this->load->view("admin/includes/lte/sidebar"); ?> 
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Add Currency
			<small>Add new Currency</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_CONTROLLER."/dashboard"); ?>">Dashboard</a></li>
			<li><a href="<?php echo base_url(ADMIN_CONTROLLER."/currencies"); ?>">Currencies</a></li>
			<li class="active">Add Currency</li>
		</ol>
	</section>
	<section class="content">
		<?php
		if(isset($_POST['submit'])) {
			if($error == false) {
				?>
				<div class="alert alert-success">
					<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<i class="fa fa-check-square-o"></i> Currency added successfully.
				</div>
				<?php
			}
			else {
				?>
				<div class="alert alert-danger">
					<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<i class="fa fa-warning"></i> Some error occured cannot add currency.
				</div>
				<?php
			}
		}
		?>
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-plus-circle"></i> Add Currency</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
				</div>
			</div>
			<div class="box-body">
				<form method="post" action="<?php echo base_url(ADMIN_CONTROLLER."/add-currency"); ?>">
					<div class="form-group">
						<label>Currency</label>
						<input type="text" name="currency" class="form-control" placeholder="Enter Currency Code..." value="<?php echo (isset($currency) ? $currency : ""); ?>" />
						<?php
						if(isset($currencyError)) {
							?>
							<div class="m-t-5 text-danger"><small><?php echo $currencyError; ?></small></div>
							<?php
						}
						?>
					</div>
					<div class="form-group">
						<label>Rate = 1$</label>
						<input type="text" name="rate" class="form-control" placeholder="Enter Rate = 1$..." value="<?php echo (isset($rate) ? $rate : ""); ?>" />
						<?php
						if(isset($rateError)) {
							?>
							<div class="m-t-5 text-danger"><small><?php echo $rateError; ?></small></div>
							<?php
						}
						?>
					</div>
					<div class="form-group">
						<label>Name</label>
						<input type="text" name="name" class="form-control" placeholder="Enter Currency Name..." value="<?php echo (isset($name) ? $name : ""); ?>" />
						<?php
						if(isset($nameError)) {
							?>
							<div class="m-t-5 text-danger"><small><?php echo $nameError; ?></small></div>
							<?php
						}
						?>
					</div>
					<div class="form-group">
						<label>Symbol</label>
						<input type="text" name="symbol" class="form-control" placeholder="Enter Currency Symbol..." value="<?php echo (isset($symbol) ? $symbol : ""); ?>" />
						<?php
						if(isset($symbolError)) {
							?>
							<div class="m-t-5 text-danger"><small><?php echo $symbolError; ?></small></div>
							<?php
						}
						?>
					</div>
					<div class="form-group">
						<label>Country</label>
						<div id="flag-show" class="m-b-10 <?php echo(!isset($countryCode) || empty($countryCode) || $error == false ? "hide" : ""); ?>">
							<img style="max-width:100px;" id="countryFlagShow" class="img-responsive img-thumbnail" src="<?php echo(isset($countryCode) && !empty($countryCode) && $error == true ? base_url("assets/images/flags/".$countryCode.".svg") : ""); ?>"/>
						</div>
						<div>
							<select id="countries" class="form-control" name="countryCode">
								<option value="">Select Country</option>
								<?php
								foreach($countries as $index => $value) {
									?>
									<option value="<?php echo $index; ?>" <?php echo(isset($countryCode) && $countryCode == $index && $error == true ? "selected" : ""); ?>><?php echo $value; ?></option>
									<?php
								}
								?>
							</select>
							<?php
							if(isset($countryCodeError)) {
								?>
								<div class="m-t-5 text-danger"><small><?php echo $countryCodeError; ?></small></div>
								<?php
							}
							?>
						</div>
					</div>
					<div class="form-group m-b-0">
						<button type="submit" name="submit" class="btn btn-primary">
							<i class="fa fa-pencil-square-o"></i> Add
						</button>
					</div>
				</form>
			</div>
		</div>
	</section>
</div>
<?php $this->load->view("admin/includes/lte/footer-tag"); ?>
<?php $this->load->view("admin/includes/lte/footer-script-files"); ?>
<script type="text/javascript">
	$(document).ready(function() {
		$("#countries").change(function() {
			var value = $(this).val();
			if(value && value.length !== 0) {
				$("#flag-show").removeClass("hide");
				$("#countryFlagShow").attr("src",baseURL+"assets/images/flags/"+value+".svg");
			}
			else {
				$("#flag-show").addClass("hide");
				$("#countryFlagShow").removeAttr("src");
			}
		});
	});
</script>
<?php $this->load->view("admin/includes/lte/footer-end"); ?>