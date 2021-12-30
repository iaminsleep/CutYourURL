<?php 
	include 'includes/header.php'; 

	if($isAuth) redirect();
	
	$errorMessage = get_error_message();
	$successMessage = get_success_message();

	if(isset($_POST['login']) && !empty($_POST['login'])) {
		/* массив $_POST заполняется также извне (через формы) */
		register_user($_POST);
	}
?>
	<main class="container">
		<?php if (!empty($successMessage)) { ?>
			<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
					<?php echo $successMessage ?>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		<?php } ?>
		<?php if (!empty($errorMessage)) { ?>
			<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
					<?php echo $errorMessage ?>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		<?php } ?>
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
						<input type="text" class="form-control is-valid" id="login-input" name="login" required>
						<div class="valid-feedback">Все ок</div>
					</div>
					<div class="mb-3">
						<label for="password-input" class="form-label">Пароль</label>
						<input type="password" class="form-control is-invalid" id="password-input" name="password" required>
						<div class="invalid-feedback">А тут не ок</div>
					</div>
					<div class="mb-3">
						<label for="password-input2" class="form-label">Пароль еще раз</label>
						<input type="password" class="form-control is-invalid" id="password-input2" name="password-confirm" required>
						<div class="invalid-feedback">И тут тоже не ок</div>
					</div>
					<button type="submit" class="btn btn-primary">Зарегистрироваться</button>
				</form>
			</div>
		</div>
	</main>
<?php include 'includes/footer.php'; ?>
