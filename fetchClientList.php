<?php
session_start();
if ( !isset($_SESSION['login']) || $_SESSION['login'] !== true) 
		{
		// header('Location: login/index.php');
		// exit;
		}
else    {
		$user=$_SESSION['username'];
		}
header('Content-Type: application/json');
require 'dateHuman.php';
include("login/db.php");
$mysqli = new mysqli($server, $db_user, $db_pwd, $db_name);
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: " . $mysqli->connect_error;
	}	
mysqli_set_charset($mysqli,"utf8");
date_default_timezone_set('America/Bogota');
$today = date("Y-m-d");   
$convertdate= date("d-m-Y" , strtotime($today));
$hourMin = date('H:i');
$list []= array("id"=>"1","cliente"=>"Primer cliente","ip"=>"192.168.1.1","recibe"=>"alguien recibe","fecha"=>"2017/06/15","email"=>"omar_alberto_h@yahoo.es","direccion"=>"Cra 9#13-47","telefono"=>"3215450397");
$list[]=["id"=>"2","cliente"=>"Segundo cliente","ip"=>"192.168.1.2","recibe"=>"Otro recibe","fecha"=>"2017/06/16","email"=>"omar_alberto_h@gmail.com","direccion"=>"Cra 9#13-42","telefono"=>"3147654655"];
$jsonList=json_encode($list);
echo $jsonList;



 







?>