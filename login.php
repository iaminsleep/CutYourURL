<?php 
	include('includes/header.php');

	if($isAuth) redirect();

	$errorMessage = get_error_message();
	$successMessage = get_success_message();
	
	if(isset($_POST['login']) && !empty($_POST['login']) && isset($_POST['password']) && !empty($_POST['password'])) {
		/* массив $_POST заполняется также извне (через формы) */
		login_user($_POST);
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
				<h2 class="text-center">Вход в личный кабинет</h2>
				<p class="text-center">Если вы еще не зарегистрированы, то самое время <a href="<?php echo get_url('register.php');?>">зарегистрироваться</a></p>
			</div>
		</div>
		<div class="row mt-3">
			<div class="col-4 offset-4">
				<form action="" method="post">
					<div class="mb-3">
						<label for="login-input" class="form-label">Логин</label>
						<input type="text" class="form-control is-valid" id="login-input" required name="login">
					</div>
					<div class="mb-3">
						<label for="password-input" class="form-label">Пароль</label>
						<input type="password" class="form-control is-invalid" id="password-input" required name="password">
					</div>
					<button type="submit" class="btn btn-primary">Войти</button>
				</form>
			</div>
		</div>
	</main>
<?php include 'includes/footer.php'; ?>
