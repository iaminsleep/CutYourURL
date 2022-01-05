<?php
  require_once('../requires/admin_functions.php');
  require_once('../requires/default_functions.php');

  if(!$isAdmin) redirect();

  if(isset($_GET['link']) && !empty($_GET['link'])) {
    $longLink = $_GET['link'];
    $link = getLinkInfo($longLink);

    if(empty($link)) {
      $_SESSION['error'] = 'Произошла ошибка';
      redirect('admin/manage_links.php');
    }
  }

  include ('../includes/header_admin.php');
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
				<form action="<?php echo get_url('admin/actions/edit-link.php')?>" method="post">
					<div class="mb-3">
						<label for="link-input" class="form-label">Новая ссылка</label>
						<input type="text" class="form-control is-valid" id="link-input" value="<?php echo $link['long_link'] ?>" required autocomplete="off" name="link">
					</div>
          <input type="hidden" name="link-id" value="<?php echo $link['id']?>">
					<button type="submit" class="btn btn-primary">Редактировать</button>
				</form>
			</div>
		</div>
	</main>
<?php include '../includes/footer.php'; ?>