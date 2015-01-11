

<div class="friend">

    <div class="friend-content">
        <?php
        echo CHtml::tag('div', array(
            'id' => $data->id . '-add-button',
            'class' => Yii::app()->user->isFriend($data) ? 'is-friend-button' : 'friend-add-button'
                ), '');
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
<?php
if (!Yii::app()->user->isFriend($data)) {
    Yii::app()->clientScript->registerScript($data->id . '-add-friend', '
        $("#' . $data->id . '-add-button").on("click",function(){
            $.ajax({
                url: "' . $this->createUrl('site/addFriend') . '",
                data: {"friendId": "' . $data->id . '"},
                success:function(data){
                    if(data){
                        $("#' . $data->id . '-add-button").removeClass("friend-add-button");
                        $("#' . $data->id . '-add-button").addClass("is-friend-button");
                        $("#' . $data->id . '-add-button").unbind("click");
                    }
                }
            });
        });
', CClientScript::POS_END);
}
?>
