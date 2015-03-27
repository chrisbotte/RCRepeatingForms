<?php
/*
mapStringToAssocArray
Params: string and 2 deliniters
fcn separates string into multiple array elements on first delimiter
further breaks down the string into separate array elemts on 2nd deliniter 
Example: 1, Male \n 2, Female =====>  [1]=>'Male' [2]='Female'
*/

function mapStringToAssocArray($string, $first_delim, $second_delim){

	if($string == null){
		return null;
	}

	$a = explode($first_delim, $string);	

	$final = array();

	if($a[0]=="" || !strpos($string,",")){
		return null;
	}
	
	foreach ($a as $key => $value) {
		$t_key = trim(substr($value, 0, strpos($value,",")));
		$t_val = trim(substr($value,  strpos($value,",")+1));
		$final[$t_key] = $t_val;
	}
	unset($a);
	unset($t_key);
	unset($t_val);
	
	return $final;

}

function writeDESLog($msg, $pid){

	$conn= mysqli_connect(DES_HOST,DES_UNAME,DES_PWD, DES_SCHEMA);
	if(mysqli_connect_errno()){
		echo "Non-Logged Error. Can't Connect to DES schema: " . mysqli_connect_errno();
	}

	$date = date('Y/m/d H:i:s');
	$logtxt = $msg;
	$logtxt =  mysqli_real_escape_string($conn, $msg);
	$status = 0;
	$insert = 'INSERT INTO des_log VALUES ("'.$date.'","'.$logtxt.'",'.$status.','.$pid.')';
	mysqli_query($conn, $insert);
	echo '<div style="background-color:#FFE1E1;border:1px solid red;max-width:700px;padding:6px;color:#800000;">Please Report the following to your REDCAP Admin:<br><br>' . $msg . '</div>';

}

function escapeXML($str){
	$s = $str;
	$s = str_replace('&', 'AND', $s);
	$s = str_replace('<', 'LT', $s);
	$s = str_replace('>', 'GT', $s);
	return $s;
}



function cDate_mdy($date){
	if($date != null && $date != ''){
		$t = strtotime($date);

		return date('m/d/Y',$t);
	}
	else{
		return null;
	}

}

function cDate_ymd($date){

	if($date != null && $date != ''){
		$t = strtotime($date);
		
		return date('Y-m-d',$t);
	}
	else{
		return null;
	}
}
?>