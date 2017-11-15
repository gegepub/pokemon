<?php

require_once '../resources/database.php';

function fetchToHTMLTable ($query)
{		  
  $table = "";
    
    while ($result = $query->fetch()) {
      // Première ligne : affichage des titres de colonnes
      if ($table == "") {
        $table = "
    <table class=\"table\">
      <thead>
        <tr>
          <th scope=\"col\">
          </th>
          <th scope=\"col\">
          " . implode('</th><th scope=\"col\">', array_keys($result)) . "
          </th>
        </tr>
      </thead>
      <tbody>
        ";
      }
      // Ajout d'une ligne dans la table
      $table .= "
        <tr>
          <td scope=\"row\">
          	<a onclick=\"formSubmit('deletePokemon', 'id_delete', '" . $result['id'] . "');\"><i class=\"fa fa-trash-o fa-fw\" aria-hidden=\"true\"></i></a>
          </td>
          <td>
          " . implode('</td><td>', $result) . "
          </td>
        </tr>
      ";
    }
    
    if($table == "") {
      null;//$errors[] = "Aucune ligne trouvée";
    } else {
      $table .= "
      </tbody>
    </table>
      ";
    }
return $table;

}


function affiche_pokemons (&$errors = array())
{
	$db=connexion ($errors);
	// Affichage des pokemons
    if (!$query = $db->query('
    SELECT pokemon.id, numero, nom, experience, vie, defense, attaque, nom_proprietaire
      FROM pokemon
        LEFT JOIN pokedex ON (id_pokedex = pokedex.id)
    ')) {
      $errors[] = "Erreur lors de la création de la requête";
   }
  
   /*$result = $query->fetchAll(); // n° de ligne et autre tableau avec les noms de colonnes //
   //var_dump ($result);
   
   if (!$result) {
		$errors[].="Il n'existe plus de lignes";
		return false;
   }

   //return "<table></table>";

   /*foreach($result as $tab) {
        echo ('pokemon id : ' . $tab["id"]);
      }
    }*/
   	$resultat = fetchToHTMLTable ($query);
    echo $resultat;

}


 /*
 * formIsSubmit : test si un fomulaire a été soumis
 */
function formIsSubmit($form_name) {
  return (isset($_POST[$form_name]) ? $_POST[$form_name] : '0') === '1';
}

function InsertPokemon () {

// Formulaire d'insertion d'un pokemon

if (formIsSubmit('insertPokemon')) {
      // code d'insertion
      $numero_pokemon = $_POST['numero_pokemon'];
      $nom_pokemon = $_POST['nom_pokemon'];
      $experience_pokemon = $_POST['experience_pokemon'];
      $vie_pokemon = $_POST['vie_pokemon'];
      $defense_pokemon = $_POST['defense_pokemon'];
      $attaque_pokemon = $_POST['attaque_pokemon'];
      //$pokedex_pokemon = $_POST['pokedex_pokemon'];
      // Validation
      if (!filter_var($numero_pokemon, FILTER_VALIDATE_INT, array("options" => array("min_range" => 1)))) {
        $form_errors['numero_pokemon'] = "Le numéro doit être un nombre strictement supérieur à 0";
      }
      if (empty($nom_pokemon)) {
        $form_errors['nom_pokemon'] = "Le nom doit être renseigné";
      } elseif (strlen($nom_pokemon) > 50) {
        $form_errors['nom_pokemon'] = "Le nom doit faire 50 caractères maximum";
      }
      if (!filter_var($experience_pokemon, FILTER_VALIDATE_INT, array("options" => array("min_range" => 0)))) {
        $form_errors['experience_pokemon'] = "L'expérience doit être un nombre supérieur ou égal à 0";
      }
      if (!filter_var($vie_pokemon, FILTER_VALIDATE_INT, array("options" => array("min_range" => 1)))) {
        $form_errors['vie_pokemon'] = "La vie doit être un nombre strictement supérieur à 0";
      }
      if (!filter_var($defense_pokemon, FILTER_VALIDATE_INT, array("options" => array("min_range" => 1)))) {
        $form_errors['defense_pokemon'] = "La défense doit être un nombre strictement supérieur à 0";
      }
      if (!filter_var($attaque_pokemon, FILTER_VALIDATE_INT, array("options" => array("min_range" => 1)))) {
        $form_errors['attaque_pokemon'] = "L'attaque doit être un nombre strictement supérieur à 0";
      }
      /*if (empty($defense_pokemon)) {
        $form_errors['defense_pokemon'] = "La défence doit être renseignée";
      } elseif (!is_int($defense_pokemon)) {
        $form_errors['defense_pokemon'] = "La défense doit être un nombre";
      } elseif ($defense_pokemon <= 0) {
        $form_errors['defense_pokemon'] = "La défense doit être strictement supérieure à 0";
      }*/
      // S'il n'y a pas eu d'erreur ET que la connexion existe
      if (count($form_errors) == 0 && isset($db)) {
        $query = $db->prepare("
          INSERT INTO pokemon(numero,  nom,  experience,  vie,  defense,  attaque)
            VALUES           (:numero, :nom, :experience, :vie, :defense, :attaque)
        ");
        $query->bindParam(':numero', $numero_pokemon, PDO::PARAM_INT);
        $query->bindParam(':nom', $nom_pokemon, PDO::PARAM_STR);
        $query->bindParam(':experience', $experience_pokemon, PDO::PARAM_INT);
        $query->bindParam(':vie', $vie_pokemon, PDO::PARAM_INT);
        $query->bindParam(':defense', $defense_pokemon, PDO::PARAM_INT);
        $query->bindParam(':attaque', $attaque_pokemon, PDO::PARAM_INT);
        
        // exécution de la requête préparée
        try {
          $query->execute();
        } catch(PDOException $e) {
          // Il y a eu une erreur
          /*if ($e->getCode() == "23000")
            $form_errors['nom_proprietaire'] = "Le nom $nom_proprietaire existe déjà !";
          else {
            $form_errors['nom_proprietaire'] = "Erreur lors de l'insertion en base : " . $e->getMessage();
          }*/
          var_dump($e);
        }
      }
    }
 }

?>