<?php
  require_once '../requires/admin_functions.php'; 
  include_once '../includes/header_admin.php';

  
  $errorMessage = get_messages('error');
	$successMessage = get_messages('success');

  $users = getAllUsers();
?>
<main class="container">
  <?php show_alert_messages($errorMessage, $successMessage); ?>
  <a href="javascript:history.back()" class="btn btn-primary" title="Назад" style="margin-top: 20px;">Назад</a>
  <div class="row mt-5" style="margin-top: 2rem!important;">
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Имя пользователя</th>
          <th scope="col">Действия</th>
        </tr>
      </thead>
      <tbody>
        <?php if(empty($users)) { ?>
          <p>Никто ещё не зарегестрировался на вашем сайте!</p>
        <?php } else { foreach ($users as $index => $user): 
            $avatar = get_user_avatar($user['id']);
						if(!file_exists("img/avatars/$avatar"))
							$avatar = 'noavatar.png';
					?>
          <tr>
            <th scope="row"><?php echo $index + 1?></th>
            <td>
              <img src="../img/avatars/<?php echo $avatar?>" width="32" height="32" alt="avatar" style="margin-right: 5px;">
              <?php echo $user['login']?>
            </td>
            <td>
              <a href="<?php echo get_url('admin/edit_link.php?link='.$link['long_link'])?>" class="btn btn-primary" title="Редактировать ссылку">Удалить аватар</a>
              <a href="<?php echo get_url('admin/edit_link.php?link='.$link['long_link'])?>" class="btn btn-primary" title="Редактировать ссылку">Посмотреть ссылки</a>
              <a href="<?php echo get_url('admin/edit_link.php?link='.$link['long_link'])?>" class="btn btn-primary" title="Редактировать ссылку">Удалить пользователя</a>
            </td>
          </tr>
        <?php endforeach; }?>
      </tbody>
    </table>
  </div>
</main>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js"></script>
</body>
</html>

<?php include_once '../includes/footer.php';?>