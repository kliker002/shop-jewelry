<?
ob_start();
session_start();
require_once('php/connect_db.php');

$s_card = $_COOKIE;
$data = $_POST;
$prod = R::findAll('products', 'special_offer = ?', [1]);
if (!isset($s_card['card'])) {
	setcookie('card', 0, time() + 3600);
	header("Location: index.php");
}
if (!isset($s_card['arr_card'])) {
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
					<h3> <span class="simpleCart"><? echo $s_card['card'] . ' руб.'; ?> </span><img src="images/bag.png" alt=""></h3>
				</a>	
				<div class="clearfix"> </div>
			</div>
			<div class="create_btn">
				<a href="checkout.php">Корзина</a>
			</div>
			<div class="clearfix"> </div>
		</div>
		<div class="search">
		    <form>
		    	<input type="text" name="search_btn" style="text-transform: none;" value="" placeholder="search...">
				<input type="submit"name="sbmit_btn"  value="">
			</form>
		</div>
		<div class="clearfix"> </div>
		</div>
		<div class="clearfix"> </div>
	</div>
	
<div class="arriv">
	<div class="container">

		<div class="arriv-las">
			<div class="col-md-4 arriv-left2">
				<img src="images/5.jpg" class="img-responsive" alt="">
				<div class="arriv-info2">
					<a href="categories.php?id_cat=0"><h3>Повседневные очки<i class="ars"></i></h3></a>
				</div>
			</div>
			<div class="col-md-4 arriv-right2">
				<img src="images/6.jpg" class="img-responsive" alt="">
				<div class="arriv-info2">
					<a href="categories.php?id_cat=2"><h3>Драгоценности<i class="ars"></i></h3></a>
				</div>
			</div>
			<div class="col-md-4 arriv-right2">
				<img src="images/7.jpg" class="img-responsive" alt="">
				<div class="arriv-info2">
					<a href="categories.php?id_cat=1"><h3>Лучшие часы<i class="ars"></i></h3></a>
				</div>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
</div>
<?
 if (isset($_GET['sbmit_btn'])) {
	$arr_card = array();
	$id_card = array();
	echo '	<div class="special">
	<div class="container">
	<div class="specia-top">
	<ul class="grid_2">';
	$getProd = R::findAll('products');
	foreach ($getProd as $key => $value) {
		var_dump(stristr(mb_strtolower($value->name), $_GET['search_btn']));
		if (stristr(mb_strtolower($value->name), $_GET['search_btn'])) {
			echo "string";
			$i = $value->id;
			echo '<li><form action="index.php" method="POST">
			<a href="#"><img src="' . $value->img_src . '" class="img-responsive" alt=""></a>
			<div class="special-info grid_1 simpleCart_shelfItem">
			<h5>' . $value->name . '</h5>
			<div class="item_add"><span class="item_price"><h6>Всего ' . $value->cost . ' ₽</h6></span></div>
			<div class="item_add"><input type="submit" class="btn-success btn" name="search_card' . $i . '" value="Добавить в корзину"></div>
			</div>
			</form></li>';
			if (isset($data['search_card' . $i])) {
				$arr_card[] = $value->id;
				$id_card = array_merge($arr_card, unserialize($s_card['arr_card']));

				setcookie('card', $s_card['card'] + $value->cost, time() + 3600);
				setcookie('arr_card', serialize($id_card), time() + 3600); 
				header("Location: index.php?sbmit_btn=&search_btn=" . $_GET['search_btn']);
			}
		}
	}
	echo '		
	<div class="clearfix"> </div>
	</ul>
	</div>
	</div>
	</div>';
}
?>

<div class="special">
	<div class="container">
		<h3>Special Offers</h3>
		<div class="specia-top">
			<ul class="grid_2">
				<?
				$arr_card = array();
				$id_card = array();
				foreach ($prod as $key => $value) {
					$i = $value->id;
					echo '<li><form action="index.php" method="POST">
					<a href="#"><img src="' . $value->img_src . '" class="img-responsive" alt=""></a>
					<div class="special-info grid_1 simpleCart_shelfItem">
					<h5>' . $value->name . '</h5>
					<div class="item_add"><span class="item_price"><h6>Всего ' . $value->cost . ' ₽</h6></span></div>
					<div class="item_add"><input type="submit" class="btn-success btn" name="to-card' . $i . '" value="Добавить в корзину"></div>
					</div>
					</form></li>';
					if (isset($data['to-card' . $i])) {

						$arr_card[] = $value->id;
						$id_card = array_merge($arr_card, unserialize($s_card['arr_card']));
					
						setcookie('card', $s_card['card'] + $value->cost, time() + 3600);
						header("Location: index.php");
						setcookie('arr_card', serialize($id_card), time() + 3600);
						//var_dump(unserialize($s_card['arr_card']));

					}
				}
				
				//var_dump(unserialize($s_card['arr_card']));

				?>
		
		<div class="clearfix"> </div>
	</ul>
		</div>
	</div>
</div>
</body>
</html>