<?php
require('connectionbdd.php');
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="style.css" />
</head>
<style>
    
.banque-card {
    width:80%;
 margin:0 auto;
 margin-bottom : 5%;
 margin-top:5%;
 padding: 30px;
 border: 1px solid #f1f1f1;
 background: #fff;
 box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
 text-align: center;
}

.nom {
    font-weight: bold;
    font-size: 20px;
    margin-top: 10px;
}

.logo {
    height: 100px;
    margin-top: 10px;
}

.description {
    margin-top: 10px;
    font-size: 16px;
}
</style>
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
echo "<div class='banque-card'>";
    echo "<h2 class='nom'>" . $banque['nom'] . "</h2>";
    echo '<img class="logo" src="data:image/png;base64,'.base64_encode($banque['logo']).'">';
    echo "<p class='description'>" . $banque['description'] . "</p>";
echo "</div>";

?>
</body>
</html>

<?php include('footer.php'); ?>