<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="span-5">
    <div id="sidebar">
        <div id ="profile" class="fixedElement">
            <div id="profile-picture">
                <?php echo CHtml::image(Yii::app()->user->picture); ?>
            </div>
            <div id="profile-name">
                <h2><?php echo Yii::app()->user->fullName; ?></h2>
            </div>
        </div>
    </div><!-- sidebar -->
</div>
<div class="span-19 last">
    <div id="content">
        <?php echo $content; ?>
    </div><!-- content -->
</div>

<?php $this->endContent(); ?>