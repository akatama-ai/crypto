<?php $this->load->view("admin/includes/lte/head"); ?>
<title>Clear All Cache  - <?php echo $settings['title']; ?></title>
<?php $this->load->view("admin/includes/lte/header"); ?>
<?php $this->load->view("admin/includes/lte/sidebar"); ?> 
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Clear Cache
			<small>Erase all the cache</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_CONTROLLER."/dashboard"); ?>">Dashboard</a></li>
			<li class="active">Clear Cache</li>
		</ol>
	</section>
	<section class="content">
		<?php
		if(isset($_POST['check']) && $_POST['check'] == 1) {
			?>
			<div class="modal-dialog">
				<div class="modal-content panel-success">
					<div class="modal-header panel-heading">
						<h4 class="modal-title"><i class="fa fa-minus-circle"></i> Cache Cleared</h4>
					</div>
					<div class="modal-body">
						<p>All the cache cleared successfully.</p>
					</div>
				</div>
			</div>
			<?php
		}
		else {
			?>
			<form method="post" action="<?php echo base_url(ADMIN_CONTROLLER."/clear-cache"); ?>">
				<div class="modal-dialog">
					<div class="modal-content panel-warning">
						<div class="modal-header panel-heading">
							<h5 class="modal-title"><i class="fa fa-warning"></i> Clear All Cache?</h5>
						</div>
						<div class="modal-body">
							<p>Do you want to clear all the cache?</p>
							<div class="row">
								<div class="col-xs-12">
									<input type="hidden" name="check" value="1" />
									<button name="submit" type="submit" class="btn-md btn btn-success">Yes</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
			<?php
		}
		?>
	</section>
</div>
<?php $this->load->view("admin/includes/lte/footer-tag"); ?>
<?php $this->load->view("admin/includes/lte/footer-script-files"); ?>
<?php $this->load->view("admin/includes/lte/footer-end"); ?>