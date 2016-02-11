<?
require(dirname(__FILE__).'/src/mysensors.class.php');

$ip			='10.1.7.40';
$mys=new MySensorSend($ip);

// fetching the Gateway Version -------------------------------
echo "Gateway version is : ";
echo $mys->internal_get(0, 0, 'I_VERSION');
echo " <br>\n";
DisplayMessages(1);


echo "<hr>\n\n";

// Sending a message to a node -------------------------------

$node_id	='199';
$child_id	='0';
$type		='V_STATUS';
$payload	=1;

echo "Sending $type=$payload to node $node_id , child $child_id";
echo $mys->set($node_id, $child_id,$type,$payload);
echo " <br>\n";
DisplayMessages(0);



//-----------------------------------------------
function DisplayMessages($with_answer=0){
	global $mys;
	echo " - Message sent : ".$mys->GetRawMessage() ." <br>\n";
	if($with_answer){
		echo " - Answer received : ".$mys->GetRawAnswer()." <br>\n";;
	}
	echo "\n";
}

?>