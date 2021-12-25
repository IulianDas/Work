<?php


$database_connection = new mysqli("127.0.0.1", "root", "",  "images") or die('Connection error!');


$tmp_location = $_FILES['file']['tmp_name'];
$image= $_FILES['file']['name'];


if (!isset($result)) 
    $result = new stdClass();

try {
	if( $imagetype = exif_imagetype($tmp_location)) 
	{
		
		$img_bytes = file_get_contents($tmp_location);
		$imgname = bin2hex(random_bytes($config['imgshare_uidlen']));
	   
	   
	    $safe_imgname = $database_connection->real_escape_string($imgname);
		$safe_imgbytes = $database_connection->real_escape_string($img_bytes);
		$safe_ext = $database_connection->real_escape_string(image_type_to_extension($imagetype, true));
		
    	$query = "INSERT INTO `images` ( `id`, `imagedata`, `ext`) VALUES ('{$safe_imgname}', '{$safe_imgbytes}', '{$safe_ext}')";
		if (!$database_connection->query($query)) 
		{ 
			$result->status = "Error";
			$result->msg = "Couldn't import image to database.";

			echo json_encode($result);
		}
		else
		{
			$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		    
			$result->status = "Success";
			
			$result->msg = dirname($actual_link)."/getImg.php?id=".$imgname;

			echo json_encode($result,JSON_UNESCAPED_SLASHES);
		}
	}
	else
	{
		$result->status = "Error";
		$result->msg = "Unsupported Image Format.";

		echo json_encode($result);
	}
}
catch(Exception $e)
{
	$result->status = "Error";
	$result->msg = "There was a problem uploading your image. Try again later or use smaller sized image.";

	echo json_encode($result);
}
	
?>