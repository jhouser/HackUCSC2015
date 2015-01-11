<?php ?>

<link rel="stylesheet" type="text/css" href="css/event.css">



<?php 
$format = "D g:i A";
$start = date ( $format, $data->startTime );
$end   = date ( $format, $data->endTime   ); 

$user = Yii::app()->user->getModel();
$counter = 0;
foreach($user->userFriends as $friend) {
    if ($friend->isAvailable($data)){
        $counter++;
    }
}

?>

<div class="text">
  <h2><?php echo $data->title;?></h1>
  <p><?php echo $data->description;?></p>
  <p><?php echo $start." - ".$end;?></p>
</div>
<div class="friend">
  <?php echo $counter." : Friends can attend"?>
</div>
<div class="icon">
  <?php 
  $imgPath = "images/".$data->type->type.".gif";
  echo CHtml::image($imgPath);
  ?>
</div>
<br>


