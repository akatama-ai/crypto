<!DOCTYPE html>
<html lang="en">
  <head>
   <?php $this->load->view("front/includes/head",['adPageHeader'=>$_ci_view]); ?>
  </head>
<body>
<div id="respondSearch" class="crypto-main-container">
	<?php $this->load->view("front/includes/header"); 
	$ch=count($topCoinList);if($ch>0){?>
	<div id="modalEditPrice" class="modal fade modal_screen_center" role="dialog">
			<div class="modal-dialog add_portfolio_lg">
			<!-- Modal content-->
			<div class="modal-content">
				<button class="modal_cross" data-dismiss="modal"></button>
				<div class="watchlist_area">
					<div class="line_row">
						<div class="portfolio_add_area restore_portfolio">
							<div id="editModalContent" class=" icon_title portfolio_title"><?php echo showLangVal($activeLanguage,"update_details"); ?></div>
							
						</div>
						<div class="clearfix"></div>
					</div>
					</div>
				</div>
			</div>
		</div>
	<div id="myModal" class="modal fade" role="dialog">
		  <div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
			<button data-dismiss="modal" class="modal_cross"></button>
				<div class="watchlist_left">
					<div id="swipeMenu" class="watchlist_left_under">
						<div class="watchlist_padd">
						<input autocomplete="off" id="queryPanel" placeholder="<?php echo showLangVal($activeLanguage,"search_coins_message"); ?>" class="watchlist_search_input" type="text">
							<div type="button" class="search-icon-main">
								<span class="search-iconPanel"></span>
								<span class="search-spinnerPanel hide"></span>
								<span class="search-crossPanel hide"><i class="ti-close"></i></span>
							</div>
						</div>
						<ul id="listPort" class="search__items_box">
							<?php foreach($topCoinList as $index=>$coin){?>
							<li class="search__item">
								<div class="search__top">
									<a href="<?php echo base_url()."coin/".$coin['symbol'];?>"><img class="search__coin_img search__coin_img--white-bg" src="<?php echo strlen($coin['image'])>0?base_url()."assets/images/coins/".$coin['image']:"";?>" alt="<?php echo $coin['symbol'];?>"></a>
									
									<div class="search__coin_text">
										<a href="<?php echo base_url()."coin/".$coin['symbol'];?>"><h3 class="search__coin_title" title="<?php echo $coin['coinName'];?> - <?php echo $coin['symbol'];?>"><?php echo $coin['coinName'];?><span class="search__coin_ticker js-ticker"> <?php echo $coin['symbol'];?></span></h3></a>
									</div>
								</div>
								<button  value="<?php echo $coin['cryptoId'];?>" data-img="<?php echo strlen($coin['image'])>0?base_url()."assets/images/coins/".$coin['image']:"";?>" data-name="<?php echo $coin['coinName'];?>" data-symbol="<?php echo $coin['symbol'];?>" data-attr="<?php echo $coin['cryptoId'];?>"  class="<?php echo in_array($coin['cryptoId'],$portfolioList)?'on delCoin':"off addPBtn"?>  profile_add_btn"><?php echo in_array($coin['cryptoId'],$portfolioList)? showLangVal($activeLanguage,"remove"): showLangVal($activeLanguage,"add"); ?></button>
								
							</li>
							<?php } ?>
							<li class="appender search__item loadmore">
								<button value="<?php echo $totalTopCoins;?>" type="button" class="loadMore"><?php echo showLangVal($activeLanguage,"load_more"); ?></button>
								<div class="spinnerLoad hide"><img src="<?php echo base_url()."assets/images/loader.svg"?>"></div>
							</li>
						</ul>
					</div>
				</div>
				</div>
			</div>
		</div>
		
	<?php } ?>
		<span class="spinner"></span>
		<?php $totalCoins=count($portfolio);if(count($portfolio)==0){?>
		<div class="portfolio_area">
			<div class="portfolio_name"><?php echo showLangVal($activeLanguage,"net_worth"); ?></div>
			<div class="portfolio_price_total"><span class="currency_symbl"><?php echo $activeCurrency['symbol'];?></span>000000<span class="currency_symbl">.00</span></div>
			<div class="info__change green">0% <img src="<?php echo base_url()."assets/images/arrow_up.svg"?>"></div>
			<div class="map_canvas"></div> 
		</div>
		<div class="portfolio_coins_area">
			<div class="yet_text"><?php echo showLangVal($activeLanguage,"portfolio_no_coins_message"); ?></div>
			<a data-toggle="modal" data-target="#<?php echo $ch>0?"myModal":"addPortfolioModal"?>" class="add_portofolio_btn add_coins"><?php echo showLangVal($activeLanguage,"add_coins"); ?></a>
		</div>
	
		<?php } else {?>
		<div class="portfolio_area">
			<div class="portfolio_name"><?php echo showLangVal($activeLanguage,"net_worth"); ?></div>
			<div class=" portfolio_price_total"><span class="currency_symbl"><?php echo $activeCurrency['symbol'];?></span>
			<?php $totalWorth=0.00;
			$curr=$activeCurrency['rate'];
			foreach($portfolio as $index=>$value)
			{
				$totalWorth=$totalWorth+($value['price']*$value['qty']*$activeCurrency['rate']);
			}?>
			<span attrWorth="<?php echo $totalWorth;?>" class="ttlWorth"><?php echo intlCurFmtr($totalWorth);?></span></div>
			<?php $totalPercent=array_sum(array_map(function($e) {return $e['changePercentage24Hour'];},$portfolio))/$totalCoins;?>
			<div data-change="<?php echo $totalPercent;?>" class="changeTotalLive info__change <?php echo $totalPercent >=0?"green":"red";?>"><?php echo round($totalPercent,3);?>% <img src="<?php echo base_url()."assets/images/".($totalPercent>=0?"arrow_up.svg":"arrow_down.svg")?>"></div>
			<div class="cover__button">
				<a data-toggle="modal" data-target="#myModal" class="p_add_btn"><?php echo showLangVal($activeLanguage,"add_coins"); ?></a>
			</div>
			<div class="map_canvas"><span class="sparklines" sparkType="line" ><!-- <?php 
			$finl=[]; 
			for($i=0;$i<15;$i++)
			{
				$max=0;
				foreach($coins24Prices as $index=>$value)
				{
					// $key=array_search($index,array_column($portfolio,'symbol'));
					// $qty=$portfolio[$key]['qty'];
					if(isset($value[$i]))
					{
						$maxs=isset($value[$i])?$value[$i]:0;
						if($max<$maxs)
						$max=$maxs;
					}
					// $max=$max+($maxs*$qty);
				}
				$finl[]=$max;
			} 
			echo implode(',',$finl);?> --></span></div>
		</div>
		<div class="container-fluid watchlist_container_padd portfolio_all">
		<div class="watchlist_area">
				<div id="portfolioList" class="line_row">
				<?php foreach($portfolio as $index=>$coin){
					$coinPriceChange=$coin['price']*$activeCurrency['rate']*$coin['qty'];?>
					<div data-qty="<?php echo $coin['qty']?>" data-coins="<?php echo $coin['supply'];?>" data-id="<?php echo $coin['symbol'];?>" id="crypto<?php echo $coin['cryptoId'];?>" class="coinsSpread line crypto<?php echo $coin['symbol'];?>">
						<button value="<?php echo $coin['cryptoId'];?>" type="button" class="delCoin line__remove js-remove-line"><span class="line__remove__tootip"><?php echo showLangVal($activeLanguage,"remove_from_portfolio"); ?></span></button>
						<div class="line__top portfolio_top">
							<div class="line__coin_box">
								<a href="<?php echo base_url()."portfolio/".$coin['symbol']?>"><img class="line__coin_img js-coin-img " src="<?php echo strlen($coin['image'])>0?base_url()."assets/images/coins/".$coin['image']:"";?>" alt="<?php echo $coin['symbol'];?>"></a>
							</div>
							<div class="line__coin_text">
								<h3 class="line__coin_title line_coin_title_large">
									<a href="<?php echo base_url()."portfolio/".$coin['symbol']?>">
									<span class="line__coin_name js-coin-title"><?php echo $coin['coinName'];?></span>
									<span class="line__coin_ticker js-coin-ticker-text"> (<?php echo $coin['symbol'];?>)</span>
									</a>
								</h3>
								<span class="line__coin_change_box">
									<div class="js-btc-box line__change_variant">
										<span class=" pricePanelSmall " ><span><?php echo $activeCurrency['symbol'];?></span> <span class="priceLiveq"> <?php echo intlCurFmtr($coinPriceChange);?></span></span>
										<!--<span>&nbsp;<?php echo $coin['symbol'];?>&nbsp;</span>-->
										<span class="line__coin_change changeLive <?php echo $coin['changePercentage24Hour']>=0?"up":"down";?>" title="Price change for the last 24 hours."><i class="<?php echo $coin['changePercentage24Hour']>=0?"ti-arrow-up":"ti-arrow-down";?>"></i><?php echo round($coin['changePercentage24Hour'],2);?>%</span>
									</div>
								</span>
								<div class="qty_portfolio">1 <?php echo $coin['symbol'];?> = <span attrChnge="<?php echo $coin['changePercentage24Hour'];?>" attrPrice="<?php echo $coin['price'];?>" class="qty_portolio_span priceLive"><?php echo $activeCurrency['symbol'].intlCurFmtr($coin['price']*$activeCurrency['rate'])?></span></div>
							</div>
							<div class="line__coin_graph_box">
								<div class="line__coin_graph state-visible">
									<div class="line__coin_graph_placeholder">
										<p><span class="sparklines3" sparkType="line" ><!-- <?php $priceSparks=$coins24Prices[$coin['symbol']];echo implode(',',$priceSparks);?> --></span></p>
									</div>
								</div>
							</div>
						</div>
						<div class="line_details_area qty_portfolio_mrg">
							<div class="line_details_colmns">
								<div class="line_details_colmns_first "><span><?php echo showLangVal($activeLanguage,"market_cap_short"); ?></span><br><?php echo $activeCurrency['symbol'];?> <span class="capLive"><?php echo intlCurFmtr($coin['marketCap']*$activeCurrency['rate']);?></span></div>
								<div class="line_details_colmns_second"><span><?php echo showLangVal($activeLanguage,"low_slash_high_24h"); ?></span><br><span class="lowHighLive"><?php echo $activeCurrency['symbol']." ".intlCurFmtr($coin['low24Hour']*$activeCurrency['rate']);?> / <?php echo $activeCurrency['symbol']." ".intlCurFmtr($coin['high24Hour']*$activeCurrency['rate']);?></span></div>
								<div class="line_details_colmns_third"><span><?php echo showLangVal($activeLanguage,"volume_24h_short"); ?></span><br> <span class="volLive"><?php $volume24HourTo=$coin['volume24HourTo']*$activeCurrency['rate'];echo $activeCurrency['symbol']." ".intlCurFmtr($volume24HourTo)?></span></div>
								<div class="clearfix"></div>
							</div>
						</div><!-- .line_details_area -->
						<div class="qty_show"><?php echo ($coin['qty'])." ".$coin['symbol'];?></div>
						<a data-img="<?php echo strlen($coin['image'])>0?base_url()."assets/images/coins/".$coin['image']:"";?>" data-desc="<?php echo $coin['description'];?>" data-qty="<?php echo $coin['qty'];?>" data-name="<?php echo $coin['coinName'];?>" data-symbol="<?php echo $coin['symbol'];?>" data-attr="<?php echo $coin['cryptoId'];?>"  class="portfolio_edit editPBtn"></a>
					</div>
					<?php }?>
				</div>
					
					<div class="clearfix"></div>
					
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
	
	<?php $this->load->view("front/includes/footer"); ?>
	<script type="text/javascript" src="<?php echo base_url()."assets/plugins/sparklines/sparkline.js"?>"></script>
	<script>
	var currencyRate="<?php echo $activeCurrency['rate'];?>";
	var symbol="<?php echo $activeCurrency['symbol'];?>";
	
	$(document).ready(function() {
		 
		<?php if(isset($this->session->user) && isset($_GET['redirectLogin'])){?>
			$('#myModal').modal();
		<?php }?>
		
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
	function makeItLive() { 
	var currentPrice = {};
		var socket = io.connect('https://streamer.cryptocompare.com/');
		var subscription = get_coinsSpread();
		socket.emit('SubAdd', { subs: subscription });
	   
		socket.on("m", function(message) {
			var messageType = message.substring(0, message.indexOf("~"));
			// console.log(message);
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
		
		var element = $('.crypto'+coin);
		price = element.find(".priceLive");
		priceq = element.find(".priceLiveq");
		volume = element.find(".volLive");
		change = element.find(".changeLive");
		capital = element.find(".capLive");
		lowHighLive = element.find(".lowHighLive");
		qty=element.attr('data-qty');
		
		currentPrice[pair]['CHANGE24HOUR'] = CCC.convertValueToDisplay(tsym, (currentPrice[pair]['PRICE'] - currentPrice[pair]['OPEN24HOUR']));
		currentPrice[pair]['CHANGE24HOURPCT'] = ((currentPrice[pair]['PRICE'] - currentPrice[pair]['OPEN24HOUR']) / currentPrice[pair]['OPEN24HOUR'] * 100);
		var chNew=currentPrice[pair]['CHANGE24HOURPCT'];
		
		if (chNew >= 0.0) { classMain="up"; classUD="ti-arrow-up";} else { classUD="ti-arrow-down";classMain="down";}
		$(change).removeClass('up').removeClass('down').addClass(classMain);
		$(change).html("<i class='"+classUD+"'></i>"+slag(chNew) + "%");
		
		var actPriceNew=(currentPrice[pair]['PRICE']*currencyRate);
		var actPriceNewqty=currentPrice[pair]['PRICE']*currencyRate*qty;
		priceLiveNewFormat ="<span>"+currencySymbol+"</span> <span>"+slag(actPriceNew)+"</span>";
		priceLiveNewFormatq =slag(actPriceNewqty);
		previousprice = $(price).attr('attrPrice');
		
		$(price).attr('attrPrice',actPriceNew);
		$(price).attr('attrChnge',chNew);
		$(price).html(priceLiveNewFormat);
		$(priceq).html(priceLiveNewFormatq);
		volume.html(currencySymbol+" "+slag(currentPrice[pair]['VOLUME24HOURTO']*currencyRate));
		var tcoins=$(element).attr('data-coins');
		$(capital).html(slag(tcoins*currentPrice[pair]['PRICE']*currencyRate)); 
		
		$(lowHighLive).html(currencySymbol+" "+slag(currentPrice[pair]['LOW24HOUR']*currencyRate) + " / " + currencySymbol+" "+slag(currentPrice[pair]['HIGH24HOUR']*currencyRate));
		
		var prevWorth=parseFloat($('.ttlWorth').attr('attrWorth'));
		var priceAdd=0.0;
		var chnge=0.0;
		var prevChnge=parseFloat($('.changeTotalLive').attr('data-change'));
		
		$('.coinsSpread').each(function() {
			var newPr=parseFloat($(this).find(".priceLive").attr('attrPrice'));
			priceAdd=priceAdd+(newPr*parseFloat($(this).attr('data-qty')));
			chnge=chnge+(parseFloat($(this).find(".priceLive").attr('attrChnge')));
		});
		
		if(prevChnge !== chnge)
		{
			if (chnge >= 0.0) { classMain="up"; classUD="ti-arrow-up";} else { classUD="ti-arrow-down";classMain="down";}
			$('.changeTotalLive').removeClass('up').removeClass('down').addClass(classMain);
			$('.changeTotalLive').html("<i class='"+classUD+"'></i>"+slag(chnge) + "%");
			$('.changeTotalLive').attr('data-change',chnge);
		}
		
		$('.ttlWorth').html(slag(priceAdd));
		$('.ttlWorth').attr('attrWorth',priceAdd);
		
		if(prevWorth !== priceAdd)
		{
			_class = prevWorth < priceAdd ? 'up' : 'down';
			$('.ttlWorth').removeClass('up').removeClass('down').addClass(_class);
			setTimeout(function () {
				$('.ttlWorth').removeClass('up').removeClass('down');
			}, 200);
		}
		if (actPriceNew != previousprice) {
			_class = previousprice < actPriceNew ? 'up' : 'down';
			$(price).removeClass('up').removeClass('down').addClass(_class);
			$(priceq).removeClass('up').removeClass('down').addClass(_class);
			setTimeout(function () {
				$(price).removeClass('up').removeClass('down');
				$(priceq).removeClass('up').removeClass('down');
			}, 300);
		}
			
		};
	}
	function get_coinsSpread() {
		var result = [];
		$('.coinsSpread').each(function() {
			result.push('5~CCCAGG~'+$(this).attr('data-id')+'~USD')
		});
		return result;
	}
	makeItLive();
	
	///////////////////////
	var langVars = [];
	langVars['add_details'] = '<?php echo showLangVal($activeLanguage,"add_details"); ?>';
	langVars['description_optional'] = '<?php echo showLangVal($activeLanguage,"description_optional"); ?>';
	langVars['add_coin'] = '<?php echo showLangVal($activeLanguage,"add_coin"); ?>';
	langVars['portfilio_coin_remove_warning'] = '<?php echo showLangVal($activeLanguage,"portfilio_coin_remove_warning"); ?>';
	langVars['remove'] = '<?php echo showLangVal($activeLanguage,"remove"); ?>';
	langVars['cancel'] = '<?php echo showLangVal($activeLanguage,"cancel"); ?>';
	langVars['confirm'] = '<?php echo showLangVal($activeLanguage,"confirm"); ?>';
	langVars['success'] = '<?php echo showLangVal($activeLanguage,"success"); ?>';
	langVars['portfilio_coin_remove_success'] = '<?php echo showLangVal($activeLanguage,"portfilio_coin_remove_success"); ?>';
	langVars['close'] = '<?php echo showLangVal($activeLanguage,"close"); ?>';
	langVars['error'] = '<?php echo showLangVal($activeLanguage,"error"); ?>';
	langVars['portfolio_add_coin_error'] = '<?php echo showLangVal($activeLanguage,"portfolio_add_coin_error"); ?>';
	langVars['update_coin'] = '<?php echo showLangVal($activeLanguage,"update_coin"); ?>';
	
	var processingRequest=0;var processingRequest3=0;
		
			var listPort=$('#listPort').html();
			$('.sparklines').sparkline('html', { chartRangeMinX:.5,width:'100%',height:250,fillColor:'<?php echo $nightMode?"#5039b5":"#14182c";?>' ,disableInteraction:true,spotColor:false,minSpotColor:false,maxSpotColor:false,lineColor:'<?php echo $nightMode?"#507ee3":"#f69f11";?>',lineWidth:3,barColor: 'green'});
			$('.sparklines3').sparkline('html', { lineWidth:1,disableInteraction:true,spotColor:false,minSpotColor:false,maxSpotColor:false,width:125,lineColor:'<?php echo $nightMode?"#507ee3":"#f69f11";?>',height:38,fillColor:'<?php echo $nightMode?"#ccddff":"#1a1f3a";?>'});
		
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
				url: "<?php echo base_url()."portfolioList_top_post";?>",
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
						alertBox('error',responseData['responseHtml']);
					}
					else if(response == 1)
					{
						var result=responseData['responseHtml'];
						listPort=listPort+result;
						var html=$('.appender').html();
						$('.appender').remove();
						$('#listPort').append(result+'<li class="appender search__item loadmore">'+html+'</li>');
						$('.loadMore').val(responseData['data']);
					}
					$('.loadMore').show();
					$('.spinnerLoad').addClass('hide');
					processingRequest2=0;
				}
			});
		});
		
	$(document).on("click",".delCoin",function() {
		var context = $(this);
		var alertContext = $.confirm({
			title: langVars['confirm'],
			content: langVars['portfilio_coin_remove_warning'],
			theme: 'dark',
			buttons: {
				confirm: {
					text: langVars['remove'],
					btnClass: 'btn-green',
					action: function(){
						var id = context.val();
						this.buttons.confirm.setText('Remove <img style="height:15px;width:15px"  src="<?php echo base_url()."assets/images/loader.svg"?>">'); 
						var c2=this.buttons.confirm;
						
						$.ajax ({
							type: 'POST',
							url: baseUrl+'manage/del/coins/portfolio',
							data: {id:id},
							success: function(result) {
								var responseData=$.parseJSON(result);
								var response=responseData['response'];
								var responseHtml=responseData['responseHtml'];
								if(response==0)
								{	
									$.confirm({
									title: langVars['error'],
									theme: 'dark',
									content: responseHtml,
									type: 'red',
									typeAnimated: true,
									buttons: {
										ok: function () {
											}
										}
									});
									c2.setText('Remove');
								}
								else if(response==1)
								{
									alertContext.close();
									$.confirm({
										title: langVars['success'],
										theme: 'dark',
										content: langVars['portfilio_coin_remove_success'],
										type: 'green',
										typeAnimated: true,
										buttons: {
											close: {
												text: langVars['close'],
												action: function () {
													location.reload();
												}
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
					text: langVars['cancel'],
					action: function(){}
				}
			}
		});
	});
		$(document).on('click','#submitPortfolioUp', function(e) {
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
					alertBox('error',langVars['portfolio_add_coin_error']);
					return false;
				}
				if(cryptoId.length==0)
				{
					alertBox('error','Please complete form');
					return false;
				}
				element.html('<img src="<?php echo base_url()."assets/images/loader.svg"?>">');
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
		var swipeMenuPrev="";
		$(document).on('click','.clearSwipeMenu',function(e){
			$('#myModal').removeClass('modal_screen_center').html(swipeMenuPrev);
		});
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
				alertBox('error',langVars['portfolio_add_coin_error']);
				return false;
			}
			if(cryptoId.length==0)
			{
				alertBox('error','Please complete form');
				return false;
			}
			element.html('<img src="<?php echo base_url()."assets/images/loader.svg"?>">');
			processingRequest=1;
			var data=new FormData();
			data.append('qty',qty);
			data.append('desc',desc);
			data.append('cryptoId',cryptoId);
			$.ajax({
					url:baseUrl+'manage/add/coins/portfolio',
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
		$(document).on('click','.addPBtn',function(e){
			e.preventDefault();
			swipeMenuPrev=$('#myModal').html();
			var cryptoId=$(this).attr('data-attr');
			var img=$(this).attr('data-img');
			var symbol=$(this).attr('data-symbol');
			var name=$(this).attr('data-name');
			name=name+" "+symbol;
			 
			// $('#addPortCoinsModal').modal();
			$('#myModal').addClass('modal_screen_center').html('<div class="modal-dialog add_portfolio_lg"><div class="modal-content"><button class="clearSwipeMenu modal_cross"></button><div class="watchlist_area"><div class="line_row"><div class="portfolio_add_area restore_portfolio"><a class="clearSwipeMenu back-button"></a><div class="icon_title portfolio_title">'+langVars['add_details']+'</div><div class="profile_name_label_input"><div id="addcoinName" class="profile_name_label">'+name+'</div><div class="coin_details_container"><div class="coin_details_left_icon"><img id="imgCoin" src="'+img+'" style="height:25px;width:25px;" alt="coin"></div><div class="coin_details_input"><input class="form-control" id="qty" name="qty" value="" placeholder="0.00" type="number"></div><input type="hidden" id="cryptoId" value="'+cryptoId+'"/></div></div><div class="clearfix"></div><div class="profile_name_label_input"><div class="profile_name_label">'+langVars['description_optional']+'</div><textarea id="desc" class="coin_details_textarea" rows="4"></textarea></div><div class="clearfix"></div><a id="submitPortfolio" class="add_portofolio_btn" href="#">'+langVars['add_coin']+'</a><div class="clearfix"></div></div><div class="clearfix"></div></div></div></div></div>');
					
		});
		$(document).on('click','.editPBtn',function(e){
			e.preventDefault();
			// swipeMenuPrev=$('#myModal').html();
			var cryptoId=$(this).attr('data-attr');
			var img=$(this).attr('data-img');
			var symbol=$(this).attr('data-symbol');
			var name=$(this).attr('data-name');
			var qty=$(this).attr('data-qty');
			var desc=$(this).attr('data-desc');
			name=name+" "+symbol;
			  
			// $('#addPortCoinsModal').modal();
			$('#editModalContent').html('<div class="icon_title portfolio_title">Edit details</div><div class="profile_name_label_input"><div id="addcoinName" class="profile_name_label">'+name+'</div><div class="coin_details_container"><div class="coin_details_left_icon"><img id="imgCoin" src="'+img+'" style="height:25px;width:25px;" alt="coin" ></div><div class="coin_details_input"><input class="form-control" id="qty" name="qty" value="'+qty+'" placeholder="0.00" type="number"></div><input type="hidden" id="cryptoId" value="'+cryptoId+'"/></div></div><div class="clearfix"></div><div class="profile_name_label_input"><div class="profile_name_label">Description (optional)</div><textarea id="desc" class="coin_details_textarea" rows="4">'+desc+'</textarea></div><div class="clearfix"></div><a id="submitPortfolioUp" class="add_portofolio_btn" href="#">'+langVars['update_coin']+'</a><div class="clearfix"></div>');
			$('#modalEditPrice').modal();
					
		});
		var searchPanel=false;
		
		$(document).on('click','.search-crossPanel',function()
		{
			$('#queryPanel').val('');
			$('#listPort').html(listPort);
			$('.search-spinnerPanel,.search-crossPanel').addClass('hide');
			$('.search-iconPanel').removeClass('hide');
			$('.loadMore').show();
			searchPanel=false;
		});
		
		function searchCallBack(listPort){
			
			if(processingRequest3==1)
			return false;
		
			var data=new FormData();
			var searchValue=$('#queryPanel').val();
			searchValue=searchValue.replace(/\s+/g," ");
			
			if(searchValue.length==0)
			{
				$('.search-spinnerPanel,.search-crossPanel').addClass('hide');
				$('.search-iconPanel').removeClass('hide');
				$('#listPort').html(listPort);
				$('.loadMore').show();
				searchPanel=false;
				return false;
			}
			
			// searchValue=searchValue.trim().replace(/[^-\w\s]+/g, '');
			if(searchValue.length>0)
			{
				processingRequest3=1;
				data.append('query',searchValue);
				$.ajax({
						url:baseUrl+'search/portfolio/post',
						type:"POST",
						contentType:false,
						data:data,
						cache:false,
						processData:false,
						beforeSend:function()
						{
							$('.search-crossPanel,.search-iconPanel').addClass('hide');
							$('.search-spinnerPanel').removeClass('hide');
							$('.loadMore').hide();
						},
						success:function(data)
						{
							if(data.length!=0)
							{
								if(searchValue.length!=0)
								{
									var responseData=$.parseJSON(data);
									var responseHtml=responseData['responseHtml'];
									$('#listPort').html(responseHtml);
									
									$('.search-spinnerPanel').addClass('hide');
									$('.search-crossPanel').removeClass('hide');
									searchPanel=true;
								}
								else
								{
									$('.search-spinnerPanel,.search-crossPanel').addClass('hide');
									$('.search-iconPanel').removeClass('hide');
									$('#listPort').html(listPort);
									searchPanel=false;
									$('.loadMore').show();
								}
							}
							else
							{
								$('.search-spinnerPanel,.search-crossPanel').addClass('hide');
								$('.search-iconPanel').removeClass('hide');
								$('#listPort').html(listPort);
								searchPanel=false;
								$('.loadMore').show();
							}
							processingRequest3=0;
						}
					});
			}
			else
			{
				$('.appendDivSearch').html('').addClass('hide');
			}
		}

		$('#queryPanel').donetyping(searchCallBack,500);	  
			$(document).on('keyup paste','#queryPanel', function() {
			searchCallBack(listPort);
			}).bind('paste', function () {
			searchCallBack(listPort);
		});

		$('#queryPanel').click(function() {
			  if(searchPanel)
			$('.appendDivSearch').removeClass('hide');
		  })
	});

	</script>
</body>
</html>