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
					<div class="hashTag"><?php 
					echo $index+1;
					//$sortByTypeOrig=="desc"?($index+1):($totalCoins--);?></div>
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