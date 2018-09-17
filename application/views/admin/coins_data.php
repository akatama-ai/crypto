<?php
if($totalCoins > 0) {
	?>
	<div class="table-responsive table_responsive_scroll">
		<table id="coins-data" class="table table-striped">
			<thead>
				<tr>
					<td class="sort-click" data-sort="coinName" data-sortorder="<?php echo($sortOrder == "asc" ? "desc" : "asc")?>">
						Coin &nbsp;&nbsp;&nbsp;
						<?php
						if($sort == "coinName") {
							?>
							<span><i class="fa fa-sort-<?php echo $sortOrder; ?>"></i></span>
							<?php
						}
						else {
							?>
							<span class="arrow-opacity"><i class="fa fa-sort"></i></span>
							<?php
						}
						?>
					</td>
					<td class="sort-click" data-sort="price" data-sortorder="<?php echo($sortOrder == "asc" ? "desc" : "asc")?>">
						Price &nbsp;&nbsp;&nbsp;
						<?php
						if($sort == "price") {
							?>
							<span><i class="fa fa-sort-<?php echo $sortOrder; ?>"></i></span>
							<?php
						}
						else {
							?>
							<span class="arrow-opacity"><i class="fa fa-sort"></i></span>
							<?php
						}
						?>
					</td>
					<td class="sort-click" data-sort="supply" data-sortorder="<?php echo($sortOrder == "asc" ? "desc" : "asc")?>">
						Supply &nbsp;&nbsp;&nbsp;
						<?php
						if($sort == "supply") {
							?>
							<span><i class="fa fa-sort-<?php echo $sortOrder; ?>"></i></span>
							<?php
						}
						else {
							?>
							<span class="arrow-opacity"><i class="fa fa-sort"></i></span>
							<?php
						}
						?>
					</td>
					<td class="sort-click" data-sort="volume24Hour" data-sortorder="<?php echo($sortOrder == "asc" ? "desc" : "asc")?>">
						Volume &nbsp;&nbsp;&nbsp;
						<?php
						if($sort == "volume24Hour") {
							?>
							<span><i class="fa fa-sort-<?php echo $sortOrder; ?>"></i></span>
							<?php
						}
						else {
							?>
							<span class="arrow-opacity"><i class="fa fa-sort"></i></span>
							<?php
						}
						?>
					</td>
					<td class="sort-click" data-sort="marketCap" data-sortorder="<?php echo($sortOrder == "asc" ? "desc" : "asc")?>">
						Market Cap &nbsp;&nbsp;&nbsp;
						<?php
						if($sort == "marketCap") {
							?>
							<span><i class="fa fa-sort-<?php echo $sortOrder; ?>"></i></span>
							<?php
						}
						else {
							?>
							<span class="arrow-opacity"><i class="fa fa-sort"></i></span>
							<?php
						}
						?>
					</td>
					<td class="sort-click" data-sort="changePercentage24Hour" data-sortorder="<?php echo($sortOrder == "asc" ? "desc" : "asc")?>">
						24H % Change &nbsp;&nbsp;&nbsp;
						<?php
						if($sort == "changePercentage24Hour") {
							?>
							<span><i class="fa fa-sort-<?php echo $sortOrder; ?>"></i></span>
							<?php
						}
						else {
							?>
							<span class="arrow-opacity"><i class="fa fa-sort"></i></span>
							<?php
						}
						?>
					</td>
					<td align="center">Actions</td>
				</tr>
				<tbody>
					<?php
					foreach($coins as $coin) {
						?>
						<tr>
							<td>
								<img width="30" src="<?php echo base_url("assets/images/coins/".$coin['image']); ?>" />
								&nbsp;&nbsp;
								<span><?php echo $coin['coinName']; ?></span>
							</td>
							<td>
								<?php
								$price = (!empty($coin['price']) ? $coin['price'] : 0);
								$price = $price * $currencyRate['rate'];
								?>
								<sup><?php echo $currencyRate['symbol']; ?></sup> <?php echo number_format($price,3,".",","); ?> 
							</td>
							<td>
								<?php 
								$supply = (!empty($coin['supply']) ? $coin['supply'] : 0);
								echo number_format($supply,0,".",",")." ".$coin['symbol'];
								?>
							</td>
							<td>
								<?php
								$volume24Hour = (!empty($coin['volume24Hour']) ? $coin['volume24Hour'] : "0");
								echo number_format($volume24Hour,2,".",",")." ".$coin['symbol'];
								?>
							</td>
							<td>
								<?php
								$marketCap = (!empty($coin['marketCap']) ? $coin['marketCap'] : 0);
								$marketCap = $marketCap * $currencyRate['rate'];
								?>
								<sup><?php echo $currencyRate['symbol']; ?></sup> <?php echo number_format($marketCap,0,".",","); ?>
							</td>
							<td>
								<?php
								$percenttage24HChange = (!empty($coin['changePercentage24Hour']) ? $coin['changePercentage24Hour'] : 0);
								echo number_format($percenttage24HChange,2)."%"; ?>
							</td>
							<td align="right">
								<button data-toggle="tooltip" title="Delete Coin" data-symbol="<?php echo $coin['symbol']; ?>" class="btn-xs delete-coin btn btn-danger">
									<i class="fa fa-trash"></i>
								</button>
								<button data-toggle="tooltip" title="Update Coin" data-symbol="<?php echo $coin['symbol']; ?>" class="btn-xs update-coin btn btn-info">
									<i class="fa fa-check-square-o"></i>
								</button>
								<button data-toggle="tooltip" title="Change Affiliate Link" data-symbol="<?php echo $coin['symbol']; ?>" data-affiliatelink="<?php echo $coin['affiliateLink']; ?>" class="btn-xs update-coin-affiliate-link btn btn-primary">
									<i class="fa fa-pencil-square-o"></i>
								</button>
								<button data-toggle="tooltip" title="Change Coin Status" data-symbol="<?php echo $coin['symbol']; ?>" data-status="<?php echo $coin['status']; ?>" class="btn btn-xs btn-default change-status">
									<i style="color:<?php echo $coin['status'] == 1 ? "green" : "black"; ?>;" class="fa fa-square"></i>
								</button>
								<a data-toggle="tooltip" title="Edit Coin" class="btn-xs btn btn-warning" href="<?php echo base_url(ADMIN_CONTROLLER."/edit-coin/".$coin['id']); ?>"><i class="fa fa-pencil-square-o"></i></a>
							</td>
						</tr>
						<?php
					}
					?>
				</tbody>
			</thead>
		</table>
	</div>

	<ul class="pagination">
		<?php
		if($totalPages > 1) {
			$range = ($totalPages > 7 ? 7 : $totalPages);
			$a = 3; $b = 4; $ax = 1;
			if($page != 1) {
				?>
				<li class="<?php echo $page == 1 ? "disabled" : ""; ?>">
					<a class="page" data-pageid="<?php echo ($page - 1); ?>"><i class="fa fa-angle-left"></i></a>
				</li>
				<?php
			}
			if($page > ($b +1)) {
				?>
				<li class="hidden-xs">
					<a class="page" data-pageid="1">1</a>
				</li>
				<li class="hidden-xs">
					<a>...</a>
				</li>
				<?php
			}
			if($totalPages > 7) {
				if(($page + $a) > $totalPages) {
					$ax = $page + (($totalPages - $page) - 2 - $b);
				}
				else if($page > 3) {
					$ax = $page - $a;
				}
			}
			for($i = 1; $i <= $range; $i++) {
				if($ax == $page) {
					?><li class="disabled active"><a><?php echo $ax; ?></a></li><?php
				}
				else {
					?><li><a class="page" data-pageid="<?php echo $ax; ?>"><?php echo $ax; ?></a></li><?php
				}
				$ax++;
			}
			if(($totalPages - $page) > $b) {
				?>
				<li class="hidden-xs">
					<a>...</a>
				</li>
				<li class="hidden-xs">
					<a class="page" data-pageid="<?php echo $totalPages; ?>"><?php echo $totalPages; ?></a>
				</li class="hidden-xs">
				<?php
			}
			if($page != $totalPages) {
				?>
				<li><a class="page" data-pageid="<?php echo ($page + 1); ?>"><i class="fa fa-angle-right"></i></a></li>
				<?php
			}
		}
		else {
			?><li class="disabled active"><a>1</a></li><?php
		}
		?>
	</ul>
	<?php
}
else {
	?>
	<h2 class="m-t-20 m-b-20 text-center text-danger"><i class="fa fa-warning"></i> &nbsp;No matching records found :(</h2>
	<?php
}
?>
<input type="hidden" id="page" value="<?php echo $page; ?>"/>
<input type="hidden" id="sort" value="<?php echo $sort; ?>"/>
<input type="hidden" id="sortOrder" value="<?php echo $sortOrder; ?>"/>
<input type="hidden" id="currency" value="<?php echo $currency; ?>"/>
<input type="hidden" id="search" value="<?php echo $search; ?>"/>