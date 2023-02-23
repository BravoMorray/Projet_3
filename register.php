<?php
require('connectionbdd.php');
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


<!-- Vérification de l'adresse mail --> 
<?php
function Mail_Ok(string $mail) : bool
{
require('connectionbdd.php');
$Mail_OK = false;
$Mails_Bruts = $db->prepare('SELECT Mail FROM users WHERE Mail = :Mail');
$Mails_Bruts->execute(['Mail' => $mail]);
$Mails_Tries = $Mails_Bruts->fetchAll();
$var = false;
foreach   ($Mails_Tries as $Mails_Tries)
{
    $var=in_array($mail, $Mails_Tries);
}
if ($var == true)
{return false;}
else
{return true;}
}

?>


<!-- Traitement du formulaire -->

<?php

if (isset($_POST['Username']) AND isset($_POST['Mail']) AND isset($_POST['Password']) AND isset($_POST['Question']) AND isset($_POST['Reponse']))
    {
        if(filter_var($_POST['Mail'], FILTER_VALIDATE_EMAIL, 0) != false)
        {
            if(Mail_OK($_POST['Mail'])) {
            $Requete = 'INSERT INTO users(Username, Mail, Password, Question, Reponse) VALUES(:Username, :Mail, :Password, :Question, :Reponse) ';
            $InsertionUtilisateur = $db->prepare($Requete);
            $InsertionUtilisateur->execute([
            'Username' => $_POST['Username'],
            'Mail' => $_POST['Mail'],
            'Password' => password_hash($_POST['Password'], PASSWORD_DEFAULT),
            'Question' => $_POST['Question'],
            'Reponse' => $_POST['Reponse'],
                ]);
            echo('Bah bravo morray, c est réussi !');
            }
            else
            {
            echo('Cet e mail est déja utilisé');
            }
        }
        else 
        {
            echo('merci de saisir un mail valide.');
        }
    }
?> 



<!-- Formulaire d'inscription -->

<div id="container-2">

<form class="box" action="" method="post" name="register">
<h1 class="box-title"> Inscription sur GBAF </h1>

<!-- utilisateurs -->
 Saisissez ici votre nom d'utilisateur.
<input type="text" class="box-input" name="Username" placeholder="Nom d'utilisateur">

<!-- mail -->
Saisissez ici votre adresse e-mail
<input type="e-mail" class="box-input" name="Mail" placeholder="Adresse mail">

<!-- mdp -->
Saisissez ici votre mot de passe
<input type="password" class="box-input" name="Password" placeholder="Mot de passe">

<!-- Question secrete -->
Saisissez ici votre question secrete
<input type="password" class="box-input" name="Question" placeholder="Question secrete">

<!-- Reponse secrete -->
Saisissez ici votre question secrete
<input type="password" class="box-input" name="Reponse" placeholder="Question secrete">

<!-- bouton -->

<input type="submit" value="Valider " name="submit" class="box-button">

</div>

<?php include('footer.php'); ?>

</body>
</html>