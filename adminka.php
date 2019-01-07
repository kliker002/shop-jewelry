<?
ob_start();
session_start();
require_once('php/connect_db.php');
$data = $_POST;
$s_card = $_COOKIE;
$data = $_POST;
if (!isset($s_card['card'])) {
	setcookie('card', 0, time() + 3600);
	header("Location: index.php");
}
if (isset($data['add_prod'])) {

    $upload = 'images/'.$_FILES['img_src']['name'];
    move_uploaded_file($_FILES['img_src']['tmp_name'], $upload);


	$prods = R::dispense('products');
	$prods->name = $data['name'];
	$prods->img_src = $upload;
	$prods->description = $data['description'];
	$prods->cost = $data['cost'];
	$prods->catigories = $data['categories'];
	R::store($prods);
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Ювелирный магазин</title>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- jQuery (necessary JavaScript plugins) -->
<script type='text/javascript' src="js/jquery-1.11.1.min.js"></script>
<!-- Custom Theme files -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<!-- Custom Theme files -->
<!--//theme-style-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Playfair+Display:400,700,900' rel='stylesheet' type='text/css'>
<!-- start menu -->
<link href="css/megamenu.css" rel="stylesheet" type="text/css" media="all" />

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

<div class="arriv">
	<div class="container">

		<div class="col-md-12">
			<form action="adminka.php" method="POST">
				<strong>Создание нового пользователя</strong>
				<input type="text" placeholder="Login" >
				<input type="password" placeholder="Pass">
				<input type="submit" name="add_user" class="btn btn-success" value="Добавить">
			</form>
			<hr>
		</div>
		<div class="col-md-12" style="text-align: center;">
			<strong>Добавить новый товар</strong>
		</div>
		<div class="col-md-12">
			<form action="adminka.php" method="POST" enctype="multipart/form-data">
				<input type="text" class="form-control" name="name" placeholder="name" >
				<input type="file" class="form-control" name="img_src">
				<input type="text" class="form-control" name="description" placeholder="Description">
				<input type="number" class="form-control" name="cost" placeholder="цена" >
				<input type="text" class="form-control" name="categories" placeholder="очки(0), часы(1), драгоценности(2)" >
				<input type="submit" name="add_prod" class="btn btn-success" value="Добавить">
			</form>
		</div>
	</div>
</div>


</div>
</body>
</html>