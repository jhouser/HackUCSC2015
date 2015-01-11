<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle = Yii::app()->name . ' - Invite Friends';
$this->breadcrumbs = array(
    'Invite',
);
?>


<h1>Invite Friends</h1>

<!-- search frieds -->
<p class= "button"><a href="https://www.facebook.com" class= "buttonfont1">Search</a></p>

<!-- or invite new friends! -->
<p class= "button" id="launch"><a style="cursor:pointer" class= "buttonfont1">Invite</a></p>


<!-- the invite friends button and invite friends modal 
<figure id="launchtime">
  <button><span>LAUNCH</span></button>
  <figcaption>Push the button. Go on, I dare you</figcaption>
</figure>
-->

<dialog id="dialog">
    <h1>Invite Friends to HopScotch!</h1>
    <textarea></textarea>
    <div>
        <button id="cancel">Cancel</button>
        <button id="okay">Invite!</button>
    </div>
</dialog>

<script type="text/javascript">

    var launchbutton = document.getElementById("launch");
    var dialog = document.getElementById('dialog');
    var okay = document.getElementById("okay");
    var cancel = document.getElementById("cancel");

    function showWindow() {
        dialog.showModal();
    }

    function closeWindow() {
        launchbutton.classList.remove("pressed");
        dialog.close();
    }

    launchbutton.onclick = function() {
        launchbutton.classList.add("pressed");
        //setTimeout( function() { showWindow() }, 800);
        showWindow();
    }
    okay.onclick = function() {
        closeWindow();
    }
    cancel.onclick = function() {
        closeWindow();
    }

</script>

<?php
$this -> widget('zii.widgets.CListView', array('dataProvider' => $dataProvider,
											   'itemView' => '_friends'));
?>
