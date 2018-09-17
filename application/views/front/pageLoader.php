<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view("front/includes/head",['adPageHeader'=>$_ci_view]); ?>
  </head>
<body>
	<div id="respondSearch" class="crypto-main-container">
		<?php $this->load->view("front/includes/header"); ?>
		<div class="pages_main">
			<h2><?php echo $pageName;?></h2>
			<div>
				<?php echo stripcslashes(html_entity_decode($pageInfo['content'],ENT_QUOTES,"UTF-8"));?>
			</div>
			<?php $this->load->view("front/includes/ad-show",['currentPage' => $_ci_view, "className" => "footer_add"]); ?>
		</div>
	</div>
	<?php $this->load->view("front/includes/footer"); ?>
</body>
</html>