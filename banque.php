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
<title> Banque partenaire </title>
</head>
<body>

<?php include('header.php'); ?>

<!-- Récupération des données de la base de données -->
<?php

// Récupérer le nom de l'url
$nom = urldecode($_GET['nom']);

// Préparer la requête correspondante
$res = $db->prepare('SELECT nom, logo, description FROM banques WHERE nom = :nom');
$res->execute(array(':nom' => $nom));

// Mettre en forme les données récupérées
$banque = $res->fetch(PDO::FETCH_ASSOC);

// Afficher les informations correspondantes
echo "<div class='banque-card-2'>";
    echo "<h2 class='nom'>" . $banque['nom'] . "</h2>";
    echo '<img class="logo" alt="logo banque" src="data:image/png;base64,'.base64_encode($banque['logo']).'">';
    echo "<p class='description'>" . $banque['description'] . "</p>";
echo "</div>";

?>

<!-- Commentaires -->


<!-- Création du formulaire d'écriture de commentaire --> 


<!-- Ecriture de commentaire par formulaire  --> 

<div class="comments-box">
<form  method="post">
  <label for="text">Votre commentaire</label>
  <input type="text" id="text" name="text">
  <input type="submit" value="Envoyer">
</form>
</div>

<!-- Envoi du commentaire en BDD --> 

<?php 
if (isset($_POST['text']))
{
    $nom_2 = urldecode($_GET['nom']);
$requete_2 = $db->prepare('SELECT id FROM banques WHERE nom = :nom');
$requete_2->execute(array(':nom' => $nom_2));
$id_banque = $requete_2->fetchColumn(); //Récupérer ID banque
   


    $nom_utilisateur = $_SESSION['active_User'];
    $res_4 = $db->prepare('SELECT ID FROM users WHERE Username = :Username');
    $res_4->execute(array(':Username' => $nom_utilisateur));
    $id_utilisateur = $res_4->fetchColumn(); //Récupérer ID user
    
    // Vérifier qu'il n'existe pas déja un commentaire
    $res_5 = $db->prepare('SELECT contenu FROM commentaires WHERE id_user = :id_user AND id_banque = :id_banque');
    $res_5->execute(array(':id_user' => $id_utilisateur , ':id_banque' => $id_banque));
    $commentaire_existant=$res_5->fetchColumn();
    if ($commentaire_existant == false)
    {
    $insertion = $db->prepare('INSERT INTO commentaires(id_user, id_banque, contenu, date) VALUES(:id_user, :id_banque, :contenu, :date)');
    $date = date('Y-m-d'); 
    $insertion->execute([
        'id_user' => $id_utilisateur,
        'id_banque' => $id_banque,
        'contenu' => $_POST['text'],
        'date' => $date
    ]);
}
    else 
        {
        echo '<script type="text/javascript">'; // Commande qui fait apparaitre un pop-up
        echo 'alert("Vous avez déjà commenté");';
        echo '</script>';
        }
}


?>

<!-- Affichage des upvotes / downvotes -->




<?php
$nom_utilisateur = $_SESSION['active_User'];
$requete_4 = $db->prepare('SELECT ID FROM users WHERE Username = :Username');
$requete_4->execute(array(':Username' => $nom_utilisateur));
$id_utilisateur = $requete_4->fetchColumn(); //Récupérer ID user



$nom_2 = urldecode($_GET['nom']);
$requete_2 = $db->prepare('SELECT id FROM banques WHERE nom = :nom');
$requete_2->execute(array(':nom' => $nom_2));
$id_banque = $requete_2->fetchColumn(); //Récupérer ID banque
   ?>

 <div class="espace_votes">
        <h2>Evaluation de ce partenaire</h2> 
        <form class="vote_formulaire" method="post">
            <label for="upvote">
                <img src="images/upvote.jpeg" alt="Upvote">
            </label>
            <input type="submit" id="upvote" name="vote" value="upvote">
            <label for="downvote">
                <img src="images/downvote.jpeg" alt="Downvote">
            </label>
            <input type="submit" id="downvote" name="vote" value="downvote">
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' & isset($_POST['vote'])) {
            $vote = $_POST['vote'];
            $deja_vote_sql = $db->prepare("SELECT * FROM votes WHERE id_user = :id_user AND id_banque = :id_banque");
            $deja_vote_sql->execute(array(':id_user' => $id_utilisateur, ':id_banque' => $id_banque));
            $deja_vote = $deja_vote_sql->fetch();
            if ($deja_vote) {
                echo "<div class='already-voted'>Vous avez déjà voté</div>";
            } else {
                if ($_POST['vote'] == "upvote") 
                {
                    $vote_sql = $db->prepare("INSERT INTO votes (id_user, id_banque, valeur) VALUES (:id_user, :id_banque, 1)");
                    $vote_sql->execute(array(':id_user' => $id_utilisateur, ':id_banque' => $id_banque));
                    echo "<p>You voted: $vote</p>";
                }
                if ($_POST['vote']=="downvote")
                {
                    $vote_sql = $db->prepare("INSERT INTO votes (id_user, id_banque, valeur) VALUES (:id_user, :id_banque, -1)");
                    $vote_sql->execute(array(':id_user' => $id_utilisateur, ':id_banque' => $id_banque));
                    echo "<p>You voted: $vote</p>";
                }
            }
        }
        ?>
        <!-- Affichage du score -->
        <?php
        $requete_score = $db->prepare("SELECT `valeur` FROM `votes` WHERE `id_banque` = :id_banque");
        $requete_score->execute(array(':id_banque' => $id_banque));
        $scores = $requete_score->fetchAll(PDO::FETCH_COLUMN, 0);
        $total_score = array_sum($scores);
        ?>
        <div class="score">
            <span>Score:</span> <?php echo $total_score; ?>
        </div>
    </div>



<!-- Affichage des commentaires --> 

<!-- Récupération de l'ID banque correspondant -->
<?php 

// Récupérer le nom de l'url
$nom_2 = urldecode($_GET['nom']);

// Préparer la requête correspondante
$requete_2 = $db->prepare('SELECT id FROM banques WHERE nom = :nom');
$requete_2->execute(array(':nom' => $nom_2));

// Mettre en forme les données récupérées
$id_banque = $requete_2->fetchColumn();
?>

<?php
// récupération des commentaires correspondant à la banque
$requete_commentaires = $db->prepare("
    SELECT c.`contenu`, DATE_FORMAT(c.`date`, ' %d/%m/%Y') AS dateCreation, u.`Username`
    FROM `commentaires` c
    JOIN `users` u ON c.`id_user` = u.`ID`
    WHERE c.`id_banque` = :id_banque
");
$requete_commentaires->execute(array(':id_banque' => $id_banque));
$commentaires = $requete_commentaires->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="comments-box">
    <?php
    $nombre = count($commentaires);
    echo '<h2>' . $nombre . ' commentaires</h2>';
    echo '<div style="clear: both;"></div>'; // Crée un espace a taille ajustable entre l'entête et les commentaires
    foreach ($commentaires as $row) {
        echo '<div class="comment-box">';
        echo '<p>Nom : ' . htmlspecialchars($row['Username']) . '</p>';
        echo '<p>Date : ' . htmlspecialchars($row['dateCreation']) . '</p>';
        echo '<p>Texte : ' . htmlspecialchars($row['contenu']) . '</p>';
        echo '</div>';
    }
    ?>
</div>





<?php include('footer.php'); ?>

</body>
</html>