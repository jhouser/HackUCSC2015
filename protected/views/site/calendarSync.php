<?php

echo "<h1>Google Calendar Sync</h1>";

$user = Yii::app()->user->getModel();
if(isset($user->calendar)){
    echo "<span style='color:red'>You have already selected a calendar to sync with. Are you sure you want to change?</span>";
    echo "<div><br></div>";
}

echo CHtml::form();
echo CHtml::label('Select a Google Calendar to sync','calendar');
echo "<br>";
echo CHtml::dropDownList('calendar','',$calendars);
echo "<br><br>";
echo CHtml::submitButton('Sync');
echo CHtml::endForm();