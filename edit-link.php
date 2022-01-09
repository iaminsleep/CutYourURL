<?php
  require_once('requires/functions.php');

  if(!$isAuth) redirect();

  if(isset($_GET['link']) && !empty($_GET['link'])) {
    $shortLink = addslashes($_GET['link']);
    $link = get_link_info($shortLink);

    if(empty($link) || $link['user_id'] !== $_SESSION['user']['id']) {
      $_SESSION['error'] = 'Произошла ошибка';
      redirect('profile.php');
    }
  }

  include ('includes/header_profile.php');
?>
<main class="container">
		<?php show_alert_messages($errorMessage, $successMessage); ?>
		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Редактирование ссылки</h2>
			</div>
		</div>
		<div class="row mt-3">
			<div class="col-4 offset-4">
				<form action="<?php echo get_url('actions/edit_link.php')?>" method="post">
					<div class="mb-3">
						<label for="link-input" class="form-label">Новая ссылка</label>
						<input type="text" class="form-control is-valid" id="link-input" value="<?php echo $link['long_link'] ?>" required autocomplete="off" name="link">
					</div>
          <input type="hidden" name="link-id" value="<?php echo $link['id']?>">
					<button type="submit" class="btn btn-warning">Редактировать</button>
				</form>
			</div>
		</div>
	</main>
<?php include 'includes/footer.php'; ?>