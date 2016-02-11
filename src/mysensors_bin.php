#!/usr/bin/php
<?
require(dirname(__FILE__).'/mysensors.class.php');

$options = "p:hav";
$opts = getopt( $options, array("help") );

//clean argv -----
foreach( $opts as $o => $a ){
	while( $k = array_search( "-" . $o, $argv ) ){
		if($k){
			unset( $argv[$k] );
		}
		if( preg_match( "/^.*".$o.":.*$/i", $options ) ){
			unset( $argv[$k+1] );
		}
	}

}
$argv = array_merge( $argv );


// help ----------------------------------------------------
if(! $argv[1] or isset($opt['h']) or isset($opt['help']) ){
	$script=basename($argv[0]);
	echo <<<EOF
Usage: 
	$script [-p port] [-avh] IP COMMAND
	
	-p port 	: set the gateway port if not 5003
	-a		: send an ACK
	-v 		: verbose (show message sent to gateway)
	-h 		: show this help
	
	IP		: (required) Gateway IP address

	COMMAND		: (required) is one of the following commands:
		- present NODE CHILD TYPE
		- set NODE CHILD TYPE PAYLOAD
		 -req NODE CHILD TYPE
		 -internal NODE CHILD TYPE
		 -internal_get NODE CHILD TYPE

		Using the following parameters :
		- NODE 		: Node ID
		- CHILD		: Child Sensor ID
		- TYPE		: Sub Type
		- PAYLOAD	: value to send
Examples:
	$script 192.168.0.240 set 12 0 V_STATUS 0	
	$script -a 192.168.0.240 present 12 0 V_STATUS 1
	$script -a -p 5002 192.168.0.240 present 12 0 V_TEMP
\n\n
EOF;
	exit(0);
}

function ExitError($mess='Error',$show_help=1){
	global $argv;
	$script=basename($argv[0]);

	echo "Error : $mess\n";
	if($show_help){
		echo "( To get help, type : '$script -h' )";
		//print_r($argv);
	}
	echo "\n\n";
	exit(1);
}

//check every one is set
if(!$argv[1]){ExitError("Missing Gateway IP !");}
if(!$argv[2]){ExitError("Missing Command !");}
if(!isset($argv[3]) or !isset($argv[4]) or !isset($argv[5])){ExitError("Missing Command options !");}


$mys=new MySensorSend($argv[1],$opts['p']);
$ack	= isset($opts['a']) ? 1 : 0;

if($argv[2]=='present'){
	$r=$mys->present($argv[3],$argv[4],$argv[5],$ack);
}
elseif($argv[2]=='set'){
	if(!isset($argv[6])){ExitError("missing paylaod");}
	$r=$mys->set($argv[3], $argv[4], $argv[5], $argv[6], $ack);		
}
elseif($argv[2]=='req'){
	$r=$mys->req($argv[3], $argv[4], $argv[5], $ack);
	echo "$r\n";
	$answer=$mys->getRawAnswer();
}
elseif($argv[2]=='internal'){
	$r=$mys->internal($argv[3], $argv[4], $argv[5], $ack);
}
elseif($argv[2]=='internal_get'){
	$r=$mys->internal_get($argv[3], $argv[4], $argv[5], $ack);
	echo "$r\n";
	$answer=$mys->getRawAnswer();
}
/*
elseif($argv[2]=='stream'){
	$r=$mys->stream($argv[3], $argv[4], $argv[5], $ack);
}
*/
else{
	ExitError("Unknow command '{$argv[2]}' !");
}

$verbose= isset($opts['v']) ? 1:0;
if($verbose){
	echo " - Message : ". $mys->getRawMessage()."\n";
	if($answer){
		echo " - Answer  :  $answer\n";
	}
}

if($r){
	exit(0);
}
else{
	ExitError("Command Failed !!!!\n	Please check Gateway is responding correctly.",0);
}

?>