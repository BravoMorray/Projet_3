<?php
require('connectionbdd.php');
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="style.css" />
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

<!-- J'ai écris le css ici car il ne s'actualise pas dans style.css :/ --> 

<style>
  .banque-list {
    width: 80%;
    margin: 0 auto;
    border: 1px solid #f1f1f1;
  }
  
  .banque-card {
    width: 100%;
    margin: 5% 0;
    padding: 30px;
    border: 1px solid #f1f1f1;
    background: #fff;
    box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
    text-align: center;
    display: flex;
    justify-content: space-between;
    align-items: center;
network error
}

.logo {
width: 150px;
height: 150px;
margin-right: 30px;
}

h3.nom {
font-size: 30px;
font-weight: bold;
margin-bottom: 20px;
}

p.description {
font-size: 16px;
font-family: Arial, sans-serif;
}

.banque-link {
text-decoration: none;
color: inherit;
}

.read-more-btn {
padding: 10px 20px;
background-color: #f1f1f1;
border-radius: 25px;
text-align: center;
cursor: pointer;
}

@media only screen and (max-width: 768px) {
.banque-card {
width: 100%;
padding: 15px;
}

.logo {
  width: 100px;
  height: 100px;
}

h3.nom {
  font-size: 20px;
}

p.description {
  font-size: 14px;
}
}

</style>


<!-- Récupération des données de la base de données --> 
<div class="banque-list">
  <?php 
    // Prepare and execute the SQL query
    $res = $db->prepare('SELECT nom, logo, description FROM banques');
    $res->execute();

    // Fetch the results as an associative array
    $images = $res->fetchAll(PDO::FETCH_ASSOC);

    // Loop through the images and display them
    foreach ($images as $img) {
      echo "<div class='banque-card'>";
        echo "<a class='banque-link' href='banque.php?nom=" . urlencode($img['nom']) . "'>";
          echo '<img class="logo" src="data:image/png;base64,'.base64_encode($img['logo']).'">';
          echo "<div>";
            echo "<h3 class='nom'>" . $img['nom'] . "</h3>";
            echo "<p class='description'>" . $img['description'] . "</p>";
          echo "</div>";
        echo "</a>";
        echo "<a href='banque.php?nom=" . urlencode($img['nom']) . "'><div class='read-more-btn'>Lire la suite</div></a>";
      echo "</div>";
    }
  ?>
</div>




</body>
</html>

</body>
</html>


</body>
</html>





<?php include('footer.php'); ?>