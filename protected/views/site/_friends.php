

<div class="friend">

    <div class="friend-content">
        <?php
        echo CHtml::tag('div', array(
            'class' => Yii::app()->user->isFriend($data) ? 'is-friend-button' : 'friend-add-button'
        ),'');
        ?>
        <div class="friend-icon">
            <?php
            echo CHtml::image($data->picture, '', array('height' => '30px',
                'width' => '30px',
                'class' => 'mini-prof-pic'));
            ?>
        </div>
        <div class="friend-text">
<?php echo $data->fullName; ?>
        </div>
    </div>

</div>


