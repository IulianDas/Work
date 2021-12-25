<?php

$database_connection = new mysqli("127.0.0.1", "root", "",  "labpad") or die('Connection error!');

if (!isset($result)) 
    $result = new stdClass();

if(!isset($_POST['locatia_m']) || !isset($_POST['locatia_p']) || !isset($_POST['pret']) || !isset($_POST['trimitere']) || !isset($_POST['destinatia']))
{
	$result->status = "Error";
	

	echo json_encode($result);
	exit();
}


try {
	
    	$db_query = "INSERT INTO `main` (`locatia_m`, `locatia_p`, `pret`, `trimitere`, `destinatia`) VALUES ('{$_POST['locatia_m']}', '{$_POST['locatia_p']}', '{$_POST['pret']}', '{$_POST['trimitere']}', '{$_POST['destinatia']}')";

		if (!$database_connection->query($db_query)) 
		{ 
			$result->status = "Error";
			

			echo json_encode($result);
		}
		else
		{
			
		    
			$result->status = "Success";
			
			//$db_query = "SELECT * FROM studenti WHERE id={$id}";
			
			//$result->id = $database_connection->insert_id;

			echo json_encode($result,JSON_UNESCAPED_SLASHES);
		}
	
}
catch(Exception $e)
{
	$result->status = "Error";
	

	echo json_encode($result);
}
	
?>