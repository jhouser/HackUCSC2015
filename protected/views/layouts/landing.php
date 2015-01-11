<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	
	<!-- google+ sign in button config -->
	<script src="https://apis.google.com/js/client:platform.js" async defer></script>
	
</head>

<body>
	<div>
		<a href="index.php?r=site/contact" id="start-button">
			<img style="border:0px;" src="../../../images/hopscotch_start.png" onmouseover="this.src='../../../images/hopscotch_start_toggle.png'" onmouseout="this.src='../../../images/hopscotch_start.png';" alt="Button" />
		</a>
	</div>
</body>
</html>
