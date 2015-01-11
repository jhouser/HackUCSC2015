<?php

echo CHtml::form();
echo CHtml::label('Select a Google Calendar to sync','calendar');
echo "<br>";
echo CHtml::dropDownList('calendar','',$calendars);
echo "<br><br>";
echo CHtml::submitButton('Sync');
echo CHtml::endForm();