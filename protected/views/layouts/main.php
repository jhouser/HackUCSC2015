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

<style>	
.button
{
	
	border-radius: 25px;
	padding: 0px 0px;
	border: 2px solid #6495ED;
	background-color: #BCD2EE;
	height: 50px;
	width: 150px;
	margin: auto;
	text-align: center;

}

.buttonfont1
{
	text-decoration: none;
	color: #3D59AB;
	font-family: Verdana, sans-serif;
	font-size: 200%;
}

.buttonfont2 
{
	font-weight: bold;
	font-size: 18px;
	color: #ffffff;
}

.round-button {
	width:10%;
}
.round-button-circle {
	width: 100%;
	height:0;
	padding-bottom: 100%;
    border-radius: 50%;
	border:10px solid #cfdcec;
    overflow:hidden;
    
    background: #3b5998;
	<!--#4679BD;--> 
    box-shadow: 0 0 3px gray;
}
.round-button-circle:hover {
	background: #FF0000;
	<!--#30588e;-->
}
.round-button a {
    display:block;
	float:left;
	width:100%;
	padding-top:50%;
    padding-bottom:50%;
	line-height:1em;
	margin-top:-0.5em;
    
	text-align:center;
	color:#e2eaf3;
    font-family:Verdana;
    font-size:1.2em;
    font-weight:bold;
    text-decoration:none;
}
</style>
	
	
<!-- google+ sign in button config -->
<script src="https://apis.google.com/js/client:platform.js" async defer></script>

	
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<img src= "smilyface.png" alt= "logo" style="width:128px;height:128px"/>
		<div id="logo">HopScotch</div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
				array('label'=>'Invite', 'url'=>array('/site/contact')),
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->

	<br></br>
	<p class= "button">
		<a href="https://www.facebook.com" class= "buttonfont1">Facebook
	
		</a>
	</p>
	
	<div class="round-button"><div class="round-button-circle"><a href="https://facebook.com" class="round-button">Facebook</a></div></div>
	
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by HopScotch.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>

</html>