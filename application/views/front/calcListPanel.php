<?php 
if(count($coins)!=0){
foreach($coins as $index=>$value){?>
	<div id="<?php echo "coins".$value['symbol'];?>" data-img="<?php echo base_url()."assets/images/coins/".$value['image'];?>" data-symbol="<?php echo $value['symbol'];?>" data-price="<?php echo $value['price'];?>" class="calcOp col-sm-4 col-xs-6 cal_col_padd">
		<div class="calcInnerActive inner_coins_area">
			<img src="<?php echo base_url()."assets/images/coins/".$value['image'];?>">
			<h3><?php echo $value['coinName'];?></h3>
			<p><?php echo $value['symbol'];?></p>
		</div>
	</div>
<?php }
}
else
{?>
<div class="text-center"><?php echo showLangVal($activeLanguage,"no_coins_found"); ?></h3>
<?php }?>