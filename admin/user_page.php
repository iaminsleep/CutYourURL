<?php 
	require_once '../requires/admin_functions.php';

	if(!$isAdmin) redirect();

	$errorMessage = get_messages('error');
	$successMessage = get_messages('success');

	$links = get_user_links($_GET['id']);
	$user = db_query("SELECT * FROM `users` WHERE `id` = '".$_GET['id']."'")->fetch();
	$avatar = get_user_avatar($_GET['id']);

	include_once '../includes/header_admin.php';
?>
	<main class="container">
		<?php show_alert_messages($errorMessage, $successMessage); ?>
		<div style="margin-top: 30px; display: flex; flex-direction: row; align-items: center;">
			<div>
				<?php if(file_exists("../img/avatars/".$avatar) && $avatar !== 'noavatar.png'): ?>
					<img src="../img/avatars/<?php echo $avatar?>" width="64" height="64" alt="Аватар пользователя <?php echo $user['login']?>">
				<?php else: ?>
					<img src="../img/avatars/noavatar.png" width="64" height="64" alt="noavatar">
				<?php endif; ?>
			</div>
			<h3 style="padding-left: 15px;">Профиль пользователя <span style="color: lightblue"><?php echo $user['login']?></span></h3>
		</div>
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
					<?php if(empty($links)) { ?>
						<p>Пользователь не создавал ссылки.</p>
					<?php } else { foreach ($links as $index => $link): ?> <!-- Такой мув позволяет выводить порядковый индекс ссылки, т.к id ссылок бывает разным -->
						<tr>
              <th scope="row"><?php echo $index + 1?></th>
                <td><a href="<?php echo $link['long_link']?>" target="_blank"><?php echo $link['long_link']?></a></td>
                <td><?php echo get_url($link['short_link'])?></td>
                <td><?php echo $link['views']?></td>
                <td>
                  <a href="<?php echo get_url('admin/edit_link.php?link='.$link['long_link'])?>" class="btn btn-primary btn-sm" title="Редактировать ссылку"><i class="bi bi-pencil"></i></a>
                  <a href="<?php echo get_url('admin/actions/delete-link.php?id='.$link['id'])?>" class="btn btn-primary btn-sm" title="Удалить ссылку"><i class="bi bi-trash"></i></a>
              </td>
            </tr>
					<?php endforeach; }?>
				</tbody>
			</table>
		</div>
	</main>
<?php include '../includes/footer.php';?>