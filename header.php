<?php
require('connectionbdd.php');

if(!isset($_SESSION))
{
 session_start();
}

if(isset($_POST['Déconnection'])) {
    // Reset variables de session
    session_unset();
    session_destroy();
    // Redirection à l'acceuil
    header("Location: login.php");
    exit();
}
?>



<div class="Bandeau">
  <div class="Logo">
    <a href="login.php">
      <img class="logo_Banque" alt="logo banque" src="images/logo.png">
    </a>
  </div> 
  <div class="affichage_Username">
    <?php if(isset($_SESSION['active_User'])) : ?>
      <?php echo($_SESSION['active_User']); ?>  
      <img class="logo_Utilisateur" alt="logo utilisateur" src="images/utilisateur_Logo.png">
      
      <form method="get" action="parametres.php" class="parametres-form">
        <input type="submit" name="Parametres" value="Paramètres">
      </form>

      <form method="post" class="deconnexion-form">
          <input type="submit" name="Déconnection" value="Déconnexion">
      </form>
    <?php endif; ?>
  </div>
</div>


