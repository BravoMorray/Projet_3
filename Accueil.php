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
<body>
<?php include('header.php'); ?>
<div id="container-3">
<h1>  Bienvenue sur la base GBAF </h1>
<p> Vous retrouverez sur ce site des ressources sur les principales banques Françaises. Il vous sera possible de laisser un commentaire sur chacune des banques présentées ici ainsi que de les noter au moyen de pouces en haut ou pouce en bas. Vous pourrez également consulter les votes et commentaires des autres inscrits sur le site ! 
	Bonne visite sur le site GBAF In porta lorem a orci pretium aliquam. Sed elementum ultricies diam, in suscipit magna condimentum id. Nam quis sodales nisl, a vehicula libero. In at interdum dui, a commodo nibh. Cras sollicitudin nunc ac tellus cursus, nec porta tortor mollis. Aliquam sodales nulla ut ligula tristique, at interdum leo commodo. Etiam ullamcorper eleifend dictum. Vivamus vitae ex posuere, finibus ligula at, pharetra diam. Vivamus libero ex, gravida nec libero ac, ornare rutrum velit. Mauris id lacus ut dolor auctor dapibus. Aliquam tellus tortor, interdum ut blandit et, congue volutpat augue. Aliquam nec velit libero. Maecenas quis sapien ullamcorper, blandit orci suscipit, dapibus odio. Aenean turpis augue, euismod sit amet maximus at, auctor eget nisi. Pellentesque lobortis nec lacus vitae cursus. Vivamus eleifend erat eu egestas interdum. </p>

<img src="images\logo.png">

<h2>  Découvrez nos principaux acteurs et partenaires !  </h2>

<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nulla et commodo nunc, eget ullamcorper diam. Praesent sagittis ipsum sem, id laoreet justo aliquet quis. Maecenas sagittis nisl at purus semper volutpat id quis nibh. Aliquam at maximus nisl, et hendrerit sem. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In vel mi lectus. Donec efficitur eros nec dictum mollis. Duis sit amet nisl rutrum, ornare nunc ut, mattis est. Donec gravida porttitor eros eu laoreet. Curabitur consectetur ex neque, sed sagittis felis rhoncus quis. Pellentesque sed euismod risus. Nullam placerat, purus ut tincidunt tempus, nibh quam auctor orci, eu vulputate ipsum metus quis libero. Proin ullamcorper augue vitae urna congue, sed rutrum massa pulvinar.</p>

</div>


<!-- Récupération des données de la base de données --> 
<div class="banque-list">
  <?php 
    // Préparation de la requete sql
    $res = $db->prepare('SELECT nom, logo, description FROM banques');
    $res->execute();
    // Fetch des résultats
    
$banques = $res->fetchAll(PDO::FETCH_ASSOC);

// Boucle sur chaque image et affichage correspondant au cahier des charges
foreach ($banques as $banque) { ?>
    <a class='banque-link' href="banque.php?nom=<?= urlencode($banque['nom']) ?>">
        <div class='banque-card'>
            <div>
                <img class="logo" src="data:image/png;base64,<?= base64_encode($banque['logo']) ?>">
            </div>

            <div>
                <h3 class='nom'> <?= htmlspecialchars($banque['nom']); ?></h3>
                <p class='description'><?= htmlspecialchars($banque['description']); ?></p>
            </div>

            <div class='read-more-btn'>
                Lire la suite
            </div>  

        </div>
    </a>
<?php } ?>



</body>
</html>





<?php include('footer.php'); ?>