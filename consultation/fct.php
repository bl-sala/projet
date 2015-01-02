<?php 
		



function SelectHuile($bd)
{
    try
    {
        $req = $bd->prepare('SELECT DISTINCT nom_propriete FROM proprietes ORDER BY nom_propriete');
        $req->execute();
        while($res = $req->fetch(PDO::FETCH_ASSOC))
            echo '<option> '. $res['nom_propriete'] . '</option>'."\n";
    }
    catch(PDOException $e)
    {
      // On termine le script en affichant le num de l'erreur ainsi que le message 
    die('<p> La connexion a �chou�. Erreur[' .$e->getCode().'] : ' .$e->getMessage() . '</p>');
    }
}
?>

