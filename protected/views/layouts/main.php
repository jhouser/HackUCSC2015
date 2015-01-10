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

                border-radius: 5px;
                border: 2px solid #6495ED;
                background-color: #BCD2EE;
                height: 50px;
                width: 120px;
                margin: auto;
                text-align: center;

            }

            .buttonfont1
            {
                text-decoration: none;
                color: #3D59AB;
                font-family: Verdana, sans-serif;
            }

            .buttonfont2 
            {
                font-weight: bold;
                font-size: 18px;
                color: #ffffff;
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
                <?php
                $this->widget('zii.widgets.CMenu', array(
                    'items' => array(
                        array('label' => 'Home', 'url' => array('/site/index')),
                        array('label' => 'About', 'url' => array('/site/page', 'view' => 'about')),
                        array('label' => 'Invite', 'url' => array('/site/contact')),
                        array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
                        array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
                    ),
                ));
                ?>
            </div><!-- mainmenu -->

            <br></br>
            <p class= "button">Hello World!
                <a href="https://www.facebook.com">Facebook
                    <a style= "color:green">Facebook</a>
                </a>
            </p>



            <?php if (isset($this->breadcrumbs)): ?>
                <?php
                $this->widget('zii.widgets.CBreadcrumbs', array(
                    'links' => $this->breadcrumbs,
                ));
                ?><!-- breadcrumbs -->
<?php endif ?>

<?php echo $content; ?>

            <div class="clear"></div>

            <div id="footer">
                <<<<<<< HEAD
                Copyright &copy; <?php echo date('Y'); ?> by HopScotch.<br/>
                All Rights Reserved.<br/>
                =======
                                <!-- Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/> -->
                <!-- All Rights Reserved.<br/> -->
                >>>>>>> 75abf71083c4c560ec315b7f914f967cfa85d57f
<?php echo Yii::powered(); ?>
            </div><!-- footer -->

        </div><!-- page -->

    </body>
</html>
