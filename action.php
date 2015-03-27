<?php

require_once 'class/class.php';

// TO DO: use POST instead of GET
// page used to perform a given action
// NOTE:  ALL actions require instantiation of CONFIG and DATA - switch used to select proper action(s) from ACTION class
// TO DO: all actions resolve to same instantiation of ACTION object - need to determine if switch is needed


$pid = $_GET['pid'];
$rec = $_GET['rec'];
$instr = $_GET['instr'];
$event = $_GET['event'];
$action = $_GET['action'];
$curr_it = $_GET['curr_it'];

$user_rights = REDCap::getUserRights(USERID);
$rc_token = $user_rights[USERID][api_token];

if($rc_token == null){
	REDCap::allowProjects(-1);
}

$c = new config($pid, $rec, $instr, $event, $rc_token, $action, $curr_it);
$d = new data($c->config);

echo $c->config['token'];

switch ($action) {
	
	case 'delete':
	case 'edit':
	case 'clear':
		new action($d->config,$d->instr_data_raw,$d->getConn(), $d->rep_data);
		header('Location: ' . $_SERVER['HTTP_REFERER']);  //TO DO: this is temp and unsecure - needs to be changed
		break;
}



?>

