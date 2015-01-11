<?php

/**
 * Results Display
 * Will display all the events available to the user.
 */
 

$this-> widget('zii.widgets.CListView', array(
            'dataProvider'=>$dataProvider,
            'itemView'=>'_event',
        ));
