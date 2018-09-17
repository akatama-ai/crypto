<?php
if($totalCurrencies > 0) {
	?>
	<div class="table-responsive table_responsive_scroll">
		<table class="table table-striped">
			<thead>
				<tr>
					<td class="sort-click" data-sort="currency" data-sortorder="<?php echo($sortOrder == "asc" ? "desc" : "asc")?>">
						Currency &nbsp;&nbsp;&nbsp;
						<?php
						if($sort == "currency") {
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
					<td class="sort-click" data-sort="rate" data-sortorder="<?php echo($sortOrder == "asc" ? "desc" : "asc")?>">
						Rate (=1$) &nbsp;&nbsp;&nbsp;
						<?php
						if($sort == "rate") {
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
					<td class="sort-click" data-sort="countryCode" data-sortorder="<?php echo($sortOrder == "asc" ? "desc" : "asc")?>">
						Country &nbsp;&nbsp;&nbsp;
						<?php
						if($sort == "countryCode") {
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
					<td class="sort-click" data-sort="name" data-sortorder="<?php echo($sortOrder == "asc" ? "desc" : "asc")?>">
						Name &nbsp;&nbsp;&nbsp;
						<?php
						if($sort == "name") {
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
					<td class="sort-click" data-sort="symbol" data-sortorder="<?php echo($sortOrder == "asc" ? "desc" : "asc")?>">
						Symbol &nbsp;&nbsp;&nbsp;
						<?php
						if($sort == "symbol") {
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
					foreach($currencies as $row) {
						?>
						<tr>
							<td><?php echo $row['currency']; ?></td>
							<td><?php echo $row['rate']; ?></td>
							<td>
								<img width="25" src="<?php echo base_url("assets/images/flags/".$row['countryCode'].".svg"); ?>"/>
								&nbsp;&nbsp;
								<span>
									<?php echo $row['countryCode']." <small>(".$countries[$row['countryCode']].")</small>"; ?>
								</span>
							</td>
							<td><?php echo $row['name']; ?></td>
							<td><?php echo $row['symbol']; ?></td>
							<td align="right">
								<a data-toggle="tooltip" title="Edit Currecny" class="btn-xs btn btn-info" href="<?php echo base_url(ADMIN_CONTROLLER."/edit-currency?currency=".$row['currency']); ?>"><i class="fa fa-pencil"></i></a>
								<button data-currency="<?php echo $row['currency']; ?>" class="btn btn-danger btn-xs delete-currency">
									<i class="fa fa-trash"></i>
								</button>
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
<input type="hidden" id="search" value="<?php echo $search; ?>"/>
<input type="hidden" id="currencyDeleted" value="<?php echo $currencyDeleted; ?>"/>