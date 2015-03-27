<?php


require_once 'class/class.php';

function redcap_save_record ($project_id, $record, $instrument, $event_id, $group_id, $survey_hash, $response_id){ 

	$rep = isFormRepeat($project_id, $instrument);

	switch ($rep) {
		case true:
			new controller($project_id,$record, $instrument, $event_id, $rc_token, 'save');
			break;
	}

}

//******************************************************************************************************************************************************

function redcap_data_entry_form ($project_id, $record, $instrument, $event_id, $group_id){ 

	$rep = isFormRepeat($project_id, $instrument);
	
	switch ($rep) {
		case true:
			new controller($project_id,$record, $instrument, $event_id, $rc_token, 'disp');
			break;
	}

} 


function isFormRepeat($pid, $instr){

	$conn= mysqli_connect(HOST,UNAME,PWD,'rf');

	if(mysqli_connect_errno()){
  		return false;
  	// TO DO: Exception handling
	}

	$sql = "SELECT count(form_name) as freq from rf.rf_config where project_id='".$pid."' and form_name = '".$instr."'";
	$res = mysqli_query($conn,$sql);
	$row=mysqli_fetch_assoc($res);
	
	if($row['freq']>0)
		return true;

	return false;
}

?>