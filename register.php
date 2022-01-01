<?php 
	require_once 'requires/functions.php'; 

	if($isAuth) redirect('profile.php');
	
	$errorMessage = get_messages('error');
	$successMessage = get_messages('success');

	if(isset($_POST['login']) && !empty($_POST['login'])) {
		/* массив $_POST заполняется также извне (через формы) */
		register_user($_POST);
	}

	include_once 'includes/header.php'; 
?>
	<main class="container">
		<?php 
			show_messages($successMessage, 'success');
			show_messages($errorMessage);
		?>
		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Регистрация</h2>
				<p class="text-center">Если у вас уже есть логин и пароль, <a href="<?php echo get_url("login.php");?>">войдите на сайт</a></p>
			</div>
		</div>
		<div class="row mt-3">
			<div class="col-4 offset-4">
				<form action="" method="post">
					<div class="mb-3">
						<label for="login-input" class="form-label">Логин</label>
						<input type="text" class="form-control is-valid" id="login-input" autocomplete="off" name="login" required>
						<div class="valid-feedback">Все ок</div>
					</div>
					<div class="mb-3">
						<label for="password-input" class="form-label">Пароль</label>
						<input type="password" class="form-control is-invalid" id="password-input" autocomplete="off" name="password" required>
						<div class="invalid-feedback">А тут не ок</div>
					</div>
					<div class="mb-3">
						<label for="password-input2" class="form-label">Пароль еще раз</label>
						<input type="password" class="form-control is-invalid" id="password-input2" autocomplete="off" name="password-confirm" required>
						<div class="invalid-feedback">И тут тоже не ок</div>
					</div>
					<button type="submit" class="btn btn-primary">Зарегистрироваться</button>
				</form>
			</div>
		</div>
	</main>
<?php include 'includes/footer.php'; ?>
