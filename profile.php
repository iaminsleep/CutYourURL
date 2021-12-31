<?php 
	include 'includes/header_profile.php';

	if(!$isAuth) redirect();

	$errorMessage = get_error_message();
	$successMessage = get_success_message();

	$links = get_user_links($_SESSION['user']['id']);
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
			<table class="table table-striped">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Ссылка</th>
						<th scope="col">Сокращение</th>
						<th scope="col">Переходы</th>
						<th scope="col">Действия</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($links as $index => $link): ?> <!-- Такой мув позволяет выводить порядковый индекс ссылки, т.к id ссылок бывает разным -->
						<tr>
							<th scope="row"><?php echo $index + 1?></th> <!-- +1 нужен т.к элементы в массиве начинаются с нуля -->
							<td><a href="<?php echo $link['long_link']?>" target="_blank"><?php echo $link['long_link']?></a></td>
							<td class="short-link"><?php echo get_url($link['short_link'])?></td>
							<td><?php echo $link['views']?></td>
							<td>
								<button class="btn btn-primary btn-sm copy-btn" title="Скопировать в буфер" data-clipboard-text="<?php echo get_url($link['short_link'])?>"><i class="bi bi-files"></i></button>
								<a href="<?php echo get_url('actions/edit_link.php?id='.$link['id'])?>" class="btn btn-warning btn-sm" title="Редактировать"><i class="bi bi-pencil"></i></a>
								<a href="<?php echo get_url('actions/delete_link.php?id='.$link['id'])?>" class="btn btn-danger btn-sm" title="Удалить"><i class="bi bi-trash"></i></a>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</main>
	<div aria-live="polite" aria-atomic="true" class="position-relative">
		<div class="toast-container position-absolute top-0 start-50 translate-middle-x">
			<div class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
				<div class="d-flex">
					<div class="toast-body">
						Ссылка скопирована в буфер
					</div>
					<button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
				</div>
			</div>
		</div>
	</div>
<?php include 'includes/footer_profile.php';?>