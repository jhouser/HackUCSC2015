<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="span-5">
    <div id="sidebar">
        <div id ="profile">
            <div id="profile-picture">
                <?php echo CHtml::image(Yii::app()->user->picture); ?>
            </div>
            <span id="profile-name">
                <?php echo Yii::app()->user->fullName; ?>
            </span>
        </div>
    </div><!-- sidebar -->
</div>
<div class="span-19 last">
    <div id="content">
        <?php echo $content; ?>
    </div><!-- content -->
</div>

<?php $this->endContent(); ?>