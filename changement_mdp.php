<?php
require('connectionbdd.php');
?>

<!-- Sécurité impossible d'accéder si utilisateur connecté -->

<?php
if(!isset($_SESSION))
{
 session_start();
}

if (isset($_SESSION['active_User']))
{
    header('Location: login.php');
    exit();
} 
?>

<!DOCTYPE html>
<html>
<head>
<?php include('style.php'); ?>
<title> Changement de mot de passe </title>
</head>
<body>
<?php include('header.php'); ?>
<div class="changement_mdp">

<?php
if (isset($_POST["submit_reponse"]))
  {
            // Récupération de la reponse 
            $User_req = $db->prepare('SELECT * FROM users WHERE Mail = :Mail');
            $User_req -> execute(['Mail' => $_SESSION["mail"]]);
            $User = $User_req -> fetch();


            if($_POST["reponse"] === $User["Reponse"])
            {
            ?>
            <p> Merci d'avoir répondu, vous pouvez changer votre mot de passe </p> <br>
             <p> Votre nouveau mot de passe : </p>
            <form method="post">
            <input type="password" name="mot_de_passe">
            <button type="submit" name="submit_mot_de_passe">Confirmer</button>
            </form><?php
            }


    }
if (isset($_POST["submit_mot_de_passe"]))
{
    $Requete = 'UPDATE users SET Password = :Password WHERE Mail = :Mail ';
    $Insertion_mot_de_passe = $db->prepare($Requete);
    $Insertion_mot_de_passe->execute([
            'Password' => password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT),
            'Mail' => $_SESSION['mail']
            ]);
header("Location:login.php");
}

?>
</div>


<?php include('footer.php'); ?>

</body>
</html>