<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Invite Friends';
$this->breadcrumbs=array(
	'Intive',
);
?>


<h1><center>Invite Friends</center></h1>

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
  <p><label>Invite friend: </label> <input type = "text" id = "inv1" value = "email..." /></p>
  <p><label>Invite friend: </label> <input type = "text" id = "inv2" value = "email..." /></p>
  <p><label>Invite friend: </label> <input type = "text" id = "inv3" value = "email..." /></p>
  <p><label>Invite friend: </label> <input type = "text" id = "inv4" value = "email..." /></p>
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

var inv1 = document.getElementById("inv1");
var inv2 = document.getElementById("inv2");
var inv3 = document.getElementById("inv3");
var inv4 = document.getElementById("inv4");

function showWindow(){
	dialog.showModal();
}
	
function closeWindow(){
	launchbutton.classList.remove("pressed");
	inv1.value = "email..."; //reset the textboxes
	inv2.value = "email...";
	inv3.value = "email...";
	inv4.value = "email...";
	dialog.close();
}

launchbutton.onclick = function() {
	launchbutton.classList.add("pressed");
	//setTimeout( function() { showWindow() }, 800);
	showWindow();
}
okay.onclick = function(){ closeWindow(); }
cancel.onclick = function(){ closeWindow(); }

</script>
