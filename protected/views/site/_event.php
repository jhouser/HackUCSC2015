<?php ?>

<link rel="stylesheet" type="text/css" href="css/event.css">



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
            $imgString .= CHtml::image($friend->picture, '', array('height' => '30px', 'width' => '30px','class'=>'mini-prof-pic'));
        }elseif($counter == 4){
            $imgString.="+";
        }
    }
}
?>
<div class="icon">
  <?php 
  $imgPath = "images/".$data->type->type.".gif";
  echo CHtml::image($imgPath);
  ?>
</div>
<div class="text">
    <h2><?php echo $data->title; ?></h1>
        <p><?php echo $data->description; ?></p>
        <p><?php echo $start . " - " . $end; ?></p>
</div>
<div class="friend">
    <div>
        <?php echo $counter . " : Friends can attend" ?>
    </div>
    <div>
        <?php echo $imgString; ?>
    </div>
</div>

<br>


