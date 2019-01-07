<?
ob_start();
session_start();
require_once('php/connect_db.php');

$s_card = $_COOKIE;
$data = $_POST;
if (!isset($s_card['card'])) {
	setcookie('card', 0, time() + 3600);
	header("Location: index.php");
}
if (isset($data['submit'])) {
	$to = ''; // e-mail админа
	$subject = "Новый запрос пользователя";
	$message = ' 
<html> 
    <head> 
        <title>Новый запрос пользователя</title> 
    </head> 
    <body> 
        <p> Name: ' . $data['userName'] . '</p> 
        <p> Phone: ' . $data['userPhone'] . '</p>
        <p> Message:' . $data['userMsg'] . '</p>
    </body> 
</html>'; 
mail($to, $subject, $message);
}

?>

<!DOCTYPE HTML>
<html>
<head>
<title>Ювелирный магазин</title>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- jQuery (necessary JavaScript plugins) -->
<script type='text/javascript' src="js/jquery-1.11.1.min.js"></script>

<link href="css/style.css" rel='stylesheet' type='text/css' />

<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Playfair+Display:400,700,900' rel='stylesheet' type='text/css'>
<!-- start menu -->

</head>
<body>
<!-- header_top -->
<div class="top_bg">
	<div class="container">
		<div class="header_top">
			<div class="top_right">
				<ul>
						<li><a href="contact.php">Обратная Связь</a></li>|
						<li><a href="categories.php?id_cat=0">Очки</a></li>|
						<li><a href="categories.php?id_cat=2">Драгоценности</a></li>|
						<li><a href="categories.php?id_cat=1">Часы</a></li>|
						<?php if ($s_card['logged'] == 1): ?>
							<li><a href="adminka.php">Админ панель</a></li>|
							<li><a href="logout.php">Выйти</a></li>|
						<?php else: ?>
							<li><a href="register.php">Войти</a></li>|
						<? endif; ?>

					</ul>
			</div>
			<div class="top_left">
				<h2><span></span> Звоните: +7 (978)-012-34-56</h2>
			</div>
				<div class="clearfix"> </div>
		</div>
	</div>
</div>
<!-- header -->
<div class="header_bg">
<div class="container">
	<div class="header">
	<div class="head-t">
		<div class="logo">
			<a href="index.php"><img src="images/logo.png" class="img-responsive" alt=""/> </a>
		</div>
		<!-- start header_right -->
		<div class="header_right">
			<div class="rgt-bottom">
			<div class="cart box_1">
				<a href="checkout.php">
					<h3> <span class="simpleCart"><? echo $s_card['card'] . ' руб.'; ?></span><img src="images/bag.png" alt=""></h3>
				</a>	
				<div class="clearfix"> </div>
			</div>
			<div class="create_btn">
				<a href="checkout.php">Корзина</a>
			</div>
			<div class="clearfix"> </div>
		</div>
		<div class="clearfix"> </div>
		</div>
		<div class="clearfix"> </div>
	</div>
		<!-- start header menu -->
	</div>
</div>
</div>
<!-- content -->
<div class="container">
<div class="main">
<div class="contact">				
					<div class="contact_info">
						<h2>Мы на карте</h2>
			    	 		<div class="map">
					   			<iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Ac52f69c8c9c363f554d4006677c3ee0ec574d9dd4f2020725b031a234d09f7e8&amp;source=constructor" width="100%" height="400" frameborder="0"></iframe>
					   		</div>
      				</div>
				  <div class="contact-form">
			 	  	 	<h2>Напишите нам!</h2>
			 	 	    <form method="post" action="contact.php">
					    	<div>
						    	<span><label>Имя</label></span>
						    	<span><input name="userName" type="text" class="textbox"></span>
						    </div>
						    <div>
						     	<span><label>Мобильный телефон</label></span>
						    	<span><input name="userPhone" type="text" class="textbox"></span>
						    </div>
						    <div>
						    	<span><label>Текст обращения</label></span>
						    	<span><textarea name="userMsg"> </textarea></span>
						    </div>
						   <div>
						   		<span><input type="submit" name="submit" class="" value="Отправить"></span>
						  </div>
					    </form>
				    </div>
  				<div class="clearfix"></div>		
			  </div>
</div>
</div>

</div>
</body>
</html>