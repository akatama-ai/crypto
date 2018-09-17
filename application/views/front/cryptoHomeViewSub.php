<div id="view1">
<?php 
$page=$page+1;
$totalCoins=$totalCoins-$next;
foreach($cryptos as $index=>$coin)
{?>
	<div id="respOn<?php echo $coin['symbol'];?>"  class="cropton-table-tr">
		<div class="hashTag"><?php echo $page++;
		//$sortByTypeOrig=="desc"?($page++):($totalCoins--);?></div>
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
<div id="view2">
<?php 
foreach($cryptos as $index=>$coin)
	{
		$coinPriceChange=$coin['price']*$activeCurrency['rate'];
		?>
		<div data-coins="<?php echo $coin['supply'];?>" data-id="<?php echo $coin['symbol'];?>" id="current<?php echo $coin['symbol'];?>" class="coinsSpread cropton-table-tr2">
			<div class="cropton-price"><span attrPrice="<?php echo $coin['price'];?>" class="priceLive"><span><?php echo $activeCurrency['symbol'];?></span> <?php echo intlCurFmtr($coinPriceChange);?></span></div>
			
			<div class="cropton-text-upDown volLive"><?php $volume24HourTo=$coin['volume24HourTo']>0?($coin['volume24HourTo']*$activeCurrency['rate']):$coin['volume24HourTo']*$activeCurrency['rate'];echo $activeCurrency['symbol']." ".intlCurFmtr($volume24HourTo);?></div>
			
			<div class="cropton-text-upDown capLive"><span><?php echo $activeCurrency['symbol'];?></span> <?php echo parseNumberPriceBase($coin['marketCap']*$activeCurrency['rate']);?></div>
			
			<div class="cropton-text-upDown supplyLive"><?php echo intlCurFmtr($coin['supply']);?></div>
			
			<div class="cropton-capSupply lowHighLive"><?php echo $activeCurrency['symbol'].intlCurFmtr($coin['highDay'])." / ".$activeCurrency['symbol'].intlCurFmtr($coin['lowDay']);?></div>
			
			<div class=" cropton-volume <?php $changePercentage24Hour=$coin['changePercentage24Hour'];echo $changePercentage24Hour>=0?"up":"down";?>"><span class="changeLive"><?php echo round($changePercentage24Hour,2);?>% <i class="<?php echo $changePercentage24Hour>=0?"ti-arrow-up":"ti-arrow-down";?>"></i></span>
				<p>
					<span class="sparklines<?php echo $next;?>" sparkType="line" sparkBarColor="<?php echo ($changePercentage24Hour>0?"green":"red")?>"> <!--<?php $priceSparks=$coins24Prices[$coin['symbol']];echo implode(',',$priceSparks);?>--></span>
				</p>
			</div>
			<div data-attr="<?php echo $coin['cryptoId']?>" class="addW cropton-watchlist"><a class="throw <?php echo in_array($coin['cryptoId'],$watchList)?'on':"off"?>"></a></div>
			
		</div>
	<?php } ?>
</div>
<div id="pag"><?php echo $links;?></div>