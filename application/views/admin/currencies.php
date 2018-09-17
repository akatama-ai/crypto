<?php $this->load->view("admin/includes/lte/head"); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/jquery-confirm/jquery-confirm.min.css"); ?>">
<title>All Currencies - <?php echo $settings['title']; ?></title>
<?php $this->load->view("admin/includes/lte/header"); ?>
<?php $this->load->view("admin/includes/lte/sidebar"); ?> 
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Currencies
			<small>Manage all currencies</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_CONTROLLER."/dashboard"); ?>">Dashboard</a></li>
			<li class="active">Currencies</li>
		</ol>
	</section>
	<section class="content">
		<div class="row m-b-10">
			<div class="pull-left col-sm-8 col-xs-12">
				<a href="<?php echo base_url(ADMIN_CONTROLLER."/add-currency"); ?>" class="m-b-10 btn btn-success"><i class="fa fa-plus-circle"></i> Add new currency</a>
				<a class="update-currency-prices m-b-10 btn btn-primary"><i class="fa fa-check-square-o"></i> Update Currency Prices</a>
			</div>
			<div class="pull-right col-sm-4 col-xs-12">
				<input class="m-b-10 form-control cc-search" type="search" id="search" placeholder="Search Currency..." />
				<img class="hide" id="search-loader" width="20" src="<?php echo base_url("assets/images/loader.svg"); ?>" />
			</div>
		</div>
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-money"></i> Currencies</h3>
			</div>
			<div class="box-body">
				<div class="response">
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
<script type="text/javascript" src="<?php echo base_url("assets/doneTyping/doneTyping.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/jquery-confirm/jquery-confirm.min.js"); ?>"></script>
<script type="text/javascript">
$(document).ready(function() {
	$.ajax ({
		type: "POST",
		url: baseURL+adminURL +"/get-currencies",
		success: function(ajaxresult) {
			$(".response").html(ajaxresult);
		}
	});
	
	$(document).on("click",".page",function() {
		$(".response").css("opacity","0.5");
		var search = $("#search").val();
		var page = $(this).attr("data-pageid");
		var sort = $("#sort").val();
		var sortOrder = $("#sortOrder").val();
		$.ajax ({
			type: "POST",
			url: baseURL+adminURL +"/get-currencies",
			data : {"search":search,"page":page,"sort":sort,"sortOrder":sortOrder},
			success: function(ajaxresult) {
				$(".response").html(ajaxresult).css("opacity","1");
			}
		});
	});
	
	$(document).on("click",".sort-click",function() {
		$(".response").css("opacity","0.5");
		var search = $("#search").val();
		var sort = $(this).attr("data-sort");
		var sortOrder = $(this).attr("data-sortorder");
		$.ajax ({
			type: "POST",
			url: baseURL+adminURL +"/get-currencies",
			data : {"search":search,"sort":sort,"sortOrder":sortOrder},
			success: function(ajaxresult) {
				$(".response").html(ajaxresult).css("opacity","1");
			}
		});
	});
	
	$('#search').donetyping(function() {
		$(".response").css("opacity","0.5");
		$("#search-loader").removeClass("hide");
		var search = $(this).val();
		var sort = $("#sort").val();
		var sortOrder = $("#sortOrder").val();
		$.ajax ({
			type: "POST",
			url: baseURL+adminURL +"/get-currencies",
			data : {"search":search,"sort":sort,"sortOrder":sortOrder},
			success: function(ajaxresult) {
				$("#search-loader").addClass("hide");
				$(".response").html(ajaxresult).css("opacity","1");
			}
		});
	},500);	
	
	$(document).on("click",".delete-currency",function() {
		var context = $(this);
		var alertContext = $.confirm({
			title: 'Confirm!',
			content: 'Do you want to delete this currency?',
			theme: 'dark',
			buttons: {
				confirm: {
					text: 'Confirm',
					btnClass: 'btn-green',
					action: function(){
						$(".response").css("opacity","0.5");
						var currency = context.attr("data-currency");
						var search = $("#search").val();
						var page = $("#page").val();
						var sort = $("#sort").val();
						var sortOrder = $("#sortOrder").val();
						this.buttons.confirm.setText('Wait <i class="fa fa-spinner fa-spin"></i>');
						$.ajax ({
							type: 'POST',
							url: baseURL+adminURL+"/get-currencies",
							data: {"deleteCurrency":"deleteCurrency","currency":currency,"search":search,"page":page,"sort":sort,"sortOrder":sortOrder},
							success: function(ajaxresult) {
								alertContext.close();
								$(".response").html(ajaxresult).css("opacity","1");
								var deleteValue = $("#currencyDeleted").val();
								if(deleteValue == 1) {
									$.confirm({
										title: 'Success!',
										theme: 'dark',
										content: "Currency delete successfully.",
										type: 'green',
										typeAnimated: true,
										buttons: {
											close: function () {
											}
										}
									});
								}
								else {
									$.confirm({
										title: 'Error!',
										theme: 'dark',
										content: "Default currency cannot be deleted.",
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
				},
				close: {
					text: 'Cancel',
					action: function(){}
				}
			}
		});
	});
	
	$(".update-currency-prices").click(function() {
		var context = $(this);
		var alertContext = $.confirm({
			title: 'Confirm!',
			content: 'Do you want to update all currency prices?',
			theme: 'dark',
			buttons: {
				confirm: {
					text: 'Confirm',
					btnClass: 'btn-green',
					action: function(){
						this.buttons.confirm.setText('Wait <i class="fa fa-spinner fa-spin"></i>');
						$.ajax ({
							type: 'POST',
							dataType: "json",
							url: baseURL+adminURL+"/update-currency-prices",
							data: {"updateCurrencyPrices":"updateCurrencyPrices"},
							success: function(ajaxresult) {
								alertContext.close();
								if(ajaxresult.status == "success") {
									$.confirm({
										title: 'Success!',
										theme: 'dark',
										content: ajaxresult.message,
										type: 'green',
										typeAnimated: true,
										buttons: {
											close: function () {
												location.reload();
											}
										}
									});
								}
								else {
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