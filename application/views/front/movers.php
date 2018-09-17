<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view("front/includes/head",['adPageHeader'=>$_ci_view]); ?>
  </head>
<body>
	<div id="respondSearch" class="crypto-main-container">
	<?php $this->load->view("front/includes/header"); ?>
		<span class="spinner"></span>
		<div class="cropton_table_GainerTitle"><?php echo showLangVal($activeLanguage,"biggest"); ?> <span class="gainer"><?php echo showLangVal($activeLanguage,"gainers"); ?></span></div>
		<div class="cropton-table">
			<div class="tr-basic">
				<div class="hashTag-with-icon">
					<div class="tr-head">
						<div class="cropton-table-tr theader-tr">
							<div class="hashTag">#</div>
							<div class="cropton-name-area text-left">
								<?php echo showLangVal($activeLanguage,"coin"); ?>
							&nbsp;
							</div>
						</div>
					</div><!-- .tr-head -->
					<div>
						<?php foreach($gainers as $index=>$coin)
						{?>
							<div id="respOn<?php echo $coin['symbol'];?>"  class="cropton-table-tr">
								<div class="hashTag"><?php echo $index+1;?></div>
								<div class="cropton-name-area">
									<a href="<?php echo base_url()."coin/".$coin['symbol'];?>" class="cropton-icon"><img src="<?php echo base_url()."assets/images/coins/".$coin['image'];?>" class="img-responsive" /></a>
									<div class="cropton-icon-name">
										<a href="<?php echo base_url()."coin/".$coin['symbol'];?>"><?php echo $coin['coinName'];?></a>
										<p><?php echo $coin['symbol'];?></p>
									</div>
								</div>
							</div>
					<?php } ?>
					</div>
				</div>
				<div class="cropton-table-right">
					<div class="tr-head">
						<div class="cropton-table-tr2 theader-tr">
							<div class="cropton-price thead-text-colo"><?php echo showLangVal($activeLanguage,"price"); ?>&nbsp;</div>
							
							<div class="cropton-text-upDown thead-text-colo"><?php echo showLangVal($activeLanguage,"volume_slash_24h"); ?>&nbsp;</div>
							
							<div class="cropton-text-upDown thead-text-colo"><?php echo showLangVal($activeLanguage,"market_cap"); ?>&nbsp;</div>
							
							<div class="cropton-text-upDown thead-text-colo"><?php echo showLangVal($activeLanguage,"coins"); ?>&nbsp;</div>
							
							<div class="cropton-capSupply thead-text-colo"><?php echo showLangVal($activeLanguage,"high_slash_low"); ?>&nbsp;</div>
							
							<div class="cropton-volume thead-text-colo"><?php echo showLangVal($activeLanguage,"change24h"); ?>&nbsp;</div>
							
							<div class="cropton-watchlist thead-text-colo"><?php echo showLangVal($activeLanguage,"watch"); ?> &nbsp;</div>
						</div>
					</div><!-- .tr-head -->
					<div id="view2">
						<?php foreach($gainers as $index=>$coin)
						{
							$coinPriceChange=$coin['price']*$activeCurrency['rate'];?>
							<div data-coins="<?php echo $coin['supply'];?>" data-id="<?php echo $coin['symbol'];?>" id="current<?php echo $coin['symbol'];?>" class="coinsSpread cropton-table-tr2">
								
								<div class="cropton-price"><span attrPrice="<?php echo $coin['price'];?>" class="priceLive"><span><?php echo $activeCurrency['symbol'];?></span> <?php echo intlCurFmtr($coinPriceChange);?></span></div>
								
								<div class="cropton-text-upDown volLive"><?php $volume24HourTo=$coin['volume24HourTo']>0?($coin['volume24HourTo']*$activeCurrency['rate']):$coin['volume24HourTo']*$activeCurrency['rate'];echo $activeCurrency['symbol']." ".intlCurFmtr($volume24HourTo);?></div>
								
								<div class="cropton-text-upDown capLive"><span><?php echo $activeCurrency['symbol'];?></span> <?php echo parseNumberPriceBase($coin['marketCap']*$activeCurrency['rate']);?></div>
								
								<div class="cropton-text-upDown supplyLive"><?php echo intlCurFmtr($coin['supply']);?></div>
								
								<div class="cropton-capSupply lowHighLive"><?php echo $activeCurrency['symbol'].intlCurFmtr($coin['highDay'])." / ".$activeCurrency['symbol'].intlCurFmtr($coin['lowDay']);?></div>
								
								<div class=" cropton-volume <?php $changePercentage24Hour=$coin['changePercentage24Hour'];echo $changePercentage24Hour>=0?"up":"down";?>"><span class="changeLive"><?php echo round($changePercentage24Hour,2);?>% <i class="<?php echo $changePercentage24Hour>=0?"ti-arrow-up":"ti-arrow-down";?>"></i></span>
									<p>
										<span class="sparklines" sparkType="line" sparkBarColor="<?php echo ($changePercentage24Hour>0?"green":"red")?>"> <!--<?php $priceSparks=$coins24Prices[$coin['symbol']];echo implode(',',$priceSparks);?>--></span>
									</p>
								</div>
								
								<div data-attr="<?php echo $coin['cryptoId']?>" class="addW cropton-watchlist"><a class="throw <?php echo in_array($coin['cryptoId'],$watchList)?'on':"off"?>"></a></div>
								
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
			
		</div><!-- .cropton-table -->
		<?php $this->load->view("front/includes/ad-show",['currentPage' => $_ci_view, "className" => "movers_center_add"]); ?>
		<div class="cropton_table_GainerTitle"><?php echo showLangVal($activeLanguage,"biggest"); ?> <span class="looser"><?php echo showLangVal($activeLanguage,"losers"); ?></span></div>
		<div class="cropton-table">
			<div class="tr-basic">
				<div class="hashTag-with-icon">
					<div class="tr-head">
						<div class="cropton-table-tr theader-tr">
							<div class="hashTag">#</div>
							<div class="cropton-name-area text-left">
								<?php echo showLangVal($activeLanguage,"coin"); ?>
							&nbsp;
							</div>
						</div>
					</div><!-- .tr-head -->
					<div>
						<?php foreach($losers as $index=>$coin)
						{?>
							<div id="respOn<?php echo $coin['symbol'];?>"  class="cropton-table-tr">
								<div class="hashTag"><?php echo $index+1;?></div>
								<div class="cropton-name-area">
									<a href="<?php echo base_url()."coin/".$coin['symbol'];?>" class="cropton-icon"><img src="<?php echo base_url()."assets/images/coins/".$coin['image'];?>" class="img-responsive" /></a>
									<div class="cropton-icon-name">
										<a href="<?php echo base_url()."coin/".$coin['symbol'];?>"><?php echo $coin['coinName'];?></a>
										<p><?php echo $coin['symbol'];?></p>
									</div>
								</div>
							</div>
					<?php } ?>
					</div>
				</div>
				<div class="cropton-table-right">
					<div class="tr-head">
						<div class="cropton-table-tr2 theader-tr">
							<div class="cropton-price thead-text-colo"><?php echo showLangVal($activeLanguage,"price"); ?>&nbsp;</div>
							
							<div class="cropton-text-upDown thead-text-colo"><?php echo showLangVal($activeLanguage,"volume_slash_24h"); ?>&nbsp;</div>
							
							<div class="cropton-text-upDown thead-text-colo"><?php echo showLangVal($activeLanguage,"market_cap"); ?>&nbsp;</div>
							
							<div class="cropton-text-upDown thead-text-colo"><?php echo showLangVal($activeLanguage,"coins"); ?>&nbsp;</div>
							
							<div class="cropton-capSupply thead-text-colo"><?php echo showLangVal($activeLanguage,"high_slash_low"); ?>&nbsp;</div>
							
							<div class="cropton-volume thead-text-colo"><?php echo showLangVal($activeLanguage,"change24h"); ?>&nbsp;</div>
							
							<div class="cropton-watchlist thead-text-colo"><?php echo showLangVal($activeLanguage,"watch"); ?> &nbsp;</div>
						</div>
					</div><!-- .tr-head -->
					<div id="view2">
						<?php foreach($losers as $index=>$coin)
						{
							$coinPriceChange=$coin['price']*$activeCurrency['rate'];?>
							<div data-coins="<?php echo $coin['supply'];?>" data-id="<?php echo $coin['symbol'];?>" id="current<?php echo $coin['symbol'];?>" class="coinsSpread cropton-table-tr2">
								
								<div class="cropton-price"><span attrPrice="<?php echo $coin['price'];?>" class="priceLive"><span><?php echo $activeCurrency['symbol'];?></span> <?php echo intlCurFmtr($coinPriceChange);?></span></div>
								
								<div class="cropton-text-upDown volLive"><?php $volume24HourTo=$coin['volume24HourTo']>0?($coin['volume24HourTo']*$activeCurrency['rate']):$coin['volume24HourTo']*$activeCurrency['rate'];echo $activeCurrency['symbol']." ".intlCurFmtr($volume24HourTo);?></div>
								
								<div class="cropton-text-upDown capLive"><span><?php echo $activeCurrency['symbol'];?></span> <?php echo parseNumberPriceBase($coin['marketCap']*$activeCurrency['rate']);?></div>
								
								<div class="cropton-text-upDown supplyLive"><?php echo intlCurFmtr($coin['supply']);?></div>
								
								<div class="cropton-capSupply lowHighLive"><?php echo $activeCurrency['symbol'].intlCurFmtr($coin['highDay'])." / ".$activeCurrency['symbol'].intlCurFmtr($coin['lowDay']);?></div>
								
								<div class=" cropton-volume <?php $changePercentage24Hour=$coin['changePercentage24Hour'];echo $changePercentage24Hour>=0?"up":"down";?>"><span class="changeLive"><?php echo round($changePercentage24Hour,2);?>% <i class="<?php echo $changePercentage24Hour>=0?"ti-arrow-up":"ti-arrow-down";?>"></i></span>
									<p>
										<span class="sparklines" sparkType="line" sparkBarColor="<?php echo ($changePercentage24Hour>0?"green":"red")?>"> <!--<?php $priceSparks=$coins24Prices[$coin['symbol']];echo implode(',',$priceSparks);?>--></span>
									</p>
								</div>
								
								<div data-attr="<?php echo $coin['cryptoId']?>" class="addW cropton-watchlist"><a class="throw <?php echo in_array($coin['cryptoId'],$watchList)?'on':"off"?>"></a></div>
								
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
			
		</div><!-- .cropton-table -->
	</div>
	
	<?php $this->load->view("front/includes/ad-show",['currentPage' => $_ci_view, "className" => "movers_center_add"]); ?>
	
	<?php $this->load->view("front/includes/footer"); ?>
	<script type="text/javascript" src="<?php echo base_url()."assets/plugins/sparklines/sparkline.js"?>"></script>
	<script>
	$(document).ready(function() {
		$('.sparklines').sparkline('html', { lineWidth:1,disableInteraction:true,spotColor:false,minSpotColor:false,maxSpotColor:false,width:'100%',lineColor:'<?php echo $nightMode?"#507ee3":"#f69f11";?>',height:22,fillColor:'<?php echo $nightMode?"#ccddff":"#171c36";?>'});
		var currencyRate="<?php echo $activeCurrency['rate'];?>";
		var symbol="<?php echo $activeCurrency['symbol'];?>";
	
	
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
		var aa='#current'+coin;
		var bb='#respOn'+coin;
		var element = $(aa);
		price = element.find(".priceLive");
		volume = element.find(".volLive");
		change = element.find(".changeLive");
		capital = element.find(".capLive");
		lowHighLive = element.find(".lowHighLive");
			
		currentPrice[pair]['CHANGE24HOUR'] = CCC.convertValueToDisplay(tsym, (currentPrice[pair]['PRICE'] - currentPrice[pair]['OPEN24HOUR']));
		currentPrice[pair]['CHANGE24HOURPCT'] = slag((currentPrice[pair]['PRICE'] - currentPrice[pair]['OPEN24HOUR']) / currentPrice[pair]['OPEN24HOUR'] * 100);
		var chNew=currentPrice[pair]['CHANGE24HOURPCT'];
		if (chNew >= 0.0) { classMain="up"; classUD="ti-arrow-up";} else { classUD="ti-arrow-down";classMain="down";}
		$(change).parent().removeClass('up').removeClass('down').addClass(classMain);
		$(change).html(chNew + "%" + "<i class='"+classUD+"'></i>");
		
		var actPriceNew=slag(currentPrice[pair]['PRICE']*currencyRate);
		priceLiveNewFormat ="<span>"+currencySymbol+"</span> <span>"+actPriceNew+"</span>";
		previousprice =$(price).attr('attrPrice');
		
		$(price).attr('attrPrice',actPriceNew);
		
		$(price).html(priceLiveNewFormat); 
		$(volume).html(currencySymbol+" "+slag((currentPrice[pair]['VOLUME24HOURTO']*currencyRate)) );
		var tcoins=$(element).attr('data-coins');
		$(capital).html(currencySymbol+" "+slag(tcoins*currentPrice[pair]['PRICE']*currencyRate)); 
		
		$(lowHighLive).html(currencySymbol+" "+slag(currentPrice[pair]['LOW24HOUR']*currencyRate) + " / " + currencySymbol+" "+slag(currentPrice[pair]['HIGH24HOUR']*currencyRate));
		
		if (actPriceNew != previousprice) {
			_class = previousprice < actPriceNew ? 'statusGreenLive' : 'statusRedLive';
			$(aa+","+bb).removeClass('statusGreenLive').removeClass('statusRedLive').addClass(_class);
			setTimeout(function () {
				$(aa+","+bb).removeClass('statusGreenLive').removeClass('statusRedLive').removeClass('statusGreenLive statusRedLive');
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
	
	}); 
	</script>
</body>
</html>