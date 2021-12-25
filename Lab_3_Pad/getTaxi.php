<?php

$database_connection = new mysqli("127.0.0.1", "root", "",  "labpad") or die('Connection error!');

if (!isset($result)) 
    $result = new stdClass();

$locatia_p;
if(isset($_GET["locatia_p"]))
{
	$locatia_p = $_GET["locatia_p"];
}
else
{
	$result->status = "Error";
	$result->message = "Please select a location";

	echo json_encode($result,JSON_PRETTY_PRINT);
	exit();
}

try {
	    $db_query = "SELECT * FROM main WHERE locatia_p='{$locatia_p}'";
		$res = $database_connection->query($db_query);
		
		if (!$res) 
		{ 
			$result->status = "Error";
			$result->message = "No pasager with such location.";

			echo json_encode($result,JSON_PRETTY_PRINT);
			exit();
		}
		else
		{
			$taxi=mysqli_fetch_array($res);
			
			$result->status = "Success";
			$result->id = $taxi['id'];
			$result->locatia_m = $taxi['locatia_m'];
			$result->locatia_p = $taxi['locatia_p'];
			$result->pret = $taxi['pret'];
			$result->trimitere = $taxi['trimitere'];
			$result->destinatia = $taxi['destinatia'];

			echo json_encode($result,JSON_PRETTY_PRINT);
		    
		}

}
catch(Exception $e)
{
	$result->status = "Error";
	$result->message = "General Error.";

	echo json_encode($result,JSON_PRETTY_PRINT);
}
	
?>