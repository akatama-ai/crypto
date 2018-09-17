<div class="search-append-area">
<?php foreach($result as $index=>$coin){?>
	<div class="search-append-row">
			<a href="<?php echo base_url()."coin/".$coin['symbol'];?>" class="cropton-icon"><img src="<?php echo strlen($coin['image'])>0?base_url()."assets/images/coins/".$coin['image']:"";?>" class="img-responsive"></a>
			<div class="cropton-icon-name">
				<a href="<?php echo base_url()."coin/".$coin['symbol'];?>"><?php echo $coin['coinName'];?></a>
				<p><?php echo $coin['symbol'];?></p>
			</div>
			<a data-attr="<?php echo $coin['cryptoId'];?>" class="cropton-icon-watchlist addW "><span class="throw <?php echo in_array($coin['cryptoId'],$watchList)?'on':"off"?>"></span></a>
	</div>
<?php } ?>
</div>
