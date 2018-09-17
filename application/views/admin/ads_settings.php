<?php $this->load->view("admin/includes/lte/head"); ?>
<link href="<?php echo base_url("assets/bootstrap-toggle/css/bootstrap-toggle.min.css"); ?>" rel="stylesheet" type="text/css">
<title>Ads Settings - <?php echo $settings['title']; ?></title>
<?php $this->load->view("admin/includes/lte/header"); ?>
<?php $this->load->view("admin/includes/lte/sidebar"); ?> 
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Ads Settings
			<small>Ads settings and positions</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_CONTROLLER."/dashboard"); ?>">Dashboard</a></li>
			<li class="active">Ads Settings</li>
		</ol>
	</section>
	<section class="content">
		<?php
		if(isset($_POST['submit'])) {
			if($error == false) {
				?>
				<div class="alert alert-success">
					<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<i class="fa fa-check-square-o"></i> Ads settings updated successfully.
				</div>
				<?php
			}
			else {
				?>
				<div class="alert alert-danger">
					<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<i class="fa fa-warning"></i> Some error occured cannot update ads settings.
				</div>
				<?php
			}
		}
		?>
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-code"></i> Ads Settings</h3>
			</div>
			<div class="box-body">
				<form method="post" action="<?php echo base_url(ADMIN_CONTROLLER."/ads-settings"); ?>">
					<div class="row">
						<div class="col-sm-10">
							<h3 class="m-t-0">Ad - 728 x 90</h3>
							<hr class="m-t-0" />
							<div class="row">
								<div class="col-sm-2 m-b-10">
									<div class="form-group m-b-0">
										<label>Status</label>
										<div>
											<input type="checkbox" name="ad728x90Status" data-toggle="toggle" data-size="small" data-onstyle="success" <?php echo(isset($ad728x90Status) && $ad728x90Status == 1 ? "checked" : ""); ?> />
										</div>
									</div>
								</div>
								<div class="col-sm-2 m-b-10">
									<div class="form-group m-b-0">
										<label>Responsive</label>
										<div>
											<input type="checkbox" name="ad728x90ResponsiveStatus" data-toggle="toggle" data-size="small" data-onstyle="success" <?php echo(isset($ad728x90ResponsiveStatus) && $ad728x90ResponsiveStatus == 1 ? "checked" : ""); ?> />
										</div>
									</div>
								</div>
								<div class="col-sm-8">
									<div class="form-group">
										<label>Code</label>
										<textarea name="ad728x90" rows="5" class="text-re-no form-control" placeholder="Enter Ad Code"><?php echo (isset($ad728x90) ? stripcslashes($ad728x90) : ""); ?></textarea>
										<?php
										if(isset($ad728x90Error)) {
											?>
											<div class="m-t-5 text-danger"><small><?php echo $ad728x90Error; ?></small></div>
											<?php
										}
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<hr class="m-t-0" />
					<div class="row">
						<div class="form-group col-md-3">
							<label>Display On Home Page</label>
							<div>
								<input type="checkbox" name="displayOnHomePage" data-toggle="toggle" data-size="small" data-onstyle="success" <?php echo(isset($displayOnHomePage) && $displayOnHomePage == 1 ? "checked" : ""); ?> />
							</div>
						</div>
						<div class="form-group col-md-3">
							<label>Display On Coin Page</label>
							<div>
								<input type="checkbox" name="displayOnCoinPage" data-toggle="toggle" data-size="small" data-onstyle="success" <?php echo(isset($displayOnCoinPage) && $displayOnCoinPage == 1 ? "checked" : ""); ?> />
							</div>
						</div>
						<div class="form-group col-md-3">
							<label>Display On Dynamic Pages</label>
							<div>
								<input type="checkbox" name="displayOnDynamicPages" data-toggle="toggle" data-size="small" data-onstyle="success" <?php echo(isset($displayOnDynamicPages) && $displayOnDynamicPages == 1 ? "checked" : ""); ?> />
							</div>
						</div>
						<div class="form-group col-md-3">
							<label>Display On Contact Page</label>
							<div>
								<input type="checkbox" name="displayOnContactPage" data-toggle="toggle" data-size="small" data-onstyle="success" <?php echo(isset($displayOnContactPage) && $displayOnContactPage == 1 ? "checked" : ""); ?> />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-3">
							<label>Display On Watchlist Page</label>
							<div>
								<input type="checkbox" name="displayOnWatchlistPage" data-toggle="toggle" data-size="small" data-onstyle="success" <?php echo(isset($displayOnWatchlistPage) && $displayOnWatchlistPage == 1 ? "checked" : ""); ?> />
							</div>
						</div>
						<div class="form-group col-md-3">
							<label>Display On Portfolio Page</label>
							<div>
								<input type="checkbox" name="displayOnPortfolioPage" data-toggle="toggle" data-size="small" data-onstyle="success" <?php echo(isset($displayOnPortfolioPage) && $displayOnPortfolioPage == 1 ? "checked" : ""); ?> />
							</div>
						</div>
						<div class="form-group col-md-3">
							<label>Display On Movers Page</label>
							<div>
								<input type="checkbox" name="displayOnMoversPage" data-toggle="toggle" data-size="small" data-onstyle="success" <?php echo(isset($displayOnMoversPage) && $displayOnMoversPage == 1 ? "checked" : ""); ?> />
							</div>
						</div>
						<div class="form-group m-b-0 col-md-3">
							<button type="submit" name="submit" class="btn btn-success m-t-5 btn-lg">
								<i class="fa fa-check-square-o"></i> Update
							</button>
						</div>
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