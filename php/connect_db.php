<?php 
require_once 'rb-mysql.php';
session_start();
R::setup( 'mysql:host=localhost;dbname=shop_jewelry', 'mysql', 'mysql' );