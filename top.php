<?php 
  require_once 'requires/functions.php';

  $users = get_users();

  include 'includes/header.php'; 
?>
<main class="container">
		<div class="row mt-5">
			<?php if(empty($users)) { ?>
				<p class="text-center">Ещё никто не зарегистрировался на нашем сайте. Станьте первым!</p>
			<?php } else { ?>
			<table class="table table-striped">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Пользователь</th>
						<th scope="col">Кол-во ссылок</th>
						<th scope="col">Переходы по ссылкам</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($users as $index => $user): 
						$avatar = get_user_avatar($user['id']);
						if(!file_exists("img/avatars/$avatar"))
							$avatar = 'noavatar.png';
					?>
						<tr>
							<th scope="row"><?php echo $index + 1?></th>
							<td>
								<img src="img/avatars/<?php echo $avatar?>" width="32" height="32" alt="avatar" style="margin-right: 5px;">
								<?php echo $user['login']?>
							</td>
							<td><?php echo get_users_links_count($user['id'])?></td>
							<td><?php echo get_users_views_count($user['id'])?></td>
						</tr>
					<?php endforeach; }?>
				</tbody>
			</table>
		</div>
	</main>
<?php include 'includes/footer.php' ?>