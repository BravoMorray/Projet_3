<?php
require('connectionbdd.php');
session_start();

if(isset($_POST['Déconnection'])) {
    // Reset variables de session
    session_unset();
    session_destroy();
    // Redirection à l'acceuil
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="style.css" />
</head>
<body>

<div class="Bandeau">
  <div class="Logo"><a href="login.php"><img class="logo_Banque" src="images\logo.png"></a></div> 
  <div class="affichage_Username">
    <?php if(isset($_SESSION['active_User'])) : ?>
      <?php echo($_SESSION['active_User']); ?>
      <img class="logo_Utilisateur" src="images\utilisateur_Logo.png">
      <form method="post">
        <input type="submit" name="Déconnection" value="Déconnection">
      </form>
    <?php endif; ?>
  </div>
</div>

</body>
</html>
