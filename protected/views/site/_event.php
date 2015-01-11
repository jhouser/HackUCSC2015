<div class="event">
    <?php
    $format = "D g:i A";
    $start = date($format, $data->startTime);
    $end = date($format, $data->endTime);

    $user = Yii::app()->user->getModel();
    $counter = 0;
    $imgString = "";
    foreach ($user->userFriends as $userFriend) {
        $friend = $userFriend->friend;
        if ($friend->isAvailable($data)) {
            $counter++;
            if ($counter <= 4) {
                $imgString .= CHtml::image($friend->picture, '', array('height' => '30px', 'width' => '30px', 'class' => 'mini-prof-pic'));
            } elseif ($counter == 4) {
                $imgString.="+";
            }
        }
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
            <h1><b><?php echo $data->title; ?></b></h1>
        </div>
        <div class="text">

            <p><?php echo $data->description; ?></p>
            
        </div>
		<div class="friend">
            <div>
                <?php echo $counter . " : Friends can attend" ?>
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


