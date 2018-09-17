<!DOCTYPE html>
<html lang="en">
  <head>
  <?php $this->load->view("front/includes/head",['adPageHeader'=>$_ci_view]); ?>
  </head>
<body>
	<div id="respondSearch" class="crypto-main-container">
	<?php $this->load->view("front/includes/header"); ?>
		<span class="loadMoreAllHome"></span>
		<div id="sortTableUp" class="cropton-table">
			<div class="tr-basic">
				<div class="hashTag-with-icon">
					<div class="tr-head">
						<div class="cropton-table-tr theader-tr">
							<div class="hashTag">#</div>
							<div data-sort="name" data-sortType="<?php echo "coinName"==$sortByColumn?$orderShift:'desc';?>" class="sort cropton-name-area text-left">
								<?php echo showLangVal($activeLanguage,"coin"); ?>
							&nbsp;<i class=" <?php echo "coinName"==$sortByColumn?'ti-arrow-'.$sortByType:'ti-exchange-vertical';?> table_arrows_thead"></i>
							</div>
						</div>
					</div><!-- .tr-head -->
					<div id="view1">
						<?php foreach($cryptos as $index=>$coin)
						{?>
							<div id="respOn<?php echo $coin['symbol'];?>" class=" cropton-table-tr">
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
							
							<div data-sort="price" data-sortType="<?php echo "price"==$sortByColumn?$orderShift:'desc';?>" class="sort cropton-price thead-text-colo"><?php echo showLangVal($activeLanguage,"price"); ?>&nbsp;<i class=" <?php echo "price"==$sortByColumn?'ti-arrow-'.$sortByType:'ti-exchange-vertical';?> table_arrows_thead"></i></div>
							
							<div data-sort="vol" data-sortType="<?php echo "volume24HourTo"==$sortByColumn?$orderShift:'desc';?>" class="sort cropton-text-upDown thead-text-colo"><?php echo showLangVal($activeLanguage,"volume_slash_24h"); ?>&nbsp;<i class=" <?php echo "volume24HourTo"==$sortByColumn?'ti-arrow-'.$sortByType:'ti-exchange-vertical';?> table_arrows_thead"></i></div>
							
							<div data-sort="mkp" data-sortType="<?php echo "marketCap"==$sortByColumn?$orderShift:'desc';?>" class="sort cropton-text-upDown thead-text-colo"><?php echo showLangVal($activeLanguage,"market_cap"); ?>&nbsp;<i class=" <?php echo ("marketCap"==$sortByColumn?'ti-arrow-'.$sortByType:'ti-exchange-vertical');?> table_arrows_thead"></i></div>
							
							<div data-sort="coins" data-sortType="<?php echo "supply"==$sortByColumn?$orderShift:'desc';?>" class="sort cropton-text-upDown thead-text-colo"><?php echo showLangVal($activeLanguage,"coins"); ?>&nbsp;<i class=" <?php echo "supply"==$sortByColumn?'ti-arrow-'.$sortByType:'ti-exchange-vertical';?> table_arrows_thead"></i></div>
							
							<div data-sort="hl" data-sortType="<?php echo "highDay"==$sortByColumn?$orderShift:'desc';?>" class="sort cropton-capSupply thead-text-colo"><?php echo showLangVal($activeLanguage,"high_slash_low"); ?>&nbsp;<i class=" <?php echo "highDay"==$sortByColumn?'ti-arrow-'.$sortByType:'ti-exchange-vertical';?> table_arrows_thead"></i></div>
							
							<div data-sort="ch24" data-sortType="<?php echo "changePercentage24Hour"==$sortByColumn?$orderShift:'desc';?>" class="sort cropton-volume thead-text-colo"><?php echo showLangVal($activeLanguage,"change24h"); ?>&nbsp;<i class=" <?php echo "changePercentage24Hour"==$sortByColumn?'ti-arrow-'.$sortByType:'ti-exchange-vertical';?> table_arrows_thead"></i></div>
							
							<div class="cropton-watchlist thead-text-colo"><?php echo showLangVal($activeLanguage,"watch"); ?> &nbsp;</div>
						</div>
					</div><!-- .tr-head -->
					<div id="view2">
						<?php foreach($cryptos as $index=>$coin)
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
										<span class="sparklines" sparkType="line" sparkBarColor="<?php echo ($changePercentage24Hour>0?"green":"red")?>"><!-- <?php $priceSparks=$coins24Prices[$coin['symbol']];echo implode(',',$priceSparks);?>--></span>
									</p>
								</div>
								
								<div data-attr="<?php echo $coin['cryptoId']?>" class="addW cropton-watchlist"><a class="throw <?php echo in_array($coin['cryptoId'],$watchList)?'on':"off"?>"></a></div>
								
							</div>
						<?php } ?>
						
					</div>
					<?php $actualCombinations=['coinName'=>'name','price'=>'price','supply'=>'coins','volume24HourTo'=>'vol','marketCap'=>'mkp','changePercentage24Hour'=>'ch24','highDay'=>'hl'];?>
					<input type="hidden" id="sortO" value="<?php echo $sortByTypeOrig;?>"/>
					<input type="hidden" id="sortC" value="<?php echo $actualCombinations[$sortByColumn];?>"/>
				</div>
			</div>
			<div class="paggination-area">
				<div class="container-fluid">
					<div id="pag" class="paggination-main">
						<?php echo $links;?>
					</div>
				</div><!-- .container-fluid -->
			</div><!-- .paggination-area -->
		</div><!-- .cropton-table -->
	</div>
	
	<?php 
	$this->load->view("front/includes/ad-show",['currentPage' => $_ci_view, "className" => "footer_add"]);
	$this->load->view("front/includes/footer"); 
	?>
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
		var aa='#current'+coin;
		var bb='#respOn'+coin;
		var element = $(aa);
		price = element.find(".priceLive");
		volume = element.find(".volLive");
		change = element.find(".changeLive");
		capital = element.find(".capLive");
		lowHighLive = element.find(".lowHighLive");
		
		currentPrice[pair]['CHANGE24HOUR'] = CCC.convertValueToDisplay(tsym, (currentPrice[pair]['PRICE'] - currentPrice[pair]['OPEN24HOUR']));
		currentPrice[pair]['CHANGE24HOURPCT'] = slag(((currentPrice[pair]['PRICE'] - currentPrice[pair]['OPEN24HOUR']) / currentPrice[pair]['OPEN24HOUR'] * 100));
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
	$(document).on('click','.sort',function(){
		var st=$(this).attr('data-sort');
		var sortType=$(this).attr('data-sortType');
		$('#sortTableUp').css({opacity:'0.5'});
		if(st.length==0)
		return false;
		var formData=new FormData();
		formData.append('sort',st);
		formData.append('sortType',sortType);
		$.ajax({
				type: "POST",
				url: "<?php echo base_url()."sortHome";?>",
				data: formData,
				cache: false,
				processData: false,
				contentType: false,
				success: function(result)
				{
					var responseData=$.parseJSON(result);
					var response=responseData['response'];
					if(response == 0)
					{
						alert('InValid Access occured');
					}
					else if(response == 1)
					{
						var result=responseData['responseHtml'];
						$('#sortTableUp').html(result);
						$('.sparklines').sparkline('html', { lineWidth:1,disableInteraction:true,spotColor:false,minSpotColor:false,maxSpotColor:false,width:125,lineColor:'<?php echo $nightMode?"#507ee3":"#f69f11";?>',height:22,fillColor:'<?php echo $nightMode?"#ccddff":"#171c36";?>'});
						$('#sortTableUp').css({opacity:'1'});
					}
					$('.loadMoreAllHome').show();
				}
			});
		
	});
	$('.sparklines').sparkline('html', { lineWidth:1,disableInteraction:true,spotColor:false,minSpotColor:false,maxSpotColor:false,width:'100%',lineColor:'<?php echo $nightMode?"#507ee3":"#f69f11";?>',height:22,fillColor:'<?php echo $nightMode?"#ccddff":"#171c36";?>'});
	$(document).on('click',".ajax_send",function(){
		var val=$(this).attr('value');
		var sortO=$('#sortO').val();
		var sortC=$('#sortC').val();
		$('.spinner').removeClass('hide');
		$.ajax({
				url : "<?php echo base_url("coins-list-post"); ?>",
				type: "post",
				data: {"page":val,"sor":sortO,"sortC":sortC},
				success: function(result)
				{
					var responseData=$.parseJSON(result);
					var response=responseData['response'];
					if(response == 0)
					{
						alert('InValid Access occured');
					}
					else if(response == 1)
					{
						var result=responseData['responseHtml'];
						var view1=$(result).filter('#view1').html();
						var view2=$(result).filter('#view2').html();
						var pag=$(result).filter('#pag').html();
						
						$('#view1').html(view1);
						$('#view2').html(view2);
						$('#pag').html(pag);
						// $('.loadMore').val(responseData['data']);
						var a='.sparklines'+responseData['data'];
						$(a).sparkline('html', { lineWidth:1,disableInteraction:true,spotColor:false,minSpotColor:false,maxSpotColor:false,width:'100%',lineColor:'<?php echo $nightMode?"#507ee3":"#f69f11";?>',height:22,fillColor:'<?php echo $nightMode?"#ccddff":"#171c36";?>'});	
						makeItLive();							
					}
					$('.spinner').addClass('hide');
					$('html, body').animate({
						scrollTop: $("#respondSearch").offset().top
					}, 300);
				},
			});
		}); 
	}); 
	</script>
</body>
</html>


