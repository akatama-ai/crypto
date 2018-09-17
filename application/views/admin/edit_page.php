<?php $this->load->view("admin/includes/lte/head"); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/bootstrap-toggle/css/bootstrap-toggle.min.css"); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/froala-editor/froala-editor.min.css"); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/froala-editor/froala-style.min.css"); ?>">
<title>Edit Page <?php echo $title." - ".$settings['title']; ?></title>
<?php $this->load->view("admin/includes/lte/header"); ?>
<?php $this->load->view("admin/includes/lte/sidebar"); ?> 
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Edit Page(<?php echo $title; ?>)
			<small>Edit Page(<?php echo $title; ?>)</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_CONTROLLER."/dashboard"); ?>">Dashboard</a></li>
			<li><a href="<?php echo base_url(ADMIN_CONTROLLER."/pages"); ?>">Pages</a></li>
			<li class="active">Edit Page</li>
		</ol>
	</section>
	<section class="content">
		<?php
		if(isset($_POST['submit'])) {
			if($error == false) {
				?>
				<div class="alert alert-success">
					<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<i class="fa fa-check-square-o"></i> Page updated successfully.
				</div>
				<?php
			}
			else {
				?>
				<div class="alert alert-danger">
					<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<i class="fa fa-warning"></i> Some error occured cannot update page.
				</div>
				<?php
			}
		}
		?>
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-pencil-square-o"></i> Edit Page(<?php echo $title; ?>)</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
				</div>
			</div>
			<div class="box-body">
				<form method="post" action="<?php echo base_url(ADMIN_CONTROLLER."/edit-page/".$id); ?>">
					<div class="form-group">
						<label>Title</label>
						<input type="text" name="title" class="form-control" placeholder="Enter Title..." value="<?php echo (isset($title) ? $title : ""); ?>" />
						<?php
						if(isset($titleError)) {
							?>
							<div class="m-t-5 text-danger"><small><?php echo $titleError; ?></small></div>
							<?php
						}
						?>
					</div>
					<div class="form-group">
						<label>Permalink</label>
						<input type="hidden" name="oldPermalink" value="<?php echo(isset($oldPermalink) ? $oldPermalink : $permalink); ?>" />
						<input type="text" name="permalink" class="form-control" placeholder="Enter Permalink (Optional : Leave the field to auto generate)" value="<?php echo (isset($permalink) ? $permalink : ""); ?>" />
						<?php
						if(isset($permalinkError)) {
							?>
							<div class="m-t-5 text-danger"><small><?php echo $permalinkError; ?></small></div>
							<?php
						}
						?>
					</div>
					<div class="form-group">
						<label>Description</label>
						<textarea name="description" class="form-control" placeholder="Enter Description..." rows="4"><?php echo (isset($description) ? $description : ""); ?></textarea>
						<?php
						if(isset($descriptionError)) {
							?>
							<div class="m-t-5 text-danger"><small><?php echo $descriptionError; ?></small></div>
							<?php
						}
						?>
					</div>
					<div class="form-group">
						<label>Keywords</label>
						<input type="text" name="keywords" class="form-control" placeholder="Enter Keywords..." value="<?php echo (isset($keywords) ? $keywords : ""); ?>" />
						<?php
						if(isset($keywordsError)) {
							?>
							<div class="m-t-5 text-danger"><small><?php echo $keywordsError; ?></small></div>
							<?php
						}
						?>
					</div>
					<div class="form-group">
						<label>Content</label>
						<textarea id="content" name="content" class="form-control" placeholder="Enter Content..." rows="4"><?php echo (isset($content) ? $content : ""); ?></textarea>
						<?php
						if(isset($contentError)) {
							?>
							<div class="m-t-5 text-danger"><small><?php echo $contentError; ?></small></div>
							<?php
						}
						?>
					</div>
					<div class="form-group">
						<label>Status</label>
						<div>
							<input type="checkbox" name="status" data-toggle="toggle" data-size="small" data-onstyle="success" <?php echo(isset($status) && $status == 1 ? "checked" : ""); ?> />
						</div>
					</div>
					<div class="form-group m-b-0">
						<button type="submit" name="submit" class="btn btn-primary">
							<i class="fa fa-pencil-square-o"></i> Update
						</button>
					</div>
				</form>
			</div>
		</div>
	</section>
</div>
<?php $this->load->view("admin/includes/lte/footer-tag"); ?>
<?php $this->load->view("admin/includes/lte/footer-script-files"); ?>
<script type="text/javascript" src="<?php echo base_url("assets/bootstrap-toggle/js/bootstrap-toggle.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/froala-editor/froala-editor.min.js"); ?>"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#content').editable ({
		inlineMode: false,
		height: 300
	});
});
</script>
<?php $this->load->view("admin/includes/lte/footer-end"); ?>