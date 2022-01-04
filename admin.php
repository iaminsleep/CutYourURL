<?php
  include_once 'includes/header_admin.php';
  $errorMessage = get_messages('error');
	$successMessage = get_messages('success');
?>

<main class="container">
  <?php show_alert_messages($errorMessage, $successMessage); ?>
</main>

<?php include_once 'includes/footer.php';?>