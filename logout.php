<?
ob_start();
session_start();
require_once('php/connect_db.php');
setcookie('logged', 0, time() - 3600);
header("Location: index.php");