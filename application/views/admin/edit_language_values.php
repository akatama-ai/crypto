<?php $this->load->view("admin/includes/lte/head"); ?>
<title>Edit Language Values - <?php echo $language['name']." - ".$settings['title']; ?></title>
<?php $this->load->view("admin/includes/lte/header"); ?>
<?php $this->load->view("admin/includes/lte/sidebar"); ?> 
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Edit Language Values (<?php echo $language['name']; ?>)
			<small>Edit Language Values (<?php echo $language['name']; ?>)</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_CONTROLLER."/dashboard"); ?>">Dashboard</a></li>
			<li><a href="<?php echo base_url(ADMIN_CONTROLLER."/languages"); ?>">languages</a></li>
			<li class="active">Edit Language Values</li>
		</ol>
	</section>
	<button class="btn btn-info" id="btn-check-empty"><i class="fa fa-check"></i> Goto next empty field</button>
	<section class="content">
		<?php
		if(isset($_POST['submit'])) {
			if($error == false) {
				?>
				<div class="alert alert-success">
					<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<i class="fa fa-check-square-o"></i> Language values updated successfully.
				</div>
				<?php
			}
		}
		?>
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-pencil-square-o"></i> Edit Language Values (<?php echo $language['name']; ?>)</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
				</div>
			</div>
			<div class="box-body">
				<form method="post" action="<?php echo base_url(ADMIN_CONTROLLER."/edit-language-values/".$id); ?>">
					<?php
						foreach($languageRec as $index => $rec) {
						?>	
						<div class="form-group">
							<label for="<?php echo $rec['title'] ?>"><?php echo $rec['title']; ?></label>
							<div style="margin-bottom: 5px;"><small><strong>Original Text : </strong><?php echo $rec['value']; ?></small></div>
							<input type="text" name="<?php echo $index; ?>" class="form-control" placeholder="Value in <?php echo $language['name']; ?>..." value="<?php echo (isset($languageValues[$index]) ? $languageValues[$index] : "") ?>" />	
						</div>
						<?php
					}
					?>
					<div class="form-group m-b-0">
						<button type="submit" name="submit" class="btn btn-primary">
							<i class="fa fa-check-square-o"></i> Update
						</button>
					</div>
				</form>
			</div>
		</div>
	</section>
</div>
<?php $this->load->view("admin/includes/lte/footer-tag"); ?>
<?php $this->load->view("admin/includes/lte/footer-script-files"); ?>
<script type="text/javascript">
	$(document).ready(function() {
		$("#btn-check-empty").click(function(e) {
			e.preventDefault();
			$("input[type=text]").each(function() {
				var $context = $(this);
				var str = $.trim($context.val());
				if(!str || 0 === str.length) {
					$context.focus();
					return false;
				} 
			});
		});
	});
</script>
<?php $this->load->view("admin/includes/lte/footer-end"); ?>