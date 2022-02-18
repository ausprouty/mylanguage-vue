<?php
$debug = 'I entered AuthorApi with Action '. $_GET['action'];

if (!isset($_GET['action'])){
	die();
}
// with help from https://github.com/RobDWaller/ReallySimpleJWT
if (isset ($_GET['backend'])){
	require_once ('.env.api.'. $_GET['backend'] .'.php');
}
else{
	require_once ('.env.api.remote.php');
}
myHeaders();  // get rid of CORS
// assign variables

$out = array();
$debug = 'Using AuthorApi'. "\n";
$debug .= '$p[] = ' . "\n";
$debug .= 'parameters:' . "\n";
foreach ($_POST as $param_name => $param_value) {
	$$param_name = $param_value;
	$p[$param_name] =  $param_value;
	$debug .= $param_name . ' = ' . $param_value. "\n";
}
$debug .= 'end of parameters' . "\n";
$debug .= 'finished post loop' . "\n";
// $p is passed to all functions
$p = $_POST ;
$p['version'] = VERSION;// this can be overwritten
$p['debug'] = '';

// deal with action
$action = $_GET['action'];
$p['action'] = $action;
$debug .= 'Action: '. $action . "\n";
writeLog($action . '-parameters', $debug);
// login routine
if ($action == 'login'){
	$out = myLogin($p);
	$debug .= $out['debug'];
}
// login routine
elseif ($action == 'validate'){
	require_once ($_GET['page'] . '.php');
	$out = validate($p);
	$debug .= $out['debug'];
}
elseif ($action == 'register'){
	require_once ('register.php');
	$out = register($p);
	$debug .= $out['debug'];
}
else{
	$ok = myAuthorize($p);
    if($ok){
		// add any approved pages
		if (isset($_GET['page'])){
			$debug .= 'I am adding page' . "\n";
			require_once ($_GET['page'] . '.php');
		}
		$debug .= 'action is '  . $action ."\n";
	    $out = $action ($p);
		if (isset($out['debug'])){
			if (is_array($out['debug'])){
				foreach ($out['debug'] as $d){
					$debug .= $d;
				}
			}
			else{
				$debug .= $out['debug'];
			}

			unset ($out['debug']);
		}
		else{
			$debug .= 'No error messages' . "\n";
		}
    }
    else{
        $debug .= 'NOT AUTHORIED';
    }
}
//
// write log
//
$debug .= "\n\nHERE IS JSON_ENCODE OF DATA THAT IS NOT ESCAPED\n";
$debug .= json_encode($out) . "\n";

writeLog($action, $debug);
// return response
header("Content-type: application/json");
echo json_encode($out, JSON_UNESCAPED_UNICODE);
die();

function writeLog($filename, $content){
	if (!is_array($content)){
		$text = $content;
	}
	else{
		$text = '';
		foreach ($content as $key=> $value){
			$text .= $key . ' => '. $value . "\n";
		}
	}
	if (ROOT_LOG){
		$root_log = ROOT_LOG;
	}
	else{
		$root_log = '/home/vx5ui10wb4ln/public_html/create/api/log/';
	}
	if (!file_exists($root_log)){
		mkdir($root_log);
	}
	$fh = fopen($root_log . $filename . '.txt', 'w');
	fwrite($fh, $text);
    fclose($fh);
}
