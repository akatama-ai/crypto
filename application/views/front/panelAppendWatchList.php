<?php

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
						<span class="line__coin_change changeLive <?php echo $coin['changePercentage24Hour']>=0?"line__coin_change--green":"line__coin_change--red";?>" title="Price change for the last 24 hours."><i class="<?php echo $coin['changePercentage24Hour']>=0?"ti-arrow-up":"ti-arrow-down";?>"></i><?php echo round($coin['changePercentage24Hour'],2);?>%</span>
					</div>
				</span>
			</div>
			<div class="line__coin_graph_box">
				<div class="line__coin_graph state-visible">
					<div class="line__coin_graph_placeholder">
						<p>
							<span class="sparklines<?php echo $next;?>" sparkType="line" ><!-- <?php $priceSparks=$coins24Prices[$coin['symbol']];echo implode(',',$priceSparks);?> --></span>
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