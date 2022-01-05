<?php
  require_once 'requires/admin_functions.php';

  if(!$isAdmin) redirect();
  
  include_once 'includes/header_admin.php';

  $errorMessage = get_messages('error');
	$successMessage = get_messages('success');
?>

<main class="container">
  <div class="admin">
    <div class="admin-block">
      <a class="admin-link" href="admin/manage_links.php">
        <div class="img">
          <img src="img/admin/1.png" alt="Управление ссылками" width="512" height="384">
        </div>
        <h1>Управление ссылками</h1>
      </a>
    </div>
    <div class="admin-block">
      <a class="admin-link second" href="admin/manage_users.php">
        <div class="img">
          <img src="img/admin/2.png" alt="Управление пользователями" width="450" height="384">
        </div>
        <h1>Управление пользователями</h1>
      </a>
    </div>
  </div>
</main>

<?php include_once 'includes/footer.php';?>