<?php 
	require_once 'requires/admin_functions.php';
?>
<?php if ($isAdmin): ?>
	<!doctype html>
	<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport"
					content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
		<link rel="icon" type="image/png" href="img/icons/favicon.png">
		<link rel="stylesheet" href="../css/style-fix.css">
		<title>Админка сайта</title>
	</head>
	<body style="background: #121212; color: #FFFFFF">
		<header>
			<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
				<div class="container">
					<img src="img/icons/favicon.png" width="30" height="30" alt="Cut Your URL logo" style="margin-right: 10px;">
					<a class="navbar-brand" href="<?php echo get_url('admin.php');?>"><?php echo SITE_NAME;?></a>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav me-auto mb-2 mb-lg-0" style="padding-left: 30px;">
							<li class="nav-item" style="padding-right: 10px;">
								<a class="nav-link active" aria-current="page" href="<?php echo get_url('admin.php');?>">Главная</a>
							</li>
							<li class="nav-item" style="padding-right: 10px;">
								<a class="nav-link active" href="<?php echo get_url('admin/manage_links.php');?>">Управление ссылками</a>
							</li>
							<li class="nav-item" style="padding-right: 10px;">
								<a class="nav-link active" href="<?php echo get_url('admin/manage_users.php');?>">Управление пользователями</a>
							</li>
						</ul>
						<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
							<li class="nav-item">
								<a href="<?php echo get_url('actions/logout.php');?>" class="btn btn-primary">Выйти</a>
							</li>
						</ul>
					</div>
				</div>
			</nav>
		</header>
<?php endif; ?>