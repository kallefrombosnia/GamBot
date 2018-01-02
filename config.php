<?php

// QUERY LOGIN INFO
$login_name = 'serveradmin';  	//query login info
$login_password = '7mJEDtKf'; 	// =||=
$ip = 'localhost';            	//ex. 127.0.0.1/ 254.13.121.12 
$query_port = '10011';		  	//default 10011
$virtualserver_port = '9987'; 	//default 9987
$bot_name = 'kalle';          	//bot name
$register_chanel = "2";       	//Channel where is bot going to

$con = mysqli_connect(
"localhost", // HOST
"root", // DATABASE USERNAME
"", // PASSWORD5555
"ts3"); // DATABASE

// GamBot settings
$points = "50"; 				// How much points user gets when he registers DEFAULT: 50 points
$red = "2";						// How much user is gonna win if it rools black DEFAULT: x2				
$black = "2";					// How much user is gonna win if it rools red DEFAULT: x2	
$green = "14";					// How much user is gonna win if it rools green DEFAULT: x14

$lang = "EN";  					// Bot responding launguage




?>