<?php
  require_once '../requires/admin_functions.php'; 

  if(!$isAdmin) redirect();

  include_once '../includes/header_admin.php';

  $errorMessage = get_messages('error');
	$successMessage = get_messages('success');

  $users = getAllUsers();
?>
<style type="text/css">
   td.actions {
      display: flex;
      gap: 30px;
      padding-left: 500px;
   }
</style>
<main class="container">
  <?php show_alert_messages($errorMessage, $successMessage); ?>
  <a href="javascript:history.back()" class="btn btn-primary" title="Назад" style="margin-top: 20px;">Назад</a>
  <div class="row mt-5" style="margin-top: 2rem!important;">
    <?php if(empty($users)) { ?>
      <p class="text-center">Ещё никто не зарегестрировался на вашем сайте!</p>
    <?php } else { ?>
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col" style="padding-left: 30px;">Имя пользователя</th>
          <th scope="col" style="padding-left: 710px;">Действия</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $index => $user): 
          $avatar = get_user_avatar($user['id']);
          if(!file_exists("../img/avatars/$avatar")) $avatar = 'noavatar.png';
        ?>
          <tr>
            <th scope="row"><?php echo $index + 1?></th>
            <td style="padding-left: 30px;">
              <img src="../img/avatars/<?php echo $avatar?>" width="32" height="32" alt="avatar" style="margin-right: 5px;">
              <?php echo $user['login']?>
            </td>
            <td class="actions">
              <a href="<?php echo get_url('admin/actions/delete-avatar.php?id='.$user['id'])?>" class="btn btn-primary" title="Удалить аватар" onclick="return  confirm('Вы уверены, что аватар пользователя <?php echo $user['login']?> нарушает политику сайта?')">Удалить аватар</a>
              <a href="<?php echo get_url('admin/user_page.php?id='.$user['id'])?>" class="btn btn-primary" title="Посмотреть ссылки">Посмотреть ссылки</a>
              <a href="<?php echo get_url('admin/actions/delete-user.php?id='.$user['id'])?>" class="btn btn-primary" title="Удалить пользователя" onclick="return confirm('Вы уверены, что хотите удалить пользователя <?php echo $user['login']?>?')">Удалить пользователя</a>
            </td>
          </tr>
        <?php endforeach; }?>
      </tbody>
    </table>
  </div>
</main>
<button class="btn btn-primary btn-side" title="Открыть памятку для админа">Памятка</button>
  <div id="popup" class="popup">
    <span class="popup-close">&times;</span>
    <h2>Modal Title</h2>
    <p class="description">Modal Description</p>
  </div>
  <script src="../js/modal.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js"></script>
</body>
</html>

<?php include_once '../includes/footer.php';?>