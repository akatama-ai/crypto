<!DOCTYPE html>
<html lang="en">
  <head>
   <?php $this->load->view("front/includes/head",['adPageHeader'=>$_ci_view]); ?>
  </head>
<body>
	<div id="respondSearch" class="crypto-main-container">
		<?php $this->load->view("front/includes/header"); ?>
			<div class="watchlist_title "><div class="calculator_title">Calculator</div></div>
			<div class="container-fluid watchlist_container watchlist_container_padd ">
				<div class="calca calculator_area_main cal_coin_wd searchSection hide">
					<div class="cal_modal_main">
						<button class="closeCalc modal_cross"></button>
						<div class="cal_coin_selectiv_input_padd">
							<input autocomplete="off" id="queryPanel" placeholder="<?php echo showLangVal($activeLanguage,"search_coins_message"); ?>" type="text" class="cal_coin_selectiv_input" >
							<div class="search-icon-main">
								<span class="search-iconPanel"></span>
								<span class="search-spinnerPanel hide"></span>
								<span class="search-crossPanel hide"><i class="ti-close"></i></span>
							</div>
						</div>
						<div class="cal_coin_selectiv_area">
							<div class="cal_coin_selectiv_main">
								<div class="appeCalc row cal_row_padd">
								<?php foreach($coinList as $index=>$value){?>
									<div id="<?php echo "coins".$value['symbol'];?>" data-img="<?php echo base_url()."assets/images/coins/".$value['image'];?>" data-symbol="<?php echo $value['symbol'];?>" data-price="<?php echo $value['price'];?>" class="calcOp col-sm-4 col-xs-6 cal_col_padd">
										<div class="calcInnerActive inner_coins_area">
											<img src="<?php echo base_url()."assets/images/coins/".$value['image'];?>">
											<h3><?php echo $value['coinName'];?></h3>
											<p><?php echo $value['symbol'];?></p>
										</div>
									</div>
								<?php } ?>
								</div>
								<div class="appender search__item loadmore cal_loadmore_marg">
									<button value="<?php echo count($coinList);?>" type="button" class="loadMore"><?php echo showLangVal($activeLanguage,"load_more"); ?></button>
									<div class="spinnerLoad hide"><img style="height:17px;width:17px;" src="<?php echo base_url()."assets/images/loader.svg"?>"></div>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="maina calculator_area_main">
					<select class="curF selectpicker cal_curr pull-right" data-live-search="true">
					<?php foreach($currencies as $index=>$value){ ?>
						<option currency="<?php echo $value['currency']; ?>" data-val="<?php echo $value['rate']; ?>" <?php echo($value['currency'] == $activeCurrency['currency'] ? "selected" : ""); ?> data-content="<img width='26' src='<?php echo base_url("assets/images/flags/".$value['countryCode'].".svg"); ?>' /> <?php echo $value['currency']; ?>"></option>
					<?php } ?>
					</select>
					<div class="clearfix"></div>
					<div class="cal_input_area">
						<div class="left_grow">
						<input id="frmQty" type="text" value="1"></div>
						<div class="frmName right_grow">
							<img class="frmImg" src="<?php echo base_url()."assets/images/coins/".$coinList[0]['image'];?>" style="vertical-align: middle; width: 26px; margin-right: 7px; margin-bottom: 2px;"> 
							<span class="frmSymbol"><?php echo $coinList[0]['symbol'];?></span>
						</div>
					</div>
					<div class="double_arrow"></div>
					<span class="toPrice cal_curr_txt"><?php echo intlCurFmtr($coinList[0]['price']*$activeCurrency['rate'])." ".$activeCurrency['currency'];?></span>
					<div class="cal_input_area">
						<div class="left_grow">
						<input id="toQty" type="text" value="<?php echo ($coinList[0]['price']/$coinList[1]['price']);?>"></div>
						<div class="toName right_grow">
							<img src="<?php echo base_url()."assets/images/coins/".$coinList[1]['image'];?>" class="toImg" style="vertical-align: middle; width: 26px; margin-right: 7px; margin-bottom: 2px;"> 
							<span class="toSymbol"><?php echo $coinList[1]['symbol'];?></span>
						</div>
					</div>
				</div>
			</div>
	</div>
	<?php $this->load->view("front/includes/footer");?>
	<script>
	function formatNumber(e){return new Intl.NumberFormat('en-IN', { style:"decimal"}).format(e)}
		function slag(x) {
			if(isNaN(x)) return x;
			
			if(x < 1000000) {
				return (x/1000).toFixed(3) + " K";
			}
			if( x < 10000000) {
				return (x/1000000).toFixed(3) + " M";
			}
			if(x < 1000000000) {
				return (x/1000000).toFixed(3) + " M";
			}
			if(x < 1000000000000) {
				return (x/1000000000).toFixed(3) + " B";
			}
			if(x < 1000000000000000) {
				return (x/1000000000000).toFixed(3) + "T";
			}
			return "1T+";
		}
		
	function intlCurFmtr(number,c=false)
	{
		number=parseFloat(number);
		if(number==0)
		{
			return number;
		}
		
		if(number >999999 && !c)
		return slag(number);
		number=number.toFixed(10);
		
		expNum = number.split('.');
		var whole=expNum[0];
		var decimal=expNum[1];
		
		if(whole<=0)
		{
			return number;
		}
		decimal=(parseFloat("."+decimal)).toFixed(3); 
		decimal=decimal.replace(/^0+/, '');
		finalNumber=formatNumber(whole+decimal);
		return finalNumber;
	}
	
		
		
		
	var listCalc=$('.appeCalc').html();var processingRequest2=0;
	var type=0;
	var currSymbol='<?php echo $activeCurrency['currency'];?>';
	
	$(document).on('click','.frmName',function(e){
		$('.calca').removeClass('hide');
		$('.maina').addClass('hide');
		type=0;
	});
	$(document).on('click','.toName',function(e){
		$('.calca').removeClass('hide');
		$('.maina').addClass('hide');
		type=1;
	});
	$(document).on('click','.closeCalc',function(e){
		$('.calca').addClass('hide');
		$('.maina').removeClass('hide');
	});
	
	var frmSymbol="<?php echo $coinList[0]['symbol'];?>";
	var toSymbol="<?php echo $coinList[1]['symbol'];?>";
	var frmPrice=intlCurFmtr(<?php echo $coinList[0]['price'];?>).replace(/,/g, "");
	var toPrice=intlCurFmtr(<?php echo $coinList[1]['price'];?>).replace(/,/g, "");
	
	$('#frmQty,#toQty').keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
	 
	$(document).on('keyup keydown paste ','#frmQty', function(e) {
		var qty=$(this).val();
		if(qty>=0)
		{
			swag(0);
		}
		else
		{
			$('#frmQty,#toQty').val('');
		}
	});
	
	$(document).on('keyup keydown paste ','#toQty', function(e) {
		var qty=$(this).val();
		if(qty>=0)
		{
			swag(1);
		}
		else
		{
			$('#frmQty,#toQty').val('');
		}
	});

	function swag(type)
	{
		var frmQ=$('#frmQty').val();
		var toQ=$('#toQty').val();
		var rate=$(".curF").find("option:selected").attr('data-val');
		
		$('.calcInnerActive').removeClass('active');
		
		$('#coins'+toSymbol).find('.calcInnerActive').addClass('active');
		$('#coins'+frmSymbol).find('.calcInnerActive').addClass('active');
		
		var currSymbol=$(".curF").find("option:selected").attr('currency');
		if(type==0)
		{
			$('.toPrice').html(intlCurFmtr(frmQ*frmPrice*rate)+" "+currSymbol);
			var p=intlCurFmtr((frmPrice*frmQ)/(toPrice));
			if(p!==0)
			p=p.replace(/,/g, "");
			$('#toQty').val(p);
		}
		else
		{
			$('.toPrice').html(intlCurFmtr(toQ*toPrice*rate)+" "+currSymbol);
			
			var p=intlCurFmtr((toPrice*toQ)/(frmPrice));
			if(p!==0)
			p=p.replace(/,/g, "");
			$('#frmQty').val(p); 
		}
	}
	swag(0);
	
	$(document).on('change','.curF',function(){
		swag(0);
	});
	
	$(document).on('click','.calcOp',function(e){
		
		var img=$(this).attr('data-img');
		var symbol=$(this).attr('data-symbol');
		var price=$(this).attr('data-price');
		
		if(type==0)
		{
			$('.frmImg').attr('src',img);
			$('.frmSymbol').html(symbol);
			frmSymbol=symbol;
			frmPrice=intlCurFmtr(price).replace(/,/g, "");
			swag(0);
		}
		else
		{
			$('.toImg').attr('src',img);
			$('.toSymbol').html(symbol);
			toSymbol=symbol;
			toPrice=intlCurFmtr(price).replace(/,/g, "");
			swag(1);
		}
		$('.calca').addClass('hide');
		$('.maina').removeClass('hide');
	});
	
	
	$(document).on('click','.loadMore',function(e){
		e.preventDefault();
		if(processingRequest2==1)
		return false;
		processingRequest2=1;
		var page=$(this).val();
		$('.loadMore').hide();
		$('.spinnerLoad').removeClass('hide');
		var data=new FormData();
		data.append('page',page);
		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url()."calc_top_post";?>",
			data: data,
			cache: false,
			processData: false,
			contentType: false,
			success: function(result)
			{
				var responseData=$.parseJSON(result);
				var response=responseData['response'];
				if(response == 0)
				{
					alertBox('error','InValid Access occured');
				}
				else if(response == 1)
				{
					var result=responseData['responseHtml'];
					listCalc=listCalc+result;
					
					var html=$('.appender').html();
					$('.appender').remove();
					$('.appeCalc').append(result+'<div class="appender search__item loadmore cal_loadmore_marg"><button value="'+responseData['data']+'" type="button" class="loadMore"><?php echo showLangVal($activeLanguage,"load_more"); ?></button><div class="spinnerLoad hide"><img style="height:17px;width:17px;" src="<?php echo base_url()."assets/images/loader.svg"?>"></div></div>');
					$('.loadMore').val(responseData['data']);
						
				}
				$('.loadMore').show();
				$('.spinnerLoad').addClass('hide');
				processingRequest2=0;
			}
		});
	});
	
	
	var searchPanel=false;
	var processingRequest3=0;
	
	$(document).on('click','.search-crossPanel',function()
	{
		$('#queryPanel').val('');
		$('.appeCalc').html(listCalc);
		$('.search-spinnerPanel,.search-crossPanel').addClass('hide');
		$('.search-iconPanel').removeClass('hide');
		$('.loadmore').show();
		searchPanel=false;
	});
	
	function searchCallBack(){
		if(processingRequest3==1)
		return false;
	
		var data=new FormData();
		var searchValue=$('#queryPanel').val();
		searchValue=searchValue.replace(/\s+/g," ");
		
		if(searchValue.length==0)
		{
			$('.search-spinnerPanel,.search-crossPanel').addClass('hide');
			$('.search-iconPanel').removeClass('hide');
			$('.appeCalc').html(listCalc);
			$('.loadmore').show();
			processingRequest3=0;
			searchPanel=false;
			return false;
		}
		
		// searchValue=searchValue.trim().replace(/[^-\w\s]+/g, '');
		if(searchValue.length>0)
		{
			processingRequest3=1;
			data.append('query',searchValue);
			$.ajax({
					url:baseUrl+'search/calculator/post',
					type:"POST",
					contentType:false,
					data:data,
					cache:false,
					processData:false,
					beforeSend:function()
					{
						$('.search-crossPanel,.search-iconPanel').addClass('hide');
						$('.search-spinnerPanel').removeClass('hide');
						$('.loadmore').hide();
					},
					success:function(data)
					{
						if(data.length!=0)
						{
							if(searchValue.length!=0)
							{
								var responseData=$.parseJSON(data);
								var responseHtml=responseData['responseHtml'];
								$('.appeCalc').html(responseHtml);
								$('.search-spinnerPanel').addClass('hide');
								$('.search-crossPanel').removeClass('hide');
								searchPanel=true;
							}
							else
							{
								$('.search-spinnerPanel,.search-crossPanel').addClass('hide');
								$('.search-iconPanel').removeClass('hide');
								$('.appeCalc').html(listCalc);
								searchPanel=false;
								$('.loadmore').show();
							}
						}
						else
						{
							$('.search-spinnerPanel,.search-crossPanel').addClass('hide');
							$('.search-iconPanel').removeClass('hide');
							$('.appeCalc').html(listCalc);
							searchPanel=false;
							$('.loadmore').show();
						}
						processingRequest3=0;
					}
				});
		}
	}

	$('#queryPanel').donetyping(searchCallBack,500);	  
	 	$(document).on('keyup paste','#queryPanel', function() {
		searchCallBack();
		}).bind('paste', function () {
		searchCallBack();
	});


	
	</script>
</body>
</html>