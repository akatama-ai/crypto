<!DOCTYPE html>
<html lang="en">
  <head>
   <?php $this->load->view("front/includes/head",['adPageHeader'=>$_ci_view]); ?>
   <style>
   .tab-content > .tab-pane {
	max-height: 181px;
	min-height: 242px;
}


   </style>
  </head>
<body>
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<button class="modal_cross" data-dismiss="modal"></button>
			
			<div class="watchlist_left">
				<div class="watchlist_left_under">
					<div class="watchlist_padd">
					
					<input autocomplete="off" id="queryPanel" placeholder="<?php echo showLangVal($activeLanguage,"search_coins_message"); ?>" class="watchlist_search_input" type="text">
						<div class="search-icon-main">
							<span class="search-iconPanel"></span>
							<span class="search-spinnerPanel hide"></span>
							<span class="search-crossPanel hide"><i class="ti-close"></i></span>
						</div>
					</div>
					
					<ul id="listWatch" class="search__items_box">
						<?php foreach($topCoinList as $index=>$coin){?>
						<li class="search__item">
							<div class="search__top">
								<a href="<?php echo base_url()."coin/".$coin['symbol'];?>"><img class="search__coin_img search__coin_img--white-bg" src="<?php echo strlen($coin['image'])>0?base_url()."assets/images/coins/".$coin['image']:"";?>" alt="<?php echo $coin['symbol'];?>"></a>
								
								<div class="search__coin_text">
									<a href="<?php echo base_url()."coin/".$coin['symbol'];?>"><h3 class="search__coin_title" title="<?php echo $coin['coinName'];?> - <?php echo $coin['symbol'];?>"><?php echo $coin['coinName'];?><span class="search__coin_ticker js-ticker"> <?php echo $coin['symbol'];?></span></h3></a>
								</div>
							</div>
							<button data-attr="<?php echo $coin['cryptoId'];?>"  class="<?php echo in_array($coin['cryptoId'],$watchList)?'on':"off"?> addWBtn search__add_btn search__add_btn--add js-add-line" ><?php echo in_array($coin['cryptoId'],$watchList)? showLangVal($activeLanguage,"added") : showLangVal($activeLanguage,"add"); ?></button>
						</li>
						<?php } ?>
						<li class="appender search__item loadmore">
							<button value="<?php echo $totalResults;?>" type="button" class="loadMore"><?php echo showLangVal($activeLanguage,"load_more"); ?></button>
							<div class="spinnerLoad hide"><img style="height:25px;width:25px" src="<?php echo base_url()."assets/images/loader.svg"?>"></div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal End -->
