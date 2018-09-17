<?php $this->load->view("admin/includes/lte/head"); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/bootstrap-toggle/css/bootstrap-toggle.min.css"); ?>">
<title>Add Coin - <?php echo $settings['title']; ?></title>
<?php $this->load->view("admin/includes/lte/header"); ?>
<?php $this->load->view("admin/includes/lte/sidebar"); ?> 
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Add New Coin
			<small>Add new Coin</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_CONTROLLER."/dashboard"); ?>">Dashboard</a></li>
			<li><a href="<?php echo base_url(ADMIN_CONTROLLER."/coins"); ?>">Coins</a></li>
			<li class="active">Add New Coin</li>
		</ol>
	</section>
	<section class="content">
		<?php
		if(isset($_POST['submit'])) {
			if($error == false) {
				?>
				<div class="alert alert-success">
					<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<i class="fa fa-check-square-o"></i> Coin added successfully.
				</div>
				<?php
			}
			else {
				?>
				<div class="alert alert-danger">
					<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<i class="fa fa-warning"></i> Some error occured cannot add coin.
				</div>
				<?php
			}
		}
		?>
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-plus-circle"></i> Add New Coin</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
				</div>
			</div>
			<div class="box-body">
				<form method="post" action="<?php echo base_url(ADMIN_CONTROLLER."/add-coin"); ?>" enctype="multipart/form-data">
					<div class="form-group">
						<label>Name</label>
						<input type="text" name="name" class="form-control" placeholder="Enter Coin Name..." value="<?php echo (isset($name) && $error == true ? $name : ""); ?>" />
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
						<input type="text" name="symbol" class="form-control" placeholder="Enter Coin Symbol..." value="<?php echo (isset($symbol) && $error == true ? $symbol : ""); ?>" />
						<?php
						if(isset($symbolError)) {
							?>
							<div class="m-t-5 text-danger"><small><?php echo $symbolError; ?></small></div>
							<?php
						}
						?>
					</div>
					<div class="form-group">
						<label>Coin Name (Full)</label>
						<input type="text" name="coinName" class="form-control" placeholder="Enter Full Coin Name..." value="<?php echo (isset($coinName) && $error == true ? $coinName : ""); ?>" />
						<?php
						if(isset($coinNameError)) {
							?>
							<div class="m-t-5 text-danger"><small><?php echo $coinNameError; ?></small></div>
							<?php
						}
						?>
					</div>
					<div class="form-group">
						<label>Full Name (with symbol)</label>
						<input type="text" name="fullName" class="form-control" placeholder="like Bitcoin (BTC)..." value="<?php echo (isset($fullName) && $error == true ? $fullName : ""); ?>" />
						<?php
						if(isset($fullNameError)) {
							?>
							<div class="m-t-5 text-danger"><small><?php echo $fullNameError; ?></small></div>
							<?php
						}
						?>
					</div>
					<div class="form-group">
						<label>Price</label>
						<input type="text" name="price" class="form-control" placeholder="Price..." value="<?php echo (isset($price) && $error == true ? $price : ""); ?>" />
						<?php
						if(isset($priceError)) {
							?>
							<div class="m-t-5 text-danger"><small><?php echo $priceError; ?></small></div>
							<?php
						}
						?>
					</div>
					<div class="form-group">
						<label>Volume 24 Hours</label>
						<input type="text" name="volume24Hour" class="form-control" placeholder="volume 24 Hour..." value="<?php echo (isset($volume24Hour) && $error == true ? $volume24Hour : ""); ?>" />
						<?php
						if(isset($volume24HourError)) {
							?>
							<div class="m-t-5 text-danger"><small><?php echo $volume24HourError; ?></small></div>
							<?php
						}
						?>
					</div>
					<div class="form-group">
						<label>Volume 24 Hours (in dollars)</label>
						<input type="text" name="volume24HourTo" class="form-control" placeholder="volume 24 Hour in dollars..." value="<?php echo (isset($volume24HourTo) && $error == true ? $volume24HourTo : ""); ?>" />
						<?php
						if(isset($volume24HourToError)) {
							?>
							<div class="m-t-5 text-danger"><small><?php echo $volume24HourToError; ?></small></div>
							<?php
						}
						?>
					</div>
					<div class="form-group">
						<label>Open Day (in dollars)</label>
						<input type="text" name="openDay" class="form-control" placeholder="Open Day..." value="<?php echo (isset($openDay) && $error == true ? $openDay : ""); ?>" />
						<?php
						if(isset($openDayError)) {
							?>
							<div class="m-t-5 text-danger"><small><?php echo $openDayError; ?></small></div>
							<?php
						}
						?>
					</div>
					<div class="form-group">
						<label>High Day (in dollars)</label>
						<input type="text" name="highDay" class="form-control" placeholder="High Day..." value="<?php echo (isset($highDay) && $error == true ? $highDay : ""); ?>" />
						<?php
						if(isset($highDayError)) {
							?>
							<div class="m-t-5 text-danger"><small><?php echo $highDayError; ?></small></div>
							<?php
						}
						?>
					</div>
					<div class="form-group">
						<label>Low Day (in dollars)</label>
						<input type="text" name="lowDay" class="form-control" placeholder="Low Day..." value="<?php echo (isset($lowDay) && $error == true ? $lowDay : ""); ?>" />
						<?php
						if(isset($lowDayError)) {
							?>
							<div class="m-t-5 text-danger"><small><?php echo $lowDayError; ?></small></div>
							<?php
						}
						?>
					</div>
					<div class="form-group">
						<label>Change 24 Hours (in dollars)</label>
						<input type="text" name="change24Hour" class="form-control" placeholder="Change 24 Hour..." value="<?php echo (isset($change24Hour) && $error == true ? $change24Hour : ""); ?>" />
						<?php
						if(isset($change24HourError)) {
							?>
							<div class="m-t-5 text-danger"><small><?php echo $change24HourError; ?></small></div>
							<?php
						}
						?>
					</div>
					<div class="form-group">
						<label>Change Percentage 24 Hour</label>
						<input type="text" name="changePercentage24Hour" class="form-control" placeholder="Change 24 Hour Percentage..." value="<?php echo (isset($changePercentage24Hour) && $error == true ? $changePercentage24Hour : ""); ?>" />
						<?php
						if(isset($changePercentage24HourError)) {
							?>
							<div class="m-t-5 text-danger"><small><?php echo $changePercentage24HourError; ?></small></div>
							<?php
						}
						?>
					</div>
					<div class="form-group">
						<label>Supply</label>
						<input type="text" name="supply" class="form-control" placeholder="Supply..." value="<?php echo (isset($supply) && $error == true ? $supply : ""); ?>" />
						<?php
						if(isset($supplyError)) {
							?>
							<div class="m-t-5 text-danger"><small><?php echo $supplyError; ?></small></div>
							<?php
						}
						?>
					</div>
					<div class="form-group">
						<label>Market Cap (in dollars)</label>
						<input type="text" name="marketCap" class="form-control" placeholder="Market Cap..." value="<?php echo (isset($marketCap) && $error == true ? $marketCap : ""); ?>" />
						<?php
						if(isset($marketCapError)) {
							?>
							<div class="m-t-5 text-danger"><small><?php echo $marketCapError; ?></small></div>
							<?php
						}
						?>
					</div>
					<div class="form-group">
						<label>Affiliate Link</label>
						<input type="text" name="affiliateLink" class="form-control" placeholder="Affiliate Link..." value="<?php echo (isset($affiliateLink) && $error == true ? $affiliateLink : ""); ?>" />
						<?php
						if(isset($affiliateLinkError)) {
							?>
							<div class="m-t-5 text-danger"><small><?php echo $affiliateLinkError; ?></small></div>
							<?php
						}
						?>
					</div>
					<div class="form-group">
						<label>Description</label>
						<textarea name="description" rows="5" class="form-control" placeholder="Description..."><?php echo (isset($description) && $error == true ? $description : ""); ?></textarea>
						<?php
						if(isset($descriptionError)) {
							?>
							<div class="m-t-5 text-danger"><small><?php echo $descriptionError; ?></small></div>
							<?php
						}
						?>
					</div>
					<div class="form-group">
						<label>Website</label>
						<input type="text" name="website" class="form-control" placeholder="website..." value="<?php echo (isset($website) && $error == true ? $website : ""); ?>" />
						<?php
						if(isset($websiteError)) {
							?>
							<div class="m-t-5 text-danger"><small><?php echo $websiteError; ?></small></div>
							<?php
						}
						?>
					</div>
					<div class="form-group">
						<label>Image</label>
						<div id="imageShowDiv" class="hide">
							<img style="max-width:300px;" id="imageShow" class="img-responsive img-thumbnail"/>
						</div>
						<div class="m-t-5">
							<input id="image" type="file" class="hide" name="image" />
							<button id="imageSelect" type="button" class="btn btn-xs btn-success"><small><i class="fa fa-upload"></i> &nbsp;Upload Image</small></button>
						</div>
						<?php
						if(isset($imageError)) {
							?>
							<div class="m-t-5 text-danger"><small><?php echo $imageError; ?></small></div>
							<?php
						}
						?>
					</div>
					<div class="form-group">
						<label>Status</label>
						<div>
							<input type="checkbox" name="status" data-toggle="toggle" data-size="small" data-onstyle="success" <?php echo(isset($status) && $error == true && $status == 1 ? "checked" : ""); ?> />
						</div>
					</div>
					<div class="form-group m-b-0">
						<button type="submit" name="submit" class="btn btn-primary">
							<i class="fa fa-plus-circle"></i> Add Coin
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
	function showImage(file,element,match,context) {
		var imagefile = file.type;
		if($.inArray(imagefile,match) != -1) {
			var reader = new FileReader();
			reader.readAsDataURL(file);
			reader.onload = function(e) {
				$(element).attr("src",e.target.result);
			};
		}
		else {
			context.val("");
		}
	}
	
	$("#imageSelect").click(function() {
		$("#image").trigger("click");
	});
		
	$("#image").change(function() {
		var file = this.files[0];
		var match = ["image/jpeg","image/png","image/jpg","image/svg+xml"];
		$("#imageShowDiv").removeClass("hide");
		showImage(file,"#imageShow",match,$(this));
	});
});
</script>
<?php $this->load->view("admin/includes/lte/footer-end"); ?>