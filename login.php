<?php 
	require_once 'requires/functions.php';

	if($isAuth) redirect('profile.php');

	if(isset($_POST['login']) && !empty($_POST['login']) && isset($_POST['password']) && !empty($_POST['password'])) {
		/* массив $_POST заполняется также извне (через формы) */
		login($_POST);
	}

	$errorMessage = get_messages('error');
	$successMessage = get_messages('success');

	include_once('includes/header.php');
?>
	<main class="container">
		<?php show_alert_messages($errorMessage, $successMessage); ?>
		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Вход в личный кабинет</h2>
				<p class="text-center">Если вы еще не зарегистрированы, то самое время <a href="<?php echo get_url('register.php');?>">зарегистрироваться</a></p>
			</div>
		</div>
		<div class="row mt-3">
			<div class="col-4 offset-4">
				<form action="" method="post">
					<div class="mb-3">
						<label for="login-input" class="form-label">Логин</label>
						<input type="text" class="form-control" id="login-input" required autocomplete="off" name="login">
						<div class=""></div>
					</div>
					<div class="mb-3">
						<label for="password-input" class="form-label">Пароль</label>
						<input type="password" class="form-control" id="password-input" autocomplete="off" required name="password">
						<div class=""></div>
					</div>
					<button type="submit" class="btn btn-primary">Войти</button>
				</form>
			</div>
		</div>
	</main>
<?php include 'includes/input.php'; ?>
<?php include 'includes/footer.php'; ?>
