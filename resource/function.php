<?php

 require_once '../resource/database.php';

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

?>