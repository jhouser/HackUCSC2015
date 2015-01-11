<?php

/**
 * Results Display
 * Will display all the events available to the user.
 */
?>
<link rel="stylesheet" type="text/css" href="css/event.css">
<div class="page-title"><h1>Available Events</h1></div>
<?php

$this-> widget('zii.widgets.CListView', array(
            'dataProvider'=>$dataProvider,
            'itemView'=>'_event',
        ));
