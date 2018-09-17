	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?php echo metaDisc($description);?>"/>
	<meta name="keywords" content="" />
	
	<?php $printTitleComplete=strlen($pageName)>0?$pageName." | ".$title:$title;?>
	<title><?php echo $printTitleComplete;?></title>
	
	<meta property="og:site_name" content="<?php echo $title;?>" />
	<meta property="og:title" content="<?php echo $printTitleComplete;?>" />
	<meta property="og:image" content="<?php echo $coverImage;?>" />
	<meta property="og:description" content="<?php echo metaDisc($description);?>" /> 
	<meta property="og:url" content="<?php echo base_url().$url;?>" />
	<meta property="og:type" content="website" />
	<meta property="fb:app_id" content="<?php echo $facebookAppId; ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<meta name="twitter:card" content="photo"/>
	<meta name="twitter:title" content="<?php echo $printTitleComplete?>"/>
	<meta name="twitter:site" content="@<?php echo $title;?>"/>
	<meta name="twitter:description" content="<?php echo metaDisc($description);?>" />
	<meta name="twitter:image:src" content="<?php echo $coverImage;?>" />
	
	<link rel="shortcut icon" href="<?php echo base_url()."assets/images/".$favicon;?>" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()."assets/bootstrap/css/bootstrap.min.css?a=".time(); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()."assets/font-awesome/css/font-awesome.min.css?a=".time(); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()."assets/themify-icons/themify-icons.css?a=".time() ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()."assets/css/bootstrap-select.min.css?a=".time() ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()."assets/css/style.css?a=".time(); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()."assets/plugins/jConfirm/jquery-confirm.css"; ?>">
	
	<?php if($nightMode){?>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/css/day.css?a=".time()); ?>">
	<?php } ?>
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
	
	<?php if($analytics['status'] == 1) { echo stripcslashes(html_entity_decode($analytics['code'],ENT_QUOTES,"UTF-8")); } ?>
	
	