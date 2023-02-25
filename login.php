<?php


require('connectionbdd.php');
?>

<?php
if(!isset($_SESSION))
{
 session_start();
}
?>


<!DOCTYPE html>
<html>
<head>
<?php include('style.php'); ?>
</head>
<body>

<?php include('header.php'); ?>

<!-- Vérification que quelqu'un n'est pas déja connecté --> 
<?php if (isset($_SESSION['active_User'])) {header('Location: Accueil.php');} ?>


<!-- Validation du formulaire -->

<?php
if (isset($_POST['username']) && isset($_POST['password']))
{
    if (!empty($_POST['username']) AND !empty($_POST['password']))
      {
        $username = $_POST['username'];
        $Motsdepasses_Bruts = $db->prepare('SELECT Password FROM users WHERE Username = :Username');
        $Motsdepasses_Bruts-> execute(['Username' => $username]);
        $Motsdepasses_Tries = $Motsdepasses_Bruts->fetchAll();
       if (!empty($Motsdepasses_Tries) && password_verify($_POST['password'], $Motsdepasses_Tries[0][0])) // Affiner avec passwordverify par la suite
          {
          session_start();
          $_SESSION['active_User'] = $_POST['username'];
          header('Location: Accueil.php');
          }
        else
          {
            echo("Il y a une erreur dans votre ID ou votre mot de passe !");
          }
      }
    else 
      {
        echo('Merci de saisir un identifiant ET un mot de passe.');
      }
}

?>


<!-- Formulaire -->

<div id="container">

<form action="" method="post" name="login">
 <h1>Connexion GBAF</h1> 
<!-- utilisateurs -->
<input type="text" class="Identifiant" name="username" placeholder="Nom d'utilisateur">
<!-- mdp -->
<input type="password" class="Mot-de-passe" name="password" placeholder="Mot de passe">
<!-- bouton -->
<input type="submit" value="Connexion " name="submit" class="Bouton">
 <p class="box-register">Vous êtes nouveau ici? <a href="register.php">S'inscrire</a></p> 
</form>

</div>







<?php include('footer.php'); ?>


</body>
</html>