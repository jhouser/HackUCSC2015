<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Invite Friends';
$this->breadcrumbs=array(
	'Intive',
);
?>

<figure id="launchtime">
  <button id="launch"><span>LAUNCH</span>
  </button>
  <figcaption>Push the button. Go on, I dare you</figcaption>
</figure>

<dialog id="dialog">

  <h1>Invite Friends to HopScotch!</h1>
  <p><label>Invite friend: </label> <input type = "text" id = "myText" value = "email..." /></p>
  <p><label>Invite friend: </label> <input type = "text" id = "myText" value = "email..." /></p>
  <p><label>Invite friend: </label> <input type = "text" id = "myText" value = "email..." /></p>
  <p><label>Invite friend: </label> <input type = "text" id = "myText" value = "email..." /></p>
  
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

//alert(okay);

function showWindow(){
	dialog.showModal();
}	
function closeWindow(){
	launchbutton.classList.remove("pressed");
	dialog.close(); 
}

launchbutton.onclick = function() {
	launchbutton.classList.add("pressed");
	setTimeout( function() { showWindow() }, 800);
}
okay.onclick = function(){ closeWindow(); }
cancel.onclick = function(){ closeWindow(); }

</script>


<h1><center>Invite Friends</center></h1>
<h1><center>test</center></h1>
