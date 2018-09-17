<?php $this->load->view("admin/includes/lte/head"); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/bootstrap-select/css/bootstrap-select.min.css"); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/jquery-confirm/jquery-confirm.min.css"); ?>">
<title>All Coins - <?php echo $settings['title']; ?></title>
<?php $this->load->view("admin/includes/lte/header"); ?>
<?php $this->load->view("admin/includes/lte/sidebar"); ?> 
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Coins
			<small>All Coins Data</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_CONTROLLER."/dashboard"); ?>">Dashboard</a></li>
			<li class="active">Coins</li>
		</ol>
	</section>
	<section class="content">
		<div class="row m-b-10">
			<div class="pull-left col-sm-4 col-xs-6">
				<select id="currency-select" class="selectpicker show-tick" data-width="100%" data-style="btn-default" data-size="7" data-live-search="true">
					<?php
					foreach($currencyRates as $row) {
						?>
						<option <?php echo($row['currency'] == $currency ? "selected" : ""); ?> value="<?php echo $row['currency']; ?>" data-subtext="<?php echo $row['currency']; ?>" data-content="<img width='26' src='<?php echo base_url("assets/images/flags/".$row['countryCode'].".svg"); ?>' />&nbsp;&nbsp;<span><?php echo $row['name']; ?></span>"></option>
						<?php
					}
					?>
				</select>
			</div>
			<div class="pull-right col-sm-4 col-xs-6">
				<input class="form-control cc-search" type="search" id="search" placeholder="Search Coins..." />
				<img class="hide" id="search-loader" width="15" src="<?php echo base_url("assets/images/loader_green.svg"); ?>" />
			</div>
		</div>
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-btc"></i> Coins</h3>
				<div class="box-tools pull-right">
					<a href="<?php echo base_url(ADMIN_CONTROLLER."/update-data"); ?>" class="btn btn-primary btn-md"><i class="fa fa-check-square-o"></i> Update Coins</a>
					&nbsp;&nbsp;
					<a href="<?php echo base_url(ADMIN_CONTROLLER."/add-coin"); ?>" class="btn btn-success btn-md"><i class="fa fa-plus-circle"></i> Add New Coin</a>
				</div>
			</div>
			<div class="box-body">
				<div class="response">
					<input type="hidden" id="currency" value="<?php echo $currency; ?>"/>
					<div class="text-center">
						<img src="<?php echo base_url("assets/images/loader_green.svg"); ?>" />
					</div>
				</div>
			</div>
		</div>
	</section>	