<div id="respondSearch" class="crypto-main-container">
	<?php $this->load->view("front/includes/header");
	$totalCoins=count($coinsInfo); ?>
		<span class="spinner"></span>
		<div id="sections">
		<?php if(($totalCoins)>0){?>
			<div id="remWatTitle" class="watchlist_title">
				<div class="add_to_watchlistcenter_text"><?php echo showLangVal($activeLanguage,"watchlist"); ?></div>
				<a class="add_to_watchlist_btn" data-toggle="modal" data-target="#myModal"><?php echo showLangVal($activeLanguage,"add_coins"); ?></a>
			</div>
		<?php } ?>
			<div class="container-fluid watchlist_container watchlist_container_padd">
				<div class="watchlist_area">
				<div id="watchList" class="line_row">
				<?php if($totalCoins>0){
				 foreach($coinsInfo as $index=>$coin){
					$coinPriceChange=$coin['price']*$activeCurrency['rate'];?>
					<div data-coins="<?php echo $coin['supply'];?>" data-id="<?php echo $coin['symbol'];?>" id="crypto<?php echo $coin['cryptoId'];?>" class="coinsSpread line crypto<?php echo $coin['symbol'];?>">
						<button value="<?php echo $coin['cryptoId'];?>" type="button" class="removeWatch line__remove js-remove-line"><span class="line__remove__tootip"><?php echo showLangVal($activeLanguage,"remove_from_watchlist"); ?></span></button>
						<div class="line__top">
							<div class="line__coin_box">
								<a href="<?php echo base_url()."coin/".$coin['symbol'];?>"><img class="line__coin_img js-coin-img " src="<?php echo strlen($coin['image'])>0?base_url()."assets/images/coins/".$coin['image']:"";?>" alt="<?php echo $coin['symbol'];?>"></a>
							</div>
							<div class="line__coin_text">
								<a href="<?php echo base_url()."coin/".$coin['symbol'];?>">
									<h3 class="line__coin_title">
										<span class="line__coin_name js-coin-title"><?php echo $coin['coinName'];?></span>
										<span class="line__coin_ticker js-coin-ticker-text"> (<?php echo $coin['symbol'];?>)</span>
									</h3>
								</a>
								
								<span class="line__coin_change_box">
									<div class="js-btc-box line__change_variant">
										<span class="priceLive pricePanelSmall" attrPrice="<?php echo $coin['price'];?>"><span><?php echo $activeCurrency['symbol'];?></span> <?php echo intlCurFmtr($coinPriceChange);?></span>
										<!--<span>&nbsp;<?php echo $coin['symbol'];?>&nbsp;</span>-->
										<span class="line__coin_change changeLive <?php echo $coin['changePercentage24Hour']>=0?"up":"down";?>" title="Price change for the last 24 hours."><i class="<?php echo $coin['changePercentage24Hour']>=0?"ti-arrow-up":"ti-arrow-down";?>"></i><?php echo round($coin['changePercentage24Hour'],3);?>%</span>
									</div>
								</span>
							</div>
							<div class="line__coin_graph_box">
								<div class="line__coin_graph state-visible">
									<div class="line__coin_graph_placeholder">
										<p>
											<span class="sparklines" sparkType="line" ><!-- <?php $priceSparks=$coins24Prices[$coin['symbol']];echo implode(',',$priceSparks);?> --></span>
										</p>
									</div>
								</div>
							</div>
						</div>
						<div class="line_details_area">
							<div class="line_details_colmns">
								<div class="line_details_colmns_first "><span><?php echo showLangVal($activeLanguage,"market_cap_short"); ?></span><br><?php echo $activeCurrency['symbol'];?><span class="capLive"><?php echo intlCurFmtr($coin['marketCap']*$activeCurrency['rate']);?></span></div>
								<div class="line_details_colmns_second"><span><?php echo showLangVal($activeLanguage,"low_slash_high_24h"); ?></span><br><span class="lowHighLive"><?php echo $activeCurrency['symbol']." ".intlCurFmtr($coin['low24Hour']*$activeCurrency['rate']);?> / <?php echo $activeCurrency['symbol']." ".intlCurFmtr($coin['high24Hour']*$activeCurrency['rate']);?></span></div>
								<div class="line_details_colmns_third"><span><?php echo showLangVal($activeLanguage,"volume_24h_short"); ?></span><br> <span class="volLive"><?php $volume24HourTo=$coin['volume24HourTo']*$activeCurrency['rate'];echo $activeCurrency['symbol']." ".intlCurFmtr($volume24HourTo)?></span></div>
								<div class="clearfix"></div>
							</div>
						</div><!-- .line_details_area -->
					</div>
					<?php } 
					if($totalDataWatchList>$totalCoins){?>
						<div class="loaderDivMain text-center">
							<button value="<?php echo $totalCoins;?>" type="button" class="loadMoreMain load_more_btn"><?php echo showLangVal($activeLanguage,"load_more"); ?></button>
							<div class="spinnerLoadMain watchlist_spinner hide"></div>
						</div>
					<?php } 
					} else {?>
					<div class="watchlist_empty_area">
							<div class="icon_image"></div>
							<div class="icon_title"><?php echo showLangVal($activeLanguage,"watchlist_no_coins_message"); ?></div>
							<div class="icon_dec"><?php echo showLangVal($activeLanguage,"watchlist_message"); ?> </div>
							<a class="add_to_watchlist" data-toggle="modal" data-target="#myModal"><?php echo showLangVal($activeLanguage,"add_coins"); ?></a>
							
						</div>
					<?php } ?>
					
					
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		
	</div>
	</div>
	<?php $this->load->view("front/includes/footer"); ?>
	<script type="text/javascript" src="<?php echo base_url()."assets/plugins/sparklines/sparkline.js"?>"></script>
	<script>
	var currencyRate="<?php echo $activeCurrency['rate'];?>";
		var symbol="<?php echo $activeCurrency['symbol'];?>";
	
	$(document).ready(function() {
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
		volume = element.find(".volLive");
		change = element.find(".changeLive");
		capital = element.find(".capLive");
		lowHighLive = element.find(".lowHighLive");
		price.removeClass('up').removeClass('down');
		currentPrice[pair]['CHANGE24HOUR'] = CCC.convertValueToDisplay(tsym, (currentPrice[pair]['PRICE'] - currentPrice[pair]['OPEN24HOUR']));
		currentPrice[pair]['CHANGE24HOURPCT'] = ((currentPrice[pair]['PRICE'] - currentPrice[pair]['OPEN24HOUR']) / currentPrice[pair]['OPEN24HOUR'] * 100);
		var chNew=currentPrice[pair]['CHANGE24HOURPCT'];
		
		if (chNew >= 0.0) { classMain="up"; classUD="ti-arrow-up";} else { classUD="ti-arrow-down";classMain="down";}
		$(change).removeClass('up').removeClass('down').addClass(classMain);
		$(change).html("<i class='"+classUD+"'></i>"+slag(chNew) + "%");
	
		var actPriceNew=slag(currentPrice[pair]['PRICE']*currencyRate);
		priceLiveNewFormat ="<span>"+currencySymbol+"</span> <span>"+(actPriceNew)+"</span>";
		previousprice = $(price).attr('attrPrice');
		
		price.attr('attrPrice',actPriceNew);
		price.html(priceLiveNewFormat);
		volume.html(currencySymbol+" "+slag(currentPrice[pair]['VOLUME24HOURTO']*currencyRate));
		var tcoins=$(element).attr('data-coins');
		capital.html(slag(tcoins*currentPrice[pair]['PRICE']*currencyRate)); 
		
		lowHighLive.html(currencySymbol+" "+slag(currentPrice[pair]['LOW24HOUR']*currencyRate) + " / " + currencySymbol+" "+slag(currentPrice[pair]['HIGH24HOUR']*currencyRate));
		if (actPriceNew !== previousprice) {
			_class = previousprice < actPriceNew ? 'up' : 'down';
			price.removeClass('up').removeClass('down').addClass(_class);
			setTimeout(function () {
				price.removeClass('up').removeClass('down');
			}, 200);
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
	
	var listWatch="";var processingRequest=0;var processingRequest2=0;var processingRequest3=0;var totalCoinsWatch=<?php echo $totalDataWatchList;?>;
	
	var listWatch=$('#listWatch').html();
	$('.sparklines').sparkline('html', { lineWidth:1,disableInteraction:true,spotColor:false,minSpotColor:false,maxSpotColor:false,width:'100%',lineColor:'<?php echo $nightMode?"#507ee3":"#f69f11";?>',height:38,fillColor:'<?php echo $nightMode?"#ccddff":"#0b0f24";?>'});
	$(document).on('click','.checkmate', function(e) {
		e.preventDefault();
		twttr.widgets.createTimeline(
		  {
			sourceType: "list",
			ownerScreenName: "TwitterDev",
			slug: "national-parks"
		  },
		 $(this)
		);
		
	});
	$(document).on('click','.addWBtn', function(e) {
		e.preventDefault();
		if(processingRequest==1)
		return false;
		var element=$(this);
		var type=element.hasClass('on')?0:1;
		var sym=element.attr('data-attr');
		sym=sym.trim().replace(/\s+/g,"");
		if(sym.length==0)
		{
			alertBox('error','InValid Access');
			return false;
		}
		if(sym.length>0)
		{
			element.html('<img style="height:15px;width:15px" src="<?php echo base_url()."assets/images/loader.svg"?>">');
			processingRequest=1;
			var data=new FormData();
			data.append('sym',sym);
			data.append('type',type);
			$.ajax({
					url:baseUrl+'manage/watch',
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
							if(type==1)
							{
								$(".addW[data-attr='"+sym+"'] >.throw").removeClass('on').removeClass('off').attr('class','on');
								element.removeClass('on').removeClass('off').addClass('on');
								element.html('Added');
								totalCoinsWatch++;
								
								if(totalCoinsWatch>1)
								{
									$('#watchList').prepend(responseHtml);
								}
								else
								{
									$('#sections').prepend('<div id="remWatTitle" class="watchlist_title"><div class="add_to_watchlistcenter_text"><?php echo showLangVal($activeLanguage,"watchlist"); ?></div><a class="add_to_watchlist_btn" data-toggle="modal" data-target="#myModal"><?php echo showLangVal($activeLanguage,"add_coins"); ?></a></div>');
									// $('#myModal').modal('toggle');
									$('#watchList').html(responseHtml);
								}
								var a='.sparklines'+responseData['data'];
								$(a).sparkline('html', { lineWidth:1,disableInteraction:true,spotColor:false,minSpotColor:false,maxSpotColor:false,width:'100%',lineColor:'<?php echo $nightMode?"#507ee3":"#f69f11";?>',height:38,fillColor:'<?php echo $nightMode?"#ccddff":"#0b0f24";?>'});
								makeItLive();
							}
							else
							{
								$(".addW[data-attr='"+sym+"'] >.throw").removeClass('on').removeClass('off').attr('class','off');
								
								element.removeClass('on').removeClass('off').addClass('off');
								element.html('Add');
								$('#crypto'+sym).remove();totalCoinsWatch--;
							}
							
							if(totalCoinsWatch==0)
							{
								// $('#myModal').modal('toggle');
								$('#remWatTitle').remove();
								$('#watchList').html('<div class="watchlist_empty_area"><div class="icon_image"></div><div class="icon_title"><?php echo showLangVal($activeLanguage,"watchlist_no_coins_message") ?></div><div class="icon_dec">Watch list comes with coins live stats </div><a class="add_to_watchlist" data-toggle="modal" data-target="#myModal"><?php echo showLangVal($activeLanguage,"add_coins"); ?></a></div>');
							}
						
						}
						
						processingRequest=0;
					}
				});
		}
	});
	$(document).on("click",".removeWatch",function() {
		var context = $(this);
		var alertContext = $.confirm({
			title: '<?php echo showLangVal($activeLanguage,"confirm") ?>',
			content: '<?php echo showLangVal($activeLanguage,"watchlist_coin_remove_warning"); ?>',
			theme: 'dark',
			buttons: {
				confirm: {
					text: 'Remove',
					btnClass: 'btn-green',
					action: function(){
						var sym = context.val();
						this.buttons.confirm.setText('<img style="height:15px;width:15px" src="<?php echo base_url()."assets/images/loader.svg"?>">');
						var c2=this.buttons.confirm;
						$.ajax ({
							type: 'POST',
							url:baseUrl+'manage/watch',
							data: {sym:sym,type:0},
							success: function(result) {
								var responseData=$.parseJSON(result);
								var response=responseData['response'];
								var responseHtml=responseData['responseHtml'];
								if(response==0)
								{	
									$.confirm({
									title: '<?php echo showLangVal($activeLanguage,"error"); ?>',
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
									title: '<?php echo showLangVal($activeLanguage,"success"); ?>',
									theme: 'dark',
									content: "<?php echo showLangVal($activeLanguage,"watchlist_coin_remove_success"); ?>",
									type: 'green',
									typeAnimated: true,
									buttons: {
										close: function () {
											$(".addW[data-attr='"+sym+"'] >.throw").removeClass('on').removeClass('off').attr('class','off');
											$(".addWBtn[data-attr='"+sym+"']").removeClass('on').removeClass('off').addClass('class','off');
											$(".addWBtn[data-attr='"+sym+"']").html('Add');
											$('#crypto'+sym).remove();
											totalCoinsWatch--;
											
											if(totalCoinsWatch==0)
											{
												// $('#myModal').modal('toggle');
												$('#remWatTitle').remove();
												$('#watchList').html('<div class="watchlist_empty_area"><div class="icon_image"></div><div class="icon_title"><?php echo showLangVal($activeLanguage,"watchlist_no_coins_message") ?></div><div class="icon_dec">Watch list comes with coins live stats </div><a class="add_to_watchlist" data-toggle="modal" data-target="#myModal"><?php echo showLangVal($activeLanguage,"add_coins"); ?></a></div>'+'<div class="clearfix"></div>');
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
					text: 'Cancel',
					action: function(){}
				}
			}
		});
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
			url: "<?php echo base_url()."watchList_top_post";?>",
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
					listWatch=listWatch+result;
					
					var html=$('.appender').html();
					$('.appender').remove();
					$('#listWatch').append(result+'<li class="appender search__item loadmore">'+html+'</li>');
					$('.loadMore').val(responseData['data']);
						
				}
				$('.loadMore').show();
				$('.spinnerLoad').addClass('hide');
				processingRequest2=0;
			}
		});
	});
	
	$(document).on('click','.loadMoreMain',function(e){
		e.preventDefault();
		if(processingRequest2==1)
		return false;
		processingRequest2=1;
		var page=$(this).val();
		$('.loadMoreMain').hide();
		$('.spinnerLoadMain').removeClass('hide');
		var data=new FormData();
		data.append('page',page);
		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url()."watchList_load_more_post";?>",
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
					$('.spinnerLoadMain').addClass('hide');
					$('.loadMoreMain').show();
				}
				else if(response == 1)
				{
					var result=responseData['responseHtml'];
					if(responseData['data']>=totalCoinsWatch)
					{
						$('.loaderDivMain').before(result);
						$('.loadMoreMain').val(responseData['data']);
						
						var a='.sparklines'+responseData['data'];
						$(a).sparkline('html', { lineWidth:1,disableInteraction:true,spotColor:false,minSpotColor:false,maxSpotColor:false,width:'100%',lineColor:'<?php echo $nightMode?"#507ee3":"#f69f11";?>',height:38,fillColor:'<?php echo $nightMode?"#ccddff":"#0b0f24";?>'});
						makeItLive();
						if(responseData['data']==totalCoinsWatch)
						$('.loadMoreMain').hide();
						$('.spinnerLoadMain').addClass('hide');
					}
				}
				processingRequest2=0;
			}
		});
	});

	var searchPanel=false;
	
	$(document).on('click','.search-crossPanel',function()
	{
		$('#queryPanel').val('');
		$('#listWatch').html(listWatch);
		$('.search-spinnerPanel,.search-crossPanel').addClass('hide');
		$('.search-iconPanel').removeClass('hide');
		$('.loadMore').show();
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
			$('#listWatch').html(listWatch);
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
					url:baseUrl+'search/watchList/post',
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
								$('#listWatch').html(responseHtml);
								$('.search-spinnerPanel').addClass('hide');
								$('.search-crossPanel').removeClass('hide');
								searchPanel=true;
							}
							else
							{
								$('.search-spinnerPanel,.search-crossPanel').addClass('hide');
								$('.search-iconPanel').removeClass('hide');
								$('#listWatch').html(listWatch);
								searchPanel=false;
								$('.loadMore').show();
							}
						}
						else
						{
							$('.search-spinnerPanel,.search-crossPanel').addClass('hide');
							$('.search-iconPanel').removeClass('hide');
							$('#listWatch').html(listWatch);
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
		searchCallBack();
		}).bind('paste', function () {
		searchCallBack();
	});

	$('#queryPanel').click(function() {
		  if(searchPanel)
		$('.appendDivSearch').removeClass('hide');
	  })
	}); 
	</script>
</body>
</html>


