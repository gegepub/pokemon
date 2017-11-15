<?php
    // Entête HTML ce require permet de charger touts les balises d'entête
    require_once 'header.php';
    
  	// Fonctions de base
    require_once '../resources/function.php';

	$errors=[];
	

  	// Affichage du lien d'insertion
	echo'<a href="insert.php" class="btn btn-primary">Ajouter</a>';  
  	
    
    affiche_pokemons ($errors);


    // Fin du HTML
    require_once 'footer.php';