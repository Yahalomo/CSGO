<?php
		$server   = "213.159.214.75";
		$database = "inventories";
		$username = "site";
		$password = "NAViLRMY7IXa";

		$mysqlConnection = mysql_connect($server, $username, $password);
		if (!$mysqlConnection)
		{
		  //echo "Please try later.";
		}
		else
		{
		//echo "Connected";
		mysql_select_db($database, $mysqlConnection);
		mysql_query("SET NAMES utf8");
		}
		
	$colors = ['rgb(41, 95, 153)','rgb(255, 127, 0)','rgb(255, 255, 0)','rgb(127, 0, 127)','rgb(0, 168, 51)','rgb(255, 0, 0)','rgb(183, 201, 221)','rgb(119, 58, 0)','rgb(112, 148, 187)','rgb(187, 95, 0)','rgb(27, 119, 119)','rgb(255, 85, 0)','rgb(255, 255, 170)','rgb(76, 15, 42)','rgb(255, 255, 85)','rgb(102, 7, 85)','rgb(13, 143, 85)','rgb(255, 42, 0)','rgb(170, 226, 17)','rgb(170, 0, 85)','rgb(85, 197, 34)','rgb(212, 0, 42)'];
	
function logsqlerror($error)
{
	$errortofile=$error."\n\r\n\r";
	$file='logsqlerror.txt';

	// Write the contents of a file,
    // Using the flag FILE_APPEND flag to append content to the file
    // Flag LOCK_EX to prevent the recording of the file someone else at this time
    file_put_contents($file, $errortofile, FILE_APPEND | LOCK_EX);
}

function fetchinfo($rowname,$tablename,$finder,$findervalue) {
	if($finder == "1") $result = mysql_query("SELECT $rowname FROM $tablename");
	else $result = mysql_query("SELECT $rowname FROM $tablename WHERE `$finder`='$findervalue'");
	$row = mysql_fetch_assoc($result);
	return $row[$rowname];
}

function generateCLST($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function convertid($id) {
    if (strlen($id) === 17) {
        $converted = substr($id, 3) - 61197960265728;
    } else {
       return (string) "wrong input";
    }
    return (string) $converted;
}

?>