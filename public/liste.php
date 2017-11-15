<?php
session_start();   // récupération de la session

$id_dresseur = $_SESSION['id'];

// Entête HTML ce require permet de charger toutes les balises d'en-tête de la page HTML
require_once('header.php');

// Fonctions de bases
require_once('../resources/function.php');

echo "<h1>Bienvenue dresseur numéro $id_dresseur</h1>";

// Affichage du lien d'insertion
echo '<a href="insert.php" class="btn btn-primary">Ajouter un pokemon</a>';

// Affichage de la liste des pokemon
affichePokemon();

require_once('footer.php');
