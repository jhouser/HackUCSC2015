<?php

/**
 * Results Display
 * Will display all the events available to the user.
 */
 
$dataProvider=new CActiveDataProvider('Post');

$this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_post',   // refers to the partial view named '_post'
    'sortableAttributes'=>array(
        'title',
        'create_time'=>'Post Time',
    ),
));

class FinalDisplay extends CListView
{
	
}
