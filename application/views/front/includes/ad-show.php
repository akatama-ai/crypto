<?php 
if($ads['ad728x90Status']==1) {
	$display=false;
	$adsSet=['front/watchList'=>'displayOnWatchlistPage','front/portfolio'=>'displayOnPortfolioPage','front/portfolioCoinInfo'=>'displayOnPortfolioPage','front/contact_us'=>'displayOnContactPage','front/coinDetail'=>'displayOnCoinPage','front/home'=>'displayOnHomePage','front/movers'=>'displayOnMoversPage','front/pageLoader'=>'displayOnDynamicPages'];
	if(array_key_exists($currentPage,$adsSet)) {
		$index = $adsSet[$currentPage];
		if($ads[$index]==1) {
			?>
			<div class="<?php echo ($ads['ad728x90ResponsiveStatus'] != 1 ? "hidden-xs" : "")." ".$className;?>">
				<?php echo stripcslashes(html_entity_decode($ads['ad728x90'],ENT_QUOTES,"UTF-8"));?>
			</div>
			<?php
		}
	}
}?>