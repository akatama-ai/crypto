<!DOCTYPE html>
<html lang="en">
  <head>
   <?php $this->load->view("front/includes/head",['adPageHeader'=>$_ci_view]); ?>
  </head>
<body>
<div id="respondSearch" class="crypto-main-container">
	<?php $this->load->view("front/includes/header"); ?>
		<span class="spinner"></span>
		<div id="modalEditPrice" class="modal fade modal_screen_center" role="dialog">
		<div class="modal-dialog add_portfolio_lg">
			<!-- Modal content-->
			<div class="modal-content">
				<button class="modal_cross" data-dismiss="modal"></button>
				<div class="watchlist_area">
					<div class="line_row">
						<div class="portfolio_add_area restore_portfolio">
							<div class="icon_title portfolio_title"><?php echo showLangVal($activeLanguage,"update_details"); ?></div>
							<div class="profile_name_label_input">
								<div class="profile_name_label"><?php echo $portfolio['coinName']." (".$portfolio['symbol'].")";?> <?php echo showLangVal($activeLanguage,"quantity"); ?></div>
								
								<div class="coin_details_container">
									<div class="coin_details_left_icon"><img src="<?php echo base_url()."assets/images/coins/".$portfolio['image'];?>" width="25" height="25"></div>
									<div class="coin_details_input"><input id="qty" class="form-control" name="amount" value="<?php echo $portfolio['qty'];?>" placeholder="0.00" type="number"></div>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="profile_name_label_input">
								<div class="profile_name_label"><?php echo showLangVal($activeLanguage,"description_optional"); ?></div>
								<textarea id="desc" class="coin_details_textarea" rows="4"><?php echo $portfolio['description'];?></textarea>
							</div>
							<input type="hidden" id="cryptoId" value="<?php echo $portfolio['cryptoId'];?>"/> 
							<div class="clearfix"></div>
							<a id="submitPortfolio" class="add_portofolio_btn" ><?php echo showLangVal($activeLanguage,"update"); ?></a>
							<div class="clearfix"></div>
						</div>
						<div class="clearfix"></div>
					</div>
					</div>
				</div>
			</div>
		</div>
		<div class="portfolio_area">
			<a href="<?php echo base_url()."portfolio"?>" class="back-button"></a>
			<a data-toggle="modal" data-target="#modalEditPrice" class="user-button edit_btn_er"></a>
			<img src="<?php echo base_url()."assets/images/coins/".$portfolio['image'];?>" class="coin_cover_img" width="45px" height="45px">
			<div class="portfolio_name">
				<?php echo $portfolio['coinName']." (".$portfolio['symbol'].")";?>
			</div>
			<?php $totalWorth=0.00;
				$curr=$activeCurrency['rate'];
				$totalWorth=$totalWorth+($portfolio['price']*$portfolio['qty']*$activeCurrency['rate']);?>
			<div attrWorth="<?php echo $totalWorth;?>" class="ttlWorth portfolio_price_total">
				<span class="currency_symbl">
					<?php echo $activeCurrency['symbol'];?>
				</span>
				<span><?php echo intlCurFmtr($totalWorth);?></span>
			</div>
			<?php $totalPercent=$portfolio['changePercentage24Hour'];?>
			<div data-change="<?php echo $totalPercent;?>" class="changeTotalLive  info__change <?php echo $totalPercent>=0?"green":"red"?>">
				<?php echo round($totalPercent,3);?>% <img src="<?php echo base_url()."assets/images/".($totalPercent>=0?"arrow_up.svg":"arrow_down.svg")?>">
			</div>
			<div class="cover__button">
				<a target="_blank" href="<?php echo strlen($portfolio['affiliateLink'])>0?$portfolio['affiliateLink']:$affiliateLink;?>" class="exchange_btn">
					<?php echo showLangVal($activeLanguage,"buy")." ".$portfolio['symbol']?>
				</a>
			</div>
			<div class="map_canvas">
				<span class="sparklines" sparkType="line" ><!-- <?php $priceSparks=$coins24Prices[$portfolio['symbol']];echo implode(',',$priceSparks);?> --></span>
			</div>
		</div>
		<div class="cover__button"><a href="<?php echo base_url()."coin/".$portfolio['symbol']?>"><?php echo showLangVal($activeLanguage,"price_history"); ?></a></div>
		<div class="profile_coin_detail">
			<div class="profile_coin_detail_row">
				<div class="profile_coin_detail_amount">
					<div class="profile_coin_detail_title"><?php echo showLangVal($activeLanguage,"quantity"); ?></div>
					<div data-qty="<?php echo $portfolio['qty']?>" class="qtyChnge profile_coin_detail_value">
						<?php echo $portfolio['qty']?> <span class="symbol"><?php echo $portfolio['symbol']?></span>
					</div>
				</div>
				<div class="profile_coin_separator"></div>
				<div class="profile_coin_detail_price">
					<div class="profile_coin_detail_title"><?php echo showLangVal($activeLanguage,"price")." ".$portfolio['symbol']?></div>
					<div attrPrice="<?php echo $portfolio['price'];?>" class="priceLiveq profile_coin_detail_value">
						<span class="symbol"><?php echo $activeCurrency['symbol'];?></span> <?php echo intlCurFmtr($portfolio['price']*$activeCurrency['rate']);?>
					</div>
				</div>
			</div>
			<div class="profile_coin_detail_row">
				<div class="profile_coin_detail_desc">
					<div class="profile_coin_detail_title"><?php echo showLangVal($activeLanguage,"description"); ?></div>
					<div class="profile_coin_detail_value">
						<span class="profile_coin_detail_nodesc"><?php echo strlen($portfolio['description'])>0?$portfolio['description']: showLangVal($activeLanguage,"no_description_found"); ?>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
		
	</div>
	<?php $this->load->view("front/includes/ad-show",['currentPage' => $_ci_view, "className" => "footer_add"]); ?>
	<?php $this->load->view("front/includes/footer"); ?>
	<script type="text/javascript" src="<?php echo base_url()."assets/plugins/sparklines/sparkline.js"?>"></script>
	<script>
		$(document).ready(function(){
			$('.sparklines').sparkline('html', { chartRangeMinX:.5,width:'100%',height:250,fillColor:'<?php echo $nightMode?"#5039b5":"#14182c";?>',disableInteraction:true,spotColor:false,minSpotColor:false,maxSpotColor:false,lineColor:'<?php echo $nightMode?"#507ee3":"#f69f11";?>',lineWidth:3,barColor: 'green'});
			
		var currencyRate="<?php echo $activeCurrency['rate'];?>";
		var currencySymbol="<?php echo $activeCurrency['symbol'];?>";
		var coinSymbol="<?php echo $portfolio['symbol'];?>";
	
		function formatNumber(e){return new Intl.NumberFormat('en-IN', { style:"decimal"}).format(e)}
		function slag(x) {
			if(isNaN(x)) return x;
			if(x < 99999) {
				return formatNumber(x);
			}
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
	
	var currentPrice = {};
		var socket = io.connect('https://streamer.cryptocompare.com/');
		var subscription = ['5~CCCAGG~'+coinSymbol+'~USD'];
		socket.emit('SubAdd', { subs: subscription });
	   
		socket.on("m", function(message) {
			var messageType = message.substring(0, message.indexOf("~"));
			var res = {};
			if (messageType == CCC.STATIC.TYPE.CURRENTAGG) {
				res = CCC.CURRENT.unpack(message);
				dataUnpack(res);
			} 
		});
		var dataUnpack = function(data) {
		
		if(data['FLAGS']==undefined)
		return false;
		var coin = data['FROMSYMBOL'];
		var to = data['TOSYMBOL'];
		var fsym = CCC.STATIC.CURRENCY.getSymbol(coin);
		var tsym = CCC.STATIC.CURRENCY.getSymbol(to);
		var pair = coin + to;
		if (!currentPrice.hasOwnProperty(pair)) {
			currentPrice[pair] = {};
		}
		for (var key in data) {
			currentPrice[pair][key] = data[key];
		}
		
		price = $(".priceLiveq");
		change =$(".changeTotalLive");
		qty=$('.qtyChnge').attr('data-qty');
		
		currentPrice[pair]['CHANGE24HOURPCT'] = ((currentPrice[pair]['PRICE'] - currentPrice[pair]['OPEN24HOUR']) / currentPrice[pair]['OPEN24HOUR'] * 100);
		var chNew=currentPrice[pair]['CHANGE24HOURPCT'];
		
		if (chNew >= 0.0) { classMain="up"; classUD="ti-arrow-up";} else { classUD="ti-arrow-down";classMain="down";}
		change.removeClass('up').removeClass('down').addClass(classMain);
		change.html("<i class='"+classUD+"'></i>"+slag(chNew) + "%");
		
		var actPriceNew=slag(currentPrice[pair]['PRICE']*currencyRate);
		var actPriceNewqty=currentPrice[pair]['PRICE']*currencyRate*qty;
		priceLiveNewFormat ='<span class="symbol">'+currencySymbol+'</span> '+(actPriceNew);
		previousprice = price.attr('attrPrice');
		price.attr('attrPrice',actPriceNew);
		price.html(priceLiveNewFormat);
		 
		var prevWorth=parseFloat($('.ttlWorth').attr('attrWorth'));
		var prevChnge=parseFloat($('.changeTotalLive').attr('data-change'));
		
		if(prevChnge != chNew)
		{
			if (chNew >= 0.0) { classMain="up"; classUD="ti-arrow-up";} else { classUD="ti-arrow-down";classMain="down";}
			$('.changeTotalLive').removeClass('up').removeClass('down').addClass(classMain);
			$('.changeTotalLive').html("<i class='"+classUD+"'></i>"+slag(chNew) + "%");
			$('.changeTotalLive').attr('data-change',chNew);
		}
		
		$('.ttlWorth').html('<span class="currency_symbl">'+currencySymbol+'</span> <span>'+slag(actPriceNewqty)+'</span>');
		$('.ttlWorth').attr('attrWorth',actPriceNewqty);
		
		if(prevWorth !== actPriceNewqty)
		{
			_class = prevWorth < actPriceNewqty ? 'up' : 'down';
			$('.ttlWorth').removeClass('up').removeClass('down').addClass(_class);
			setTimeout(function () {
				$('.ttlWorth').removeClass('up').removeClass('down');
			}, 200);
		}
		if (actPriceNew !== previousprice) {
			_class = previousprice < actPriceNew ? 'up' : 'down';
			$(price).removeClass('up').removeClass('down').addClass(_class);
			setTimeout(function () {
				$(price).removeClass('up').removeClass('down');
			}, 300);
		}
			
		};
	
	///////////////////////
		$(document).on('click','#submitPortfolio', function(e) {
			e.preventDefault();
			if(processingRequest==1)
			return false;
			var element=$(this);
			var qty=$('#qty').val();
			var desc=$('#desc').val();
			var cryptoId=$('#cryptoId').val();
			qty=qty.trim().replace(/\s+/g,"");
			desc=desc.trim().replace(/\s+/g,"");
			cryptoId=cryptoId.trim().replace(/\s+/g,"");
			if(qty<=0)
			{
				alertBox('error','<?php echo showLangVal($activeLanguage,"portfolio_add_coin_error"); ?>');
				return false;
			}
			if(cryptoId.length==0)
			{
				alertBox('error','Please complete form');
				return false;
			}
			element.html('<div class="btn_loader_div"><img src="<?php echo base_url()."assets/images/loader.svg"?>"></div>');
			processingRequest=1;
			var data=new FormData();
			data.append('qty',qty);
			data.append('desc',desc);
			data.append('cryptoId',cryptoId);
			$.ajax({
					url:baseUrl+'manage/edit/coins/portfolio',
					type:"POST",
					contentType:false,
					data:data,
					cache:false,
					processData:false,
					beforeSend:function()
					{
						
					},
					success:function(data)
					{
						var responseData=$.parseJSON(data);
						var response=responseData['response'];
						var responseHtml=responseData['responseHtml'];
						
						if(response == 0)
						{
							alertBox('error',responseHtml);
						}
						else if(response == 1)
						{
							alertBox('success',responseHtml);
							location.reload();
						}
						
						processingRequest=0;
					}
				});
			
		});
		});

		
		
	</script>
</body>
</html>