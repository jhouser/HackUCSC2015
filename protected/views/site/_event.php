<div class="event">
    <?php
    $format = "D g:i A";
    $start = date($format, $data->startTime);
    $end = date($format, $data->endTime);

    $user = Yii::app()->user->getModel();
    $isAttending = $user->isAttending($data);
    $counter = 0;
    $imgString = "";
    $extraFriends = array();
    foreach ($user->userFriends1 as $userFriend) {
        $friend = $userFriend->friend;
        if ($friend->isAvailable($data)) {
            $counter++;
            if ($counter < 4) {
                $imgString .= CHtml::image($friend->picture, $friend->fullName, array('height' => '30px', 'width' => '30px', 'title' => $friend->fullName, 'class' => 'mini-prof-pic'));
            } elseif ($counter >= 4) {
                $extraFriends[] = $friend->fullName;
            }
        }
    }
    if ($counter >= 4) {
        $titleString = implode(", ",$extraFriends);
        $imgString.=CHtml::image('images/ellipses.png', '', array('height' => '30px', 'width' => '30px','title'=>$titleString));
    }
    ?>

    <div class="icon">
        <?php
        $imgPath = "images/" . $data->type->type . ".gif";
        echo CHtml::image($imgPath);
        ?>
    </div>
    <div class="event-content">
        <div class="title">
            <div class="title-text">
                <h1><b><?php echo $data->title; ?></b></h1>
            </div>
            <div class="sign-up">
                <?php if (!$isAttending) { ?>
                    <button class="sign-up-btn" id="<?php echo $data->id; ?>-sign-up">Sign up!</button>
                <?php } else { ?>
                    <button class="attending-btn" disabled="disabled">Attending!</button>
                <?php } ?>
            </div>
        </div>
        <div class="text">

            <p><?php echo $data->description; ?></p>

        </div>
        <div class="friend">
            <div>
                <?php echo $counter . " " . ($counter == 1 ? "friend" : "friends") . " can attend!" ?>
            </div>
            <div>
                <?php echo $imgString; ?>
            </div>
        </div>
        <div class="time">
            <p><i><?php echo $start . " - " . $end; ?></i></p>
        </div>

    </div>

</div>
<?php
if (!$isAttending) {
    Yii::app()->clientScript->registerScript($data->id . '-sign-up', '
        $("#' . $data->id . '-sign-up").on("click",function(){
            $.ajax({
                url: "' . $this->createUrl('site/signUpForEvent') . '",
                data: {"eventId": "' . $data->id . '"},
                success:function(data){
                    if(data){
                        $("#' . $data->id . '-sign-up").removeClass("sign-up-btn");
                        $("#' . $data->id . '-sign-up").addClass("attending-btn");
                        $("#' . $data->id . '-sign-up").html("Attending!");
                        $("#' . $data->id . '-sign-up").attr("disabled","disabled");
                        $("#' . $data->id . '-sign-up").unbind("click");
                    }
                }
            });
        });
', CClientScript::POS_END);
}
?>


