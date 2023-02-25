<?php
require('connectionbdd.php');
?>

<!-- Sécurité impossible d'accéder si utilisateur non connecté -->

<?php
if(!isset($_SESSION))
{
 session_start();
}

if (!isset($_SESSION['active_User']))
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
</head>
<body>
<?php include('header.php'); ?>


<!-- Récupération des informations de l'utilisateur --> 
 
<?php 
$nom_utilisateur = $_SESSION['active_User'];
$requete_informations = $db->prepare('SELECT Username, Mail, Password, Question, Reponse  FROM users WHERE Username = :Username');
$requete_informations->execute(array(':Username' => $nom_utilisateur));
$informations_utilisateur = $requete_informations->fetchAll(); //Récupérer ID user
?>

<!-- Gestion des remplacements en BDD selon changements souhaitées --> 


<?php 
if(isset($_POST['submit_nouveau_nom'])){
    $nouveau_nom = $_POST['nouveau_nom'];
    $_SESSION['active_User'] =  $_POST['nouveau_nom'] ;
    // Mettre à jour le nom d'utilisateur dans la base de données
    $requete_update_nom = $db->prepare('UPDATE users SET Username = :nouveau_nom WHERE Username = :nom_utilisateur');
    $requete_update_nom->execute(array(':nouveau_nom' => $nouveau_nom, ':nom_utilisateur' => $nom_utilisateur));

    // Rediriger l'utilisateur vers la page de modification des paramètres de compte
    header("Location: parametres.php");
}

if(isset($_POST['submit_nouvelle_adresse_mail'])){
    $nouvelle_adresse_mail = $_POST['nouvelle_adresse_mail'];

    // Mettre à jour l'adresse mail dans la base de données
    $requete_update_mail = $db->prepare('UPDATE users SET Mail = :nouvelle_adresse_mail WHERE Username = :nom_utilisateur');
    $requete_update_mail->execute(array(':nouvelle_adresse_mail' => $nouvelle_adresse_mail, ':nom_utilisateur' => $nom_utilisateur));

    // Rediriger l'utilisateur vers la page de modification des paramètres de compte
    header("Location: parametres.php");
}

if(isset($_POST['submit_nouveau_mot_de_passe'])){
    $nouveau_mot_de_passe = $_POST['nouveau_mot_de_passe'];

    // Hasher le nouveau mot de passe
    $nouveau_mot_de_passe_hash = password_hash($nouveau_mot_de_passe, PASSWORD_DEFAULT);

    // Mettre à jour le mot de passe dans la base de données
    $requete_update_mot_de_passe = $db->prepare('UPDATE users SET Password = :nouveau_mot_de_passe_hash WHERE Username = :nom_utilisateur');
    $requete_update_mot_de_passe->execute(array(':nouveau_mot_de_passe_hash' => $nouveau_mot_de_passe_hash, ':nom_utilisateur' => $nom_utilisateur));

    // Rediriger l'utilisateur vers la page de modification des paramètres de compte
    header("Location: parametres.php");
}

if(isset($_POST['submit_nouvelle_question_reponse'])){
    $nouvelle_question = $_POST['nouvelle_question'];
    $nouvelle_reponse = $_POST['nouvelle_reponse'];

    // Mettre à jour la question et la réponse secrète dans la base de données
    $requete_update_question_reponse = $db->prepare('UPDATE users SET Question = :nouvelle_question, Reponse = :nouvelle_reponse WHERE Username = :nom_utilisateur');
    $requete_update_question_reponse->execute(array(':nouvelle_question' => $nouvelle_question, ':nouvelle_reponse' => $nouvelle_reponse, ':nom_utilisateur' => $nom_utilisateur));

    // Rediriger l'utilisateur vers la page de modification des paramètres de compte
    header("Location: parametres.php");
}
?>

<div id="page_parametres">

<h1> Modifier les paramètres de son compte </h1>
<h2> Nom d'utilisateur </h2><br>
Actuel : <?php echo($informations_utilisateur[0]['Username']); ?>
<form method="post">
    Nouveau : <input type="text" name="nouveau_nom">
    <button type="submit" name="submit_nouveau_nom">Enregistrer</button>
</form>
<h2> Adresse mail </h2><br>
Actuel : <?php echo($informations_utilisateur[0]['Mail']); ?>
<form method="post">
    Nouveau : <input type="email" name="nouvelle_adresse_mail">
    <button type="submit" name="submit_nouvelle_adresse_mail">Enregistrer</button>
</form>
<h2> Mot de passe </h2><br>
<form method="post">
    Nouveau : <input type="password" name="nouveau_mot_de_passe">
    <button type="submit" name="submit_nouveau_mot_de_passe">Enregistrer</button>
</form>
<h2> Question & Réponse secrète </h2><br>
Question Actuelle : <?php echo($informations_utilisateur[0]['Question']); ?> <br><br>
Réponse Actuelle : <?php echo($informations_utilisateur[0]['Reponse']); ?>
<br><br>
<form method="post">
    Nouvelle question : <input type="text" name="nouvelle_question">
    <br>
    Nouvelle réponse : <input type="text" name="nouvelle_reponse">

    <button type="submit" name="submit_nouvelle_question_reponse">Enregistrer</button>
</form>

</div>

</body>
</html>

<?php include('footer.php'); ?>