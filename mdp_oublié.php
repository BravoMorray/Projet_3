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
</head>
<body>
<?php include('header.php'); ?>
<div class="mdp_oublie">
<h2> Vous avez oublié votre mot de passe ? </h2>
<p> Saisissez les informations suivantes pour le changer <p>


<h2>Votre adresse mail : </h2><br>

<form method="post">
    <input type="email" name="adresse_mail">
    <button type="submit" name="submit_adresse_mail">Confirmer</button>
</form>

<!-- Traitement du formulaire -->

<?php 

if (isset($_POST["submit_adresse_mail"]))
{
    $_SESSION["mail"] = $_POST["adresse_mail"];
    if(Mail_Exist($_SESSION["mail"]))
    {
        $Question_associee = $db->prepare('SELECT Question FROM users WHERE Mail = :Mail');
        $Question_associee -> execute(['Mail' => $_SESSION["mail"]]);
        $Question = $Question_associee -> fetch();
        ?>
        <p> Merci de répondre à votre question secrète </p> <br>
        <p> Votre question : </p>
        <p> <?php echo($Question[0]); ?> </p> 
        <form method="post" action="changement_mdp.php">
        <input type="text" name="reponse">
        <input type="hidden" name="email" value="<?= htmlspecialchars($_SESSION["mail"]) ?>">
        <button type="submit" name="submit_reponse">Réponse secrète</button>
        </form><?php

    }

}

?> 



<!-- Vérification d'adrsse mail --> 

<?php
function Mail_Exist(string $mail) : bool
{
require('connectionbdd.php');
$Mail_OK = false;
$Mails_Bruts = $db->prepare('SELECT Mail FROM users WHERE Mail = :Mail');
$Mails_Bruts->execute(['Mail' => $mail]);
$Mails_Tries = $Mails_Bruts->fetch();
if ($Mails_Tries == true)
{return true;}
else
{return false;}
}

?>

</div>

<?php include('footer.php'); ?>

</body>
</html>