<?php
	include 'includes/header.php';

	if(isset($_GET['url']) && !empty($_GET['url'])) {
		/* массив $_GET заполняется извне (через поисковую строку) */
		$url = strtolower(trim($_GET['url']));
		$link = get_link_info($url);

		if(empty($link)) {
			redirect('404.php');
		};

		upd_link_views($url);
		header('Location: ' . $link['long_link']);
		die;
	}
	
	/* db->query() = statement (данные в бинарном виде), а fetchColumn() превращает данные в массив И берёт данные (число) сразу из столбца */
	$usersCount = get_user_count();
	$linksCount = get_links_count();
	$viewsCount = get_links_views();
?>
	<main class="container">
		<?php if(!$isAuth): ?>
			<div class="row mt-5">
				<div class="col">
					<h2 class="text-center">Необходимо <a href="<?php echo get_url("register.php");?>">зарегистрироваться</a> или <a href="<?php echo get_url('login.php');?>">войти</a> под своей учетной записью</h2>
				</div>
			</div>
		<?php endif; ?>
		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Пользователей в системе: <?php echo $usersCount ?></h2>
			</div>
		</div>
		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Ссылок в системе: <?php echo $linksCount ?></h2>
			</div>
		</div>
		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Всего переходов по ссылкам: <?php echo $viewsCount ?></h2>
			</div>
		</div>
	</main>
<?php include 'includes/footer.php'; ?>
