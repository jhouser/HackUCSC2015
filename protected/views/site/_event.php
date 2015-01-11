<?php ?>

<link rel="stylesheet" type="text/css" href="css/event.css">

<div class="text">
  <h2><?php echo $data->title;?></h1>
  <p><?php echo $data->description;?><p>
</div>
<div class="icon">
  <?php 
  $imgPath = "images/".$data->type->type.".gif";
  echo CHtml::image($imgPath);
  ?>
</div>
<br>


