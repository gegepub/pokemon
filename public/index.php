<?php
    // Entête HTML ce require permet de charger touts les balises
    require_once 'header.php';
    
  	// Fonctions de base
    require_once '../resource/function.php';

	$errors[];
	/*<div class="text-center">
      <img src="../public/img/pokemon.png" alt="" style="width: 30%;">
  	</div>
  	*/

  	// Affichage du lien d'insertion
	<?php echo'<a href='insert.php'> Formulaire pour insertion Pokemon </a>'; ?> 
  	
    
    affiche_pokemons ($errors);


    // Fin du HTML
    require_once 'footer.php';