<?php

require_once '/../../redcap_connect.php';
require_once APP_PATH_DOCROOT . 'ProjectGeneral/header.php';
require_once 'class/class.php';

// page used to simply select a form from project to be 'repeatable'
// TO DO: structure page to use a class definition to handle this page - want to be consistent with class.php approach

echo "<div style='width:300px; height:40px; color:blue'> Please Select Forms to Repeat:</div>";
echo '<form name="check"  style="width:400px" method="post" id="form" >';
echo '<table style="width:400px"><tr>';


$frms = REDCap::getInstrumentNames();
$pid=$_GET['pid'];
$conn= mysqli_connect(HOST,UNAME,PWD,'rf');

if(mysqli_connect_errno()){
  return null;
  // TO DO: Exception handling
}

$sql = "SELECT distinct form_name from rf_config where project_id='".$pid."'";
$res = mysqli_query($conn,$sql);

$saved_frms = array();
while($row=mysqli_fetch_assoc($res)){
  $saved_frms[] = $row['form_name'];
}

foreach ($frms as $unique_name=>$label) {
    $checked = (array_search($unique_name, $saved_frms) === false) ? null : ' checked disabled ';
    echo "<td class='label'><input ".$checked." type='checkbox' name='field[]'  id='check' value='".$unique_name."' class='input_control' ></td>";
    echo "<td class='label'>$label</td></tr>";
}

echo '</table>';
echo '<br/>';
echo '<span class="hdr"><input type="submit" value="Save" ></span>';
echo '</form>';

if (isset($_POST['field'])){
  $myarray=$_POST['field'];
 
  foreach($myarray as $array){
    $sql ="insert into rf_config (project_id,form_name) values('" . $pid . "','" . $array . "')";    
    $res = mysqli_query($conn,$sql);                            
  }

  header('Location: ' . $_SERVER['HTTP_REFERER']);  //TO DO: this is temp and unsecure - needs to be changed
}



?>