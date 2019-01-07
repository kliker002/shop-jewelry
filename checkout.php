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
if (isset($data['start_order'])) {

	$ord = R::dispense('orders');
	$ord->id_product = json_encode(unserialize($s_card['arr_card']));
	R::store($ord);

$product_msg = '';
$price = 0;

foreach ($s_card['arr_card'] as $key => $value) {
	$prods = R::findOne('products','id = ?', [$value]);
	$product_msg = $prods->name . ';';
	$price += $prods->cost;

}
	$to = ''; // e-mail админа
	$subject = "Новый заказ пользователя";
	$message = ' 
<html> 
    <head> 
        <title>Новый заказ пользователя</title> 
    </head> 
    <body> 
        <p> Название товаров: ' . $product_msg . '</p> 
        <p> Цена: ' . $price . '</p>
    </body> 
</html>'; 

mail($to, $subject, $message);

	setcookie('card', 0, time() + 3600);
	setcookie('arr_card', serialize(array()), time() + 3600);
	header("Location: index.php");
}
?>

<!DOCTYPE HTML>
<html>
<head>
	<title>Ювелирный магазин</title>
	<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />

	<script type='text/javascript' src="js/jquery-1.11.1.min.js"></script>

	<link href="css/style.css" rel='stylesheet' type='text/css' />

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Playfair+Display:400,700,900' rel='stylesheet' type='text/css'>
	<!-- start menu -->
	<link href="css/megamenu.css" rel="stylesheet" type="text/css" media="all" />
	<script src="js/menu_jquery.js"></script>
	<script src="js/simpleCart.min.js"> </script>
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
	<div class="container">
		<div class="check">	 
			<div class="col-md-3 cart-total">
				<div class="price-details">
					<h3>Price Details</h3>
					<span>Total</span>
					<span class="total1"><? echo $s_card['card'] . ' руб.'; ?></span>
					<div class="clearfix"></div>				 
				</div>	
				<ul class="total_price">
					<li class="last_price"> <h4>TOTAL</h4></li>	
					<li class="last_price"><span><? echo $s_card['card'] . ' руб.'; ?></span></li>
					<div class="clearfix"> </div>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="col-md-9 cart-items">
				<h1>Корзина</h1>

				<?
				$total = 1;
				$j = 0;
				$card_cook = unserialize($s_card['arr_card']);
				foreach ($card_cook as $key => $value) {
					$product = R::findOne('products','id = ?', [$value]);
					
					echo '<form action="checkout.php" method="POST"><div class="cart-header">
					<input type="submit" value="" name="close' . $j . '" class="close1">
					<div class="cart-sec simpleCart_shelfItem">
					<div class="cart-item cyc">
					<img src="' . $product->img_src . '" class="img-responsive" alt=""/>
					</div>
					<div class="cart-item-info">
					<h3><a href="#">' . $product->name . '</a><span>' . $product->description . '</span></h3>
					<ul class="qty">
					<li><p>Количество :' . $total . '</p></li>
					</ul>

					<div class="delivery">
					<span>Доставка в течение недели.</span>
					<div class="clearfix"></div>
					</div>	
					</div>
					<div class="clearfix"></div>

					</div>
					</div></form>' ;

					if (isset($data['close' . $j])) {
						//echo array_search($value, $card_cook);
						//array_splice($card_cook, 1, array_search($value, $card_cook));
						unset($card_cook[array_search($value, $card_cook)]);
						setcookie('arr_card', serialize($card_cook), time() + 3600);
						header("Location: checkout.php");
						
					}



					$j++;
				}
				

				?>
	<form action="checkout.php" method="POST">
		<input type="submit" class="btn btn-success" name="start_order" value="3аказать">
	</form>
	</div>


	<div class="clearfix"> </div>
</div>
</div>
</body>
</html>