<?php $this->load->view("admin/includes/lte/head"); ?>
<link href="<?php echo base_url("assets/bootstrap-toggle/css/bootstrap-toggle.min.css"); ?>" rel="stylesheet" type="text/css">
<link href="<?php echo base_url("assets/bootstrap-select/css/bootstrap-select.min.css"); ?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/froala-editor/froala-editor.min.css"); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/froala-editor/froala-style.min.css"); ?>">
<title>General Settings - <?php echo $settings['title']; ?></title>
<?php $this->load->view("admin/includes/lte/header"); ?>
<?php $this->load->view("admin/includes/lte/sidebar"); ?> 
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			General Settings
			<small>Manage all general settings here</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_CONTROLLER."/dashboard"); ?>">Dashboard</a></li>
			<li class="active">General Settings</li>
		</ol>
	</section>
	<section class="content">
		<?php
		if(isset($_POST['submit'])) {
			if($error == false) {
				?>
				<div class="alert alert-success">
					<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<i class="fa fa-check-square-o"></i> General settings updated successfully.
				</div>
				<?php
			}
			else {
				?>
				<div class="alert alert-danger">
					<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<i class="fa fa-warning"></i> Some error occured cannot update general settings.
				</div>
				<?php
			}
		}
		?>
		
		<div class="row">
		<form method="post" action="<?php echo base_url(ADMIN_CONTROLLER."/general-settings"); ?>" enctype="multipart/form-data">
		
			<div class="col-md-6">
			
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-cogs"></i> General Settings</h3>
					</div>
					<div class="box-body">
						
							<div class="form-group">
								<label>Title</label>
								<input type="text" name="title" class="form-control" placeholder="Enter Title..." value="<?php echo (isset($title) ? $title : ""); ?>" />
								<?php
								if(isset($titleError)) {
									?>
									<div class="m-t-5 text-danger"><small><?php echo $titleError; ?></small></div>
									<?php
								}
								?>
							</div>
							<div class="form-group">
								<label>Description</label>
								<textarea name="description" class="form-control" placeholder="Enter Description..." rows="4"><?php echo (isset($description) ? $description : ""); ?></textarea>
								<?php
								if(isset($descriptionError)) {
									?>
									<div class="m-t-5 text-danger"><small><?php echo $descriptionError; ?></small></div>
									<?php
								}
								?>
							</div>
							<div class="form-group">
								<label>Keywords</label>
								<input type="text" name="keywords" class="form-control" placeholder="Enter Keywords..." value="<?php echo (isset($keywords) ? $keywords : ""); ?>" />
								<?php
								if(isset($keywordsError)) {
									?>
									<div class="m-t-5 text-danger"><small><?php echo $keywordsError; ?></small></div>
									<?php
								}
								?>
							</div>
							
							<div class="form-group">
								<label>Affiliate Link</label>
								<input type="text" name="affiliateLink" class="form-control" placeholder="Enter Affilate Link..." value="<?php echo (isset($affiliateLink) ? $affiliateLink : ""); ?>" />
								<div>
									<small>Click <a target="_blank" href="https://changelly.com">Here</a> to create your account.</small>
								</div>
								<?php
								if(isset($affiliateLinkError)) {
									?>
									<div class="m-t-5 text-danger"><small><?php echo $affiliateLinkError; ?></small></div>
									<?php
								}
								?>
							</div>
							<div class="form-group">
								<label>Default Currency</label>
								<select id="currency-select" name="defaultCurrency" class="selectpicker show-tick" data-width="100%" data-style="btn-default" data-size="7" data-live-search="true">
									<?php
									foreach($currencyRates as $row) {
										?>
										<option <?php echo($row['currency'] == $defaultCurrency ? "selected" : ""); ?> value="<?php echo $row['currency']; ?>" data-subtext="<?php echo $row['currency']; ?>" data-content="<img width='26' src='<?php echo base_url("assets/images/flags/".$row['countryCode'].".svg"); ?>' />&nbsp;&nbsp;<span><?php echo $row['name']; ?></span>"></option>
										<?php
									}
									?>
								</select>
							</div>
							<div class="form-group">
								<label>Facebook App ID</label>
								<input type="text" name="facebookAppId" class="form-control" placeholder="Enter Facebook App ID..." value="<?php echo (isset($facebookAppId) ? $facebookAppId : ""); ?>" />
								<small>Get your <strong>Facebook Credentials</strong> form <a target="_blank" href="https://developers.facebook.com/">here</a>. For more information <strong>read documentation</strong></small>
							</div>
							<div class="form-group">
								<label>OpenExchangeRates Api Key</label>
								<input type="text" name="openexchangeratesApiKey" class="form-control" placeholder="Enter OpenExchangeRates API Key..." value="<?php echo (isset($openexchangeratesApiKey) ? $openexchangeratesApiKey : ""); ?>" />
								<small>Get your <strong>OpenExchangeRates API Key</strong> form <a target="_blank" href="https://openexchangerates.org/">here</a>. For more information <strong>read documentation</strong></small>
							</div>
							
							<div class="form-group">
								<label>Default Sort By</label>
								<select name="sortByColumn" class="selectpicker show-tick" data-width="100%" data-style="btn-default">
									<?php
									foreach($sortByColumns as $index => $value) {
										?>
										<option <?php echo($index == $sortByColumn ? "selected" : ""); ?> value="<?php echo $index; ?>" ><?php echo $value; ?></option>
										<?php
									}
									?>
								</select>
							</div>
							
					</div>
				</div><!-- box -->
				
			</div>
			
			<div class="col-md-6">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-cogs"></i> Logos, Banner and Favicon Setting</h3>
					</div>
					<div class="box-body">
							<div class="form-group">
								<label>Cover Image</label>
								<div>
									<img style="max-width:300px;" id="coverImageShow" class="img-responsive img-thumbnail" src="<?php echo base_url("assets/images/".$coverImage); ?>" />
									<input type="hidden" name="oldCoverImage" value="<?php echo $coverImage; ?>" />
								</div>
								<div class="m-t-5">
									<input id="coverImage" type="file" class="hide" name="coverImage" />
									<button id="coverImageSelect" type="button" class="btn btn-xs btn-success"><small><i class="fa fa-upload"></i> &nbsp;Change Cover Image</small></button>
								</div>
								<?php
								if(isset($coverImageError)) {
									?>
									<div class="m-t-5 text-danger"><small><?php echo $coverImageError; ?></small></div>
									<?php
								}
								?>
							</div>
							<div class="form-group">
								<label>Light Logo</label>
								<div>
									<img style="max-width:160px;" id="lightLogoShow" class="img-responsive img-thumbnail" src="<?php echo base_url("assets/images/".$lightLogo); ?>" />
									<input type="hidden" name="oldLightLogo" value="<?php echo $lightLogo; ?>" />
								</div>
								<div class="m-t-5">
									<input id="lightLogo" type="file" class="hide" name="lightLogo" />
									<button id="lightLogoSelect" type="button" class="btn btn-xs btn-success"><small><i class="fa fa-upload"></i> &nbsp;Change Light Logo</small></button>
								</div>
								<?php
								if(isset($lightLogoError)) {
									?>
									<div class="m-t-5 text-danger"><small><?php echo $lightLogoError; ?></small></div>
									<?php
								}
								?>
							</div>
							<div class="form-group">
								<label>Dark Logo</label>
								<div>
									<img style="max-width:160px;" id="night_logo" class="img-responsive img-thumbnail" src="<?php echo base_url("assets/images/".$darkLogo); ?>" />
									<input type="hidden" name="oldDarkLogo" value="<?php echo $darkLogo; ?>" />
								</div>
								<div class="m-t-5">
									<input id="darkLogo" type="file" class="hide" name="darkLogo" />
									<button id="darkLogoSelect" type="button" class="btn btn-xs btn-success"><small><i class="fa fa-upload"></i> &nbsp;Change Dark Logo</small></button>
								</div>
								<?php
								if(isset($darkLogoError)) {
									?>
									<div class="m-t-5 text-danger"><small><?php echo $darkLogoError; ?></small></div>
									<?php
								}
								?>
							</div>
							<div class="form-group">
								<label>Favicon</label>
								<div>
									<img style="max-width:100px;" id="faviconShow" class="img-responsive img-thumbnail" src="<?php echo base_url("assets/images/".$favicon); ?>" />
									<input type="hidden" name="oldFavicon" value="<?php echo $favicon; ?>" />
								</div>
								<div class="m-t-5">
									<input id="favicon" type="file" class="hide" name="favicon" />
									<button id="faviconSelect" type="button" class="btn btn-xs btn-success"><small><i class="fa fa-upload"></i> &nbsp; Change Favicon</small></button>
								</div>
								<?php
								if(isset($faviconError)) {
									?>
									<div class="m-t-5 text-danger"><small><?php echo $faviconError; ?></small></div>
									<?php
								}
								?>
							</div>
						
					</div>
				</div><!-- box -->
				
			</div>
			
			<div class="col-xs-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-cogs"></i> Other Setting</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="form-group col-sm-3">
								<label>Default Sort Order</label>
								<div class="clearfix"></div>
								<div class="radio pull-left">
									<label><input type="radio" value="asc" name="sortByType" <?php echo($sortByType == "asc" ? "checked" : ""); ?>> Ascending</label>
								</div>
								<div class="radio pull-left" style="margin-left: 15px;margin-top: 10px;">
									<label><input type="radio" value="desc" name="sortByType" <?php echo($sortByType == "desc" ? "checked" : ""); ?>> Descending</label>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="form-group col-sm-2">
								<label>Default Theme</label>
								<div class="clearfix"></div>
								<div class="radio pull-left">
									<label>
										<input type="radio" value="light" name="theme" <?php echo($theme == "light" ? "checked" : ""); ?>>Light
									</label>
								</div>
								<div class="radio pull-left" style="margin-left: 15px;margin-top: 10px;">
									<label>
										<input type="radio" value="dark" name="theme" <?php echo($theme == "dark" ? "checked" : ""); ?>>Dark
									</label>
								</div>
								<div class="clearfix"></div>
							</div>
							
							<div class="col-sm-3">
								<div class="form-group pull-left">
									<label>Force <strong>(www)</strong></label>
									<div class="clearfix"></div>
									<div>
										<input type="checkbox" name="www" data-toggle="toggle" data-size="small" data-onstyle="success" <?php echo(isset($www) && $www == 1 ? "checked" : ""); ?> />
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="form-group" style="margin-left: 30px;float: left;">
									<label>Force <strong>(https)</strong></label>
									<div class="clearfix"></div>
									<div>
										<input type="checkbox" name="https" data-toggle="toggle" data-size="small" data-onstyle="success" <?php echo(isset($https) && $https == 1 ? "checked" : ""); ?> />
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="form-group col-sm-2">
								<label>Version</label>
								<div class="clearfix"></div>
								<input type="text" name="version" class="form-control" placeholder="Enter Version..." value="<?php echo (isset($version) ? $version : ""); ?>" readonly />
								<div class="clearfix"></div>
							</div>
							<div class="form-group m-b-0 col-sm-2 text-right" style="padding-top: 9px;">
								<button type="submit" name="submit" class="btn btn-success m-t-10 btn-lg">
									<i class="fa fa-check-square-o"></i> Update
								</button>
							</div>
						
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</section>
</div>
<?php $this->load->view("admin/includes/lte/footer-tag"); ?>
<?php $this->load->view("admin/includes/lte/footer-script-files"); ?>
<script type="text/javascript" src="<?php echo base_url("assets/bootstrap-toggle/js/bootstrap-toggle.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/bootstrap-select/js/bootstrap-select.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/froala-editor/froala-editor.min.js"); ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.selectpicker').selectpicker();
		
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
			
		/*** Cover Image ***/	
		$("#coverImageSelect").click(function() {
			$("#coverImage").trigger("click");
		});
			
		$("#coverImage").change(function() {
			var file = this.files[0];
			var match = ["image/jpeg","image/png","image/jpg"];
			showImage(file,"#coverImageShow",match,$(this))
		});
		
		/*** Light Logo ***/
		$("#lightLogoSelect").click(function() {
			$("#lightLogo").trigger("click");
		});
			
		$("#lightLogo").change(function() {
			var file = this.files[0];
			var match = ["image/jpeg","image/png","image/jpg"];
			showImage(file,"#lightLogoShow",match,$(this))
		});
		
		
		/*** Dark Logo ***/
		$("#darkLogoSelect").click(function() {
			$("#darkLogo").trigger("click");
		});
			
		$("#darkLogo").change(function() {
			var file = this.files[0];
			var match = ["image/jpeg","image/png","image/jpg"];
			showImage(file,"#darkLogoShow",match,$(this))
		});
		
		/*** Favicon ***/
		$("#faviconSelect").click(function() {
			$("#favicon").trigger("click");
		});
			
		$("#favicon").change(function() {
			var file = this.files[0];
			var match = ["image/jpeg","image/png","image/jpg","image/ico"];
			showImage(file,"#faviconShow",match,$(this))
		});
	});
</script>
<?php $this->load->view("admin/includes/lte/footer-end"); ?>