</div>
<?php $this->load->view("admin/includes/lte/footer-tag"); ?>
<?php $this->load->view("admin/includes/lte/footer-script-files"); ?>
<script type="text/javascript" src="<?php echo base_url("assets/bootstrap-select/js/bootstrap-select.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/doneTyping/doneTyping.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/jquery-confirm/jquery-confirm.min.js"); ?>"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('.selectpicker').selectpicker();
	
	var currency = $("#currency").val();
	$.ajax ({
		type: "POST",
		url: baseURL+adminURL +"/get-coins",
		data : {"currency":currency},
		success: function(ajaxresult) {
			$(".response").html(ajaxresult);
		}
	});
	
	$("#currency-select").change(function() {
		$(".response").css("opacity","0.5");
		var search = $("#search").val();
		var page = $("#page").val();
		var currency = $(this).val();
		var sort = $("#sort").val();
		var sortOrder = $("#sortOrder").val();
		$.ajax ({
			type: "POST",
			url: baseURL+adminURL +"/get-coins",
			data : {"search":search,"page":page,"currency":currency,"sort":sort,"sortOrder":sortOrder},
			success: function(ajaxresult) {
				$(".response").html(ajaxresult).css("opacity","1");
			}
		});
	});
	
	$(document).on("click",".page",function() {
		$(".response").css("opacity","0.5");
		var search = $("#search").val();
		var page = $(this).attr("data-pageid");
		var currency = $("#currency").val();
		var sort = $("#sort").val();
		var sortOrder = $("#sortOrder").val();
		$.ajax ({
			type: "POST",
			url: baseURL+adminURL +"/get-coins",
			data : {"search":search,"page":page,"currency":currency,"sort":sort,"sortOrder":sortOrder},
			success: function(ajaxresult) {
				$(".response").html(ajaxresult).css("opacity","1");
			}
		});
	});
	
	$(document).on("click",".sort-click",function() {
		$(".response").css("opacity","0.5");
		var search = $("#search").val();
		var currency = $("#currency").val();
		var sort = $(this).attr("data-sort");
		var sortOrder = $(this).attr("data-sortorder");
		$.ajax ({
			type: "POST",
			url: baseURL+adminURL +"/get-coins",
			data : {"search":search,"currency":currency,"sort":sort,"sortOrder":sortOrder},
			success: function(ajaxresult) {
				$(".response").html(ajaxresult).css("opacity","1");
			}
		});
	});
	
	$('#search').donetyping(function() {
		$(".response").css("opacity","0.5");
		$("#search-loader").removeClass("hide");
		var search = $(this).val();
		var currency = $("#currency").val();
		var sort = $("#sort").val();
		var sortOrder = $("#sortOrder").val();
		$.ajax ({
			type: "POST",
			url: baseURL+adminURL +"/get-coins",
			data : {"search":search,"currency":currency,"sort":sort,"sortOrder":sortOrder},
			success: function(ajaxresult) {
				$("#search-loader").addClass("hide");
				$(".response").html(ajaxresult).css("opacity","1");
			}
		});
	},500);	

	$(document).on("click",".update-coin",function() {
		var context = $(this);
		var alertContext = $.confirm({
			title: 'Confirm!',
			content: 'Do you want to update this coin?',
			theme: 'dark',
			buttons: {
				confirm: {
					text: 'Confirm',
					btnClass: 'btn-green',
					action: function(){
						var symbol = context.attr("data-symbol");
						this.buttons.confirm.setText('Wait <i class="fa fa-spinner fa-spin"></i>');
						$.ajax ({
							type: 'POST',
							dataType: 'json',
							url: baseURL+"cron/update-coin/"+symbol,
							success: function (result) {
								alertContext.close();
								if(result.status && result.status == "success") {
									$.confirm({
										title: 'Success!',
										theme: 'dark',
										content: result.message,
										type: 'green',
										typeAnimated: true,
										buttons: {
											close: function () {
											}
										}
									});
								}
							}
						});
						return false;
					}
				},
				close: {
					text: 'Cancel',
					action: function(){}
				}
			}
		});
	});
	
	$(document).on("click",".delete-coin",function() {
		var context = $(this);
		var alertContext = $.confirm({
			title: 'Confirm!',
			content: 'Do you want to delete this coin?',
			theme: 'dark',
			buttons: {
				confirm: {
					text: 'Confirm',
					btnClass: 'btn-green',
					action: function(){
						$(".response").css("opacity","0.5");
						var symbol = context.attr("data-symbol");
						var search = $("#search").val();
						var page = $("#page").val();
						var currency = $("#currency").val();
						var sort = $("#sort").val();
						var sortOrder = $("#sortOrder").val();
						this.buttons.confirm.setText('Wait <i class="fa fa-spinner fa-spin"></i>');
						$.ajax ({
							type: 'POST',
							url: baseURL+adminURL+"/get-coins",
							data: {"deleteCoin":"deleteCoin","symbol":symbol,"search":search,"page":page,"currency":currency,"sort":sort,"sortOrder":sortOrder},
							success: function(ajaxresult) {
								alertContext.close();
								$(".response").html(ajaxresult).css("opacity","1");
								$.confirm({
									title: 'Success!',
									theme: 'dark',
									content: "Coin delete successfully.",
									type: 'green',
									typeAnimated: true,
									buttons: {
										close: function () {
										}
									}
								});
							}
						});
						return false;
					}
				},
				close: {
					text: 'Cancel',
					action: function(){}
				}
			}
		});
	});
	
	$(document).on("click",".update-coin-affiliate-link",function() {
		var context = $(this);
		var OldLinkValue = context.attr("data-affiliatelink");
		var alertContext = $.confirm ({
			title: 'Change Affiliate Link!',
			content: '' +
			'<form class="affiliate-link-form">' +
			'<div class="form-group">' +
			'<label>Affiliate Link</label>' +
			'<input type="text" placeholder="Affiliate Link" value="'+OldLinkValue+'" class="link form-control" required />' +
			'<div>' +
			'<small>Click <a target="_blank" href="https://changelly.com/">Here</a> to create your account.</small>' +
			'</div>' +
			'</div>' +
			'</form>',
			buttons: {
				formSubmit: {
					text: 'Submit',
					btnClass: 'btn-blue',
					action: function () {
						var link = this.$content.find('.link').val();
						if(!link) {
							$.alert('provide a valid link');
							return false;
						}
						else if(OldLinkValue != link) {
							var formSubmitButtonContext = this.buttons.formSubmit;
							formSubmitButtonContext.setText('Wait <i class="fa fa-spinner fa-spin"></i>');
							var symbol = context.attr("data-symbol");
							$.ajax ({
								type: 'POST',
								dataType: 'json',
								url: baseURL+adminURL+"/change-coin-affiliate-link",
								data: {"changeCoinAffiliateLink":"changeCoinAffiliateLink","symbol":symbol,"link":encodeURIComponent(link)},
								success: function(ajaxresult) {
									if(ajaxresult.status == "success") {
										alertContext.close();
										context.attr("data-affiliatelink",link);
										$.confirm({
											title: 'Success!',
											theme: 'dark',
											content: ajaxresult.message,
											type: 'green',
											typeAnimated: true,
											buttons: {
												close: function () {
												}
											}
										});
									}
									else {
										formSubmitButtonContext.setText('Submit');
										$.confirm({
											title: 'Error!',
											theme: 'dark',
											content: ajaxresult.message,
											type: 'orange',
											typeAnimated: true,
											buttons: {
												close: function () {
												}
											}
										});
									}
								}
							});
							return false;
						}
					}
				},
				cancel: function () {},
			},
			onContentReady: function () {
				var jc = this;
				this.$content.find('form').on('submit', function (e) {
					e.preventDefault();
					jc.$$formSubmit.trigger('click');
				});
			}
		});
	});
	
	$(document).on("click",".change-status",function() {
		var context = $(this);
		var contentDescription = (context.attr("data-status") == 1 ? "Do you want disable this coin?" : "Do you want enable this coin?");
		var alertContext = $.confirm({
			title: 'Confirm!',
			content: contentDescription,
			theme: 'dark',
			buttons: {
				confirm: {
					text: 'Confirm',
					btnClass: 'btn-green',
					action: function(){
						var symbol = context.attr("data-symbol");
						var status = (context.attr("data-status") == 1 ? 0 : 1);
						this.buttons.confirm.setText('Wait <i class="fa fa-spinner fa-spin"></i>');
						$.ajax ({
							type: 'POST',
							dataType: "json",
							url: baseURL+adminURL+"/change-coin-status",
							data: {"changeCoinStatus":"changeCoinStatus","symbol":symbol,"status":status},
							success: function(ajaxresult) {
								alertContext.close();
								context.attr("data-status",status);
								var textInd = (status == 0 ? "black" : "green");
								context.find("i").css("color",textInd);
								$.confirm({
									title: 'Success!',
									theme: 'dark',
									content: ajaxresult.message,
									type: 'green',
									typeAnimated: true,
									buttons: {
										close: function () {
										}
									}
								});
							}
						});
						return false;
					}
				},
				close: {
					text: 'Cancel',
					action: function(){}
				}
			}
		});
	});
});
</script>
<?php $this->load->view("admin/includes/lte/footer-end"); ?>