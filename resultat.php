<?php 
	require('connexion.php'); //Permet la connexion à la base de données
	require('entete.php'); //En-tête html
	require('fct.php'); //Ensemble de fonctions php
?>



<?php

$filtres = array();

if(isset($_POST['requete']) && isset($_GET['propriete']))
{
    $_POST['requete'] = intval($_POST['requete']);
    
    
    if(isset($_POST['requete']) != "")
    {    
        $filtres[':requete'] = $_POST['requete'];
        
    }
    
    
    if(trim($_POST['propriete']) != "" and $_POST['propriete']!='tous')
        $filtres[':propriete'] = $_POST['propriete'];
}
?>
<?php
	
			$requete = htmlspecialchars($_POST['requete']);
			
/* ont compte s'il y a bien des huiles qui corresponde a la recherche via le formulaire */
$req = $bd->prepare("SELECT COUNT(*) as nb FROM huiles WHERE nom_huile LIKE \"%$requete%\" OR nom_latin LIKE \"%$requete%\" ");

$req->execute(array());
$resultat = $req->fetch();

/* S'il n'y a rien on préviens l'utilisateur*/
if ($resultat['nb'] == 0) {
  echo 'Aucun produits trouvé pour votre recherche : '.$requete;
} else {
/* S'il y a des enregistremets on affiche */
 $sql = 'SELECT * FROM huiles natural join proprietes natural join huiles_proprietes';
        if(isset($filtres[':requete']))
        {
            $sql .= ' WHERE nom_huile LIKE \"%$requete%\" OR nom_latin LIKE \"%$requete%\" ';
            
           
            
        }
        if(isset($filtres[':propriete']))
        {
            
                $sql .= ' AND WHERE nom_propriete = :propriete';
            
        }
        
        $req2 = $bd->prepare($sql);
  $req2->execute(array());
  while ($donnees = $req2->fetch()) {
    // ICI C'EST LE LIEN
    echo '<a href="fiche_produit.php?produit='.$donnees['id_huile'].'">'.$donnees['nom_huile'].'</a> <br/>';
  } //Fin while 
} //Fin else

?>




<?php require('fin.php'); ?>