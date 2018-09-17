<?php 
foreach($topCoinList as $index=>$coin){?>
	<li class="search__item">
		<div class="search__top">
			<a href="<?php echo base_url()."coin/".$coin['symbol'];?>"><img class="search__coin_img search__coin_img--white-bg" src="<?php echo strlen($coin['image'])>0?base_url()."assets/images/coins/".$coin['image']:"";?>" alt="<?php echo $coin['symbol'];?>"></a>
			
			<div class="search__coin_text">
				<a href="<?php echo base_url()."coin/".$coin['symbol'];?>"><h3 class="search__coin_title" title="<?php echo $coin['coinName'];?> - <?php echo $coin['symbol'];?>"><?php echo $coin['coinName'];?><span class="search__coin_ticker js-ticker"> <?php echo $coin['symbol'];?></span></h3></a>
			</div>
		</div>
		<button value="<?php echo $coin['cryptoId'];?>" data-img="<?php echo strlen($coin['image'])>0?base_url()."assets/images/coins/".$coin['image']:"";?>" data-symbol="<?php echo $coin['symbol'];?>" data-attr="<?php echo $coin['cryptoId'];?>"  class="<?php echo in_array($coin['cryptoId'],$portfolioList)?'on delCoin':"addPBtn off"?>  profile_add_btn js-add-line" ><?php echo in_array($coin['cryptoId'],$portfolioList)?'Remove':"Add"?></button>
	</li>
<?php } ?>