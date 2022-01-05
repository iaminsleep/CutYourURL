<?php
  require_once '../requires/admin_functions.php'; 
  include_once '../includes/header_admin.php';

  $errorMessage = get_messages('error');
	$successMessage = get_messages('success');

  $links = getAllLinks();
?>
<main class="container">
  <?php show_alert_messages($errorMessage, $successMessage); ?>
  <a href="javascript:history.back()" class="btn btn-primary" title="Назад" style="margin-top: 20px;">Назад</a>
  <div class="row mt-5" style="margin-top: 2rem!important;">
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Ориг. ссылка</th>
          <th scope="col">Сокращение</th>
          <th scope="col">Автор ссылки</th>
          <th scope="col">Действия</th>
        </tr>
      </thead>
      <tbody>
        <?php if(empty($links)) { ?>
          <p>Ссылки удалены или ещё не были созданы!</p>
        <?php } else { foreach ($links as $index => $link): ?>
          <tr>
            <th scope="row"><?php echo $index + 1?></th>
            <td><a href="<?php echo $link['long_link']?>" target="_blank"><?php echo $link['long_link']?></a></td>
            <td><?php echo get_url($link['short_link'])?></td>
            <td><?php echo $link['views']?></td>
            <td>
              <a href="<?php echo get_url('admin/edit_link.php?link='.$link['long_link'])?>" class="btn btn-warning btn-sm" title="Редактировать ссылку"><i class="bi bi-pencil"></i></a>
              <a href="<?php echo get_url('admin/actions/delete-link.php?id='.$link['id'])?>" class="btn btn-danger btn-sm" title="Удалить ссылку"><i class="bi bi-trash"></i></a>
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
