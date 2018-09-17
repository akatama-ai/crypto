<?php $this->load->view("admin/includes/lte/head"); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/bootstrap-toggle/css/bootstrap-toggle.min.css"); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/bootstrap-select/css/bootstrap-select.min.css"); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/jquery-confirm/jquery-confirm.min.css"); ?>">
<title>Update Coins Data - <?php echo $settings['title']; ?></title>
<?php $this->load->view("admin/includes/lte/header"); ?>
<?php $this->load->view("admin/includes/lte/sidebar"); ?> 
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Update Coins Data
			<small>update all coins data</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_CONTROLLER."/dashboard"); ?>">Dashboard</a></li>
			<li class="active">Update Data</li>
		</ol>
	</section>
	<section class="content">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-wrench"></i> Update Data</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
				</div>
			</div>
			<div class="box-body">
				<form id="update-form" method="post">
					<div class="form-group">
						<label>Update Action</label>
						<select class="form-control selectpicker" id="update-action">
							<option value="coins">Coins Data</option>
							<option value="history">Historic Data</option>
							<option value="seoDesc">Seo and description</option>
						</select>
					</div>
					<div class="all-coins-list form-group">
						<label>Coins</label>
						<select id="coins-select" class="selectpicker show-tick" data-width="100%" data-style="btn-default" data-size="7" data-live-search="true" multiple>
							<?php
							foreach($coins as $coin) {
								?>
								<option data-cryptoId="<?php echo $coin['cryptoId']; ?>" value="<?php echo $coin['symbol']; ?>"><?php echo $coin['fullName']; ?></option>
								<?php
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label>All Coins</label>
						<div>
							<input type="checkbox" data-on="Yes" data-off="No" data-toggle="toggle" data-size="small" data-onstyle="success" id="all-coins" />
						</div>
					</div>
					<div class="form-group">
						<button id="update-btn" type="submit" name="submit" class="btn btn-primary">
							<i class="fa fa-check-square-o"></i> Update
						</button>
					</div>
					<div id="status-div" class="hide form-group">
						<div id="status"></div>
						<div class="m-t-10 progress">
							<div id="progress-bar-coin" class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
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
<script type="text/javascript" src="<?php echo base_url("assets/bootstrap-select/js/bootstrap-select.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/jquery-confirm/jquery-confirm.min.js"); ?>"></script>
<script type="text/javascript">
$(document).ready(function() {
	var allCoinsUpdate;
	
	$('.selectpicker').selectpicker();
	$('#all-coins').change(function() {
		if($(this).prop('checked') == true) {
			$(".all-coins-list").addClass("hide");
		}
		else {
			$(".all-coins-list").removeClass("hide");
		}
	});
	
	var createGroupedArray = function(arr, chunkSize) {
		var groups = [], i;
		for (i = 0; i < arr.length; i += chunkSize) {
			groups.push(arr.slice(i, i + chunkSize));
		}
		return groups;
	}
	
	$("#update-form").submit(function(e) {
		allCoinsUpdate = false;
		e.preventDefault();
		var action = $("#update-action").val();
		var allCoins = $("#all-coins").prop('checked');
		if(allCoins == false) {
			if(action == "seoDesc") {
				var coins = $("#coins-select").find('option:selected').map(function() {
					return $(this).attr('data-cryptoId');    
				}).get();
			}
			else {
				var coins = $("#coins-select").val();
			}
		}
		else {
			if(action == "seoDesc") {
				var coins = <?php echo json_encode(array_map(function($e) {return $e['cryptoId'];},$coins)); ?>;
			}
			else {
				var coins = <?php echo json_encode(array_map(function($e) {return $e['symbol'];},$coins)); ?>;
			}
			if(action == "coins") {
				var coins = createGroupedArray(coins, 50);
				allCoinsUpdate = true;
			}
		}
		
		if(coins.length > 0) {
			$("#status-div").removeClass("hide");
			$("#status").html('Starting The Process...');
			if(allCoinsUpdate == true) {
				updateAllCoinsData(coins);
			}
			else {
				initialize(action,coins);
			}
			$("#update-btn").attr("disabled",true);
		}
		else {
			$.confirm({
				title: 'Error!',
				theme: 'dark',
				content: "No Coin Selected.",
				type: 'orange',
				typeAnimated: true,
				buttons: {
					close: function () {
					}
				}
			});
		}
	});
	
	function initialize(action,coins) {
		$("#progress-bar-coin").css("width","0%");
		var url;
		if(action == "coins") {
			url = baseURL+"cron/update_coin/";
		}
		else if(action == "history") {
			url = baseURL+"cron/update_historic_data/";
		}
		else if(action == "seoDesc") {
			url = baseURL+"cron/update_seo_desc/";
		}
		
		var i = 0;
		var totalCoins = coins.length;
		var percentageIncrease = 100 / totalCoins;
		var percentage = 0;
		updateData(url,coins,i,totalCoins,percentageIncrease,percentage);
	}
	
	function updateData(url,coins,i,totalCoins,percentageIncrease,percentage) {
		var symbol = coins[i];
		$("#status").html('Updating Coin <strong>'+symbol +'</strong> &nbsp; <i class="fa fa-spinner fa-spin"></i>');
		var endPoint = url+symbol;
		$.ajax ({
			type: 'POST',
			dataType: 'json',
			url: endPoint,
			success: function (result) {
				if(result.status && result.status == "success") {
					percentage = percentage + percentageIncrease;
					$("#progress-bar-coin").css("width",percentage+"%");
					i++;
					if(i < totalCoins) {
						updateData(url,coins,i,totalCoins,percentageIncrease,percentage);
					}
					else {
						$("#status").html('<span class="text-success">Coins Updated Successfully.</span>');
						$("#update-btn").attr("disabled",false);
					}
				}
			}
		});
	}
	
	function updateAllCoinsData(coinsArr) {
		var i = 0;
		var totalCoinsArr = coinsArr.length;
		var percentageIncrease = 100 / totalCoinsArr;
		var percentage = 0;
		updateCoinsData(coinsArr,i,totalCoinsArr,percentageIncrease,percentage);
		$("#status").html('Updating Coins Data Please Wait &nbsp; <i class="fa fa-spinner fa-spin"></i>');
	}
	
	function updateCoinsData(coinsArr,i,totalCoinsArr,percentageIncrease,percentage) {
		var coinsSymbols = coinsArr[i];
		$.ajax ({
			type: 'POST',
			dataType: 'json',
			url: baseURL+adminURL+"/update_all_coins_data",
			data : {"updateAllCoinsData":"updateAllCoinsData","coinsSymbols":JSON.stringify(coinsSymbols)},
			success: function (result) {
				if(result.status && result.status == "success") {
					percentage = percentage + percentageIncrease;
					$("#progress-bar-coin").css("width",percentage+"%");
					i++;
					if(i < totalCoinsArr) {
						updateCoinsData(coinsArr,i,totalCoinsArr,percentageIncrease,percentage);
					}
					else {
						$("#status").html('<span class="text-success">Coins Updated Successfully.</span>');
						$("#update-btn").attr("disabled",false);
					}
				}
			}
		});
	}
});
</script>
<?php $this->load->view("admin/includes/lte/footer-end"); ?>