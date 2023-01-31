<?php
session_start();
require('connectionbdd.php');
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
<?php include('header.php'); ?>

<!-- Traitement du formulaire -->

<?php

if (isset($_POST['Username']) AND isset($_POST['Mail']) AND isset($_POST['Password']) AND isset($_POST['Question']) AND isset($_POST['Reponse']))
    {
        if(filter_var($_POST['Mail'], FILTER_VALIDATE_EMAIL, 0) != false)
        {
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
            echo('merci de saisir un mail valide.');
        }
    }
?> 



<!-- Formulaire d'inscription -->

<form class="box" action="" method="post" name="register">
<h1 class="box-title"> Inscription sur GBAF </h1>

<!-- utilisateurs -->
<h2> Saisissez ici votre nom d'utilisateur.</h2>
<input type="text" class="box-input" name="Username" placeholder="Nom d'utilisateur">

<!-- mail -->
<h2> Saisissez ici votre adresse e-mail</h2>
<input type="e-mail" class="box-input" name="Mail" placeholder="Adresse mail">

<!-- mdp -->
<h2> Saisissez ici votre mot de passe</h2>
<input type="password" class="box-input" name="Password" placeholder="Mot de passe">

<!-- Question secrete -->
<h2> Saisissez ici votre question secrete</h2>
<input type="password" class="box-input" name="Question" placeholder="Question secrete">

<!-- Reponse secrete -->
<h2> Saisissez ici votre question secrete</h2>
<input type="password" class="box-input" name="Reponse" placeholder="Question secrete">

<!-- bouton -->
<br>
<br>
<input type="submit" value="Valider " name="submit" class="box-button">

<?php include('footer.php'); ?>

</body>
</html>