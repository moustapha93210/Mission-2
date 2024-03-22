<?php
namespace App\MyApp;
use PDO;
use Illuminate\Support\Facades\Config;
class PdoGsb{
        private static $serveur;
        private static $bdd;
        private static $user;
        private static $mdp;
        private  $monPdo;

/**
 * crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */
	public function __construct(){

        self::$serveur='mysql:host=' . Config::get('database.connections.mysql.host');
        self::$bdd='dbname=' . Config::get('database.connections.mysql.database');
        self::$user=Config::get('database.connections.mysql.username') ;
        self::$mdp=Config::get('database.connections.mysql.password');
        $this->monPdo = new PDO(self::$serveur.';'.self::$bdd, self::$user, self::$mdp);
  		$this->monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct(){
		$this->monPdo =null;
	}


/**
 * Retourne les informations d'un visiteur

 * @param $login
 * @param $mdp
 * @return l'id, le nom et le prénom sous la forme d'un tableau associatif
*/
	public function getInfosVisiteur($login, $mdp){
		$req = "SELECT visiteur.id as id, visiteur.nom as nom, visiteur.prenom as prenom, visiteur.typeUser as type
        FROM visiteur
        WHERE visiteur.login= '" . $login . "' and visiteur.mdp = '" . $mdp ."' ";

        var_dump($req);

    	$rs = $this->monPdo->query($req);

		$ligne = $rs->fetch();
		return $ligne;
	}



/**
 * Retourne sous forme d'un tableau associatif toutes les lignes de frais au forfait
 * concernées par les deux arguments

 * @param $idVisiteur
 * @param $mois sous la forme aaaamm
 * @return l'id, le libelle et la quantité sous la forme d'un tableau associatif
*/
	public function getLesFraisForfait($idVisiteur, $mois){
		$req = "select fraisforfait.id as idfrais, fraisforfait.libelle as libelle,
		lignefraisforfait.quantite as quantite from lignefraisforfait inner join fraisforfait
		on fraisforfait.id = lignefraisforfait.idfraisforfait
		where lignefraisforfait.idvisiteur ='$idVisiteur' and lignefraisforfait.mois='$mois'
		order by lignefraisforfait.idfraisforfait";
		$res = $this->monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}
/**
 * Retourne tous les id de la table FraisForfait

 * @return un tableau associatif
*/
	public function getLesIdFrais(){
		$req = "select fraisforfait.id as idfrais from fraisforfait order by fraisforfait.id";
		$res = $this->monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}

    public function getLesIdVisiteurs()
    {
        $sql = "SELECT id, nom, prenom
        FROM visiteur
        WHERE typeUser = 1
        order by id";

        $stmt = $this->monPdo->prepare($sql);

        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //$lesCles = array_keys($results);
        //dd($lesCles);

        return $results;
    }

    public function getModificationFicheFrais($mois, $nbJustificatifs, $montantValide, $dateModif, $idEtat, $idVisiteur)
    {
        $sql = "UPDATE `fichefrais`
		SET `mois`= ?,`nbJustificatifs`= ?,`montantValide`= ?,`dateModif`= ?,`idEtat`= ?
		WHERE `idVisiteur` = ?";

        //dd($sql);

        $stmt = $this->monPdo->prepare($sql);
        //dd($stmt);


        $stmt->bindValue(1, $mois, PDO::PARAM_STR);
        $stmt->bindValue(2, $nbJustificatifs, PDO::PARAM_STR);
        $stmt->bindValue(3, $montantValide, PDO::PARAM_STR);
        $stmt->bindValue(4, $dateModif, PDO::PARAM_STR);
        $stmt->bindValue(5, $idEtat, PDO::PARAM_STR);
        $stmt->bindValue(6, $idVisiteur, PDO::PARAM_STR);




        $stmt->execute();
        //dd($stmt);
        echo" <br> ";
        var_dump($stmt);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo" <br> ";
        var_dump($results);


        return $results;

    }
/**
 * Met à jour la table ligneFraisForfait

 * Met à jour la table ligneFraisForfait pour un visiteur et
 * un mois donné en enregistrant les nouveaux montants

 * @param $idVisiteur
 * @param $mois sous la forme aaaamm
 * @param $lesFrais tableau associatif de clé idFrais et de valeur la quantité pour ce frais
 * @return un tableau associatif
*/
	public function majFraisForfait($idVisiteur, $mois, $lesFrais){
		$lesCles = array_keys($lesFrais);
		foreach($lesCles as $unIdFrais){
			$qte = $lesFrais[$unIdFrais];
			$req = "update lignefraisforfait set lignefraisforfait.quantite = $qte
			where lignefraisforfait.idvisiteur = '$idVisiteur' and lignefraisforfait.mois = '$mois'
			and lignefraisforfait.idfraisforfait = '$unIdFrais'";
			$this->monPdo->exec($req);
		}

	}

/**
 * Teste si un visiteur possède une fiche de frais pour le mois passé en argument

 * @param $idVisiteur
 * @param $mois sous la forme aaaamm
 * @return vrai ou faux
*/
	public function estPremierFraisMois($idVisiteur,$mois)
	{
		$ok = false;
		$req = "select count(*) as nblignesfrais from fichefrais
		where fichefrais.mois = '$mois' and fichefrais.idvisiteur = '$idVisiteur'";
		$res = $this->monPdo->query($req);
		$laLigne = $res->fetch();
		if($laLigne['nblignesfrais'] == 0){
			$ok = true;
		}
		return $ok;
	}
/**
 * Retourne le dernier mois en cours d'un visiteur

 * @param $idVisiteur
 * @return le mois sous la forme aaaamm
*/
	public function dernierMoisSaisi($idVisiteur){
		$req = "select max(mois) as dernierMois from fichefrais where fichefrais.idvisiteur = '$idVisiteur'";
		$res = $this->monPdo->query($req);
		$laLigne = $res->fetch();
		$dernierMois = $laLigne['dernierMois'];
		return $dernierMois;
	}

/**
 * Crée une nouvelle fiche de frais et les lignes de frais au forfait pour un visiteur et un mois donnés

 * récupère le dernier mois en cours de traitement, met à 'CL' son champs idEtat, crée une nouvelle fiche de frais
 * avec un idEtat à 'CR' et crée les lignes de frais forfait de quantités nulles
 * @param $idVisiteur
 * @param $mois sous la forme aaaamm
*/
	public function creeNouvellesLignesFrais($idVisiteur,$mois){
		$dernierMois = $this->dernierMoisSaisi($idVisiteur);
		$laDerniereFiche = $this->getLesInfosFicheFrais($idVisiteur,$dernierMois);
		if($laDerniereFiche['idEtat']=='CR'){
				$this->majEtatFicheFrais($idVisiteur, $dernierMois,'CL');

		}
		$req = "insert into fichefrais(idvisiteur,mois,nbJustificatifs,montantValide,dateModif,idEtat)
		values('$idVisiteur','$mois',0,0,now(),'CR')";
		$this->monPdo->exec($req);
		$lesIdFrais = $this->getLesIdFrais();
		foreach($lesIdFrais as $uneLigneIdFrais){
			$unIdFrais = $uneLigneIdFrais['idfrais'];
			$req = "insert into lignefraisforfait(idvisiteur,mois,idFraisForfait,quantite)
			values('$idVisiteur','$mois','$unIdFrais',0)";
			$this->monPdo->exec($req);
		 }
	}


/**
 * Retourne les mois pour lesquel un visiteur a une fiche de frais

 * @param $idVisiteur
 * @return un tableau associatif de clé un mois -aaaamm- et de valeurs l'année et le mois correspondant
*/
	public function getLesMoisDisponibles($idVisiteur){
		$req = "select fichefrais.mois as mois from  fichefrais where fichefrais.idvisiteur ='$idVisiteur'
		order by fichefrais.mois desc ";
		$res = $this->monPdo->query($req);
		$lesMois =array();
		$laLigne = $res->fetch();
		while($laLigne != null)	{
			$mois = $laLigne['mois'];
            //dd($mois);
			$numAnnee =substr( $mois,0,4);
			$numMois =substr( $mois,4,2);
			$lesMois["$mois"]=array(
		     "mois"=>"$mois",
		    "numAnnee"  => "$numAnnee",
			"numMois"  => "$numMois"
             );
			$laLigne = $res->fetch();
		}
		return $lesMois;
	}


    public function getLesMoisDisponibles2()
    {
        $sql = "SELECT mois
        FROM fichefrais
        INNER JOIN visiteur ON fichefrais.idVisiteur = visiteur.id
        WHERE typeUser = 1
        ORDER BY mois DESC";

        $stmt = $this->monPdo->prepare($sql);

        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);



        $lesMois =array();

        foreach ($results as $row)
        {
            $mois = $row['mois'];
            //dd($row['mois']);
            //echo "mois : " . $mois;

            $numAnnee =substr( $mois,0,4);
            //dd($numAnnee);
            //echo "numAnnee : " . $numAnnee;

            $numMois =substr( $mois,4,2);

            $lesMois["$mois"]=array(
                "mois"=>"$mois",
                "numAnnee"  => "$numAnnee",
                "numMois"  => "$numMois"
            );

        }
        return $lesMois;


    }


    public function getLesMoisDisponibles3($id)
    {
        $sql = "SELECT mois
        FROM  fichefrais
        WHERE `idVisiteur` = ?
		ORDER BY mois DESC";

        $stmt = $this->monPdo->prepare($sql);

        $stmt->bindValue(1, $id, PDO::PARAM_STR);

        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);



        $lesMois =array();

        foreach ($results as $row)
        {
            $mois = $row['mois'];
            //dd($row['mois']);
            //echo "mois : " . $mois;

            $numAnnee =substr( $mois,0,4);
            //dd($numAnnee);
            //echo "numAnnee : " . $numAnnee;

            $numMois =substr( $mois,4,2);

            $lesMois["$mois"]=array(
                "mois"=>"$mois",
                "numAnnee"  => "$numAnnee",
                "numMois"  => "$numMois"
            );

        }
        return $lesMois;


    }

    public function getNomPourMois($id)
    {
        $sql = "SELECT nom
        FROM  visiteur
        WHERE `id` = ?";

        $stmt = $this->monPdo->prepare($sql);

        $stmt->bindValue(1, $id, PDO::PARAM_STR);

        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //dd($results);

        return $results;

    }

    public function getPrenomPourMois($id)
    {
        $sql = "SELECT prenom
        FROM  visiteur
        WHERE `id` = ?";

        $stmt = $this->monPdo->prepare($sql);

        $stmt->bindValue(1, $id, PDO::PARAM_STR);

        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //dd($results);

        return $results;

    }

    public function getLaFicheFrais($idVisiteur, $leMois)
    {
        $sql = "SELECT idVisiteur as idVisiteur, mois as mois, nbJustificatifs as nbJustificatifs, montantValide as montantValide, dateModif as dateModif, idEtat as idEtat
        FROM  fichefrais
        WHERE `idVisiteur` = ? AND `mois` = ?";

        $stmt = $this->monPdo->prepare($sql);

        $stmt->bindValue(1, $idVisiteur, PDO::PARAM_STR);
        $stmt->bindValue(2, $leMois, PDO::PARAM_STR);

        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //dd($results);

        return $results;

    }

    public function getLesLigneFraisForfait($idVisiteur, $leMois)
    {
        $sql = "SELECT idVisiteur as idVisiteur, mois as mois, idFraisForfait as idFraisForfait, quantite as quantite
        FROM  lignefraisforfait
        WHERE `idVisiteur` = ? AND `mois` = ?";

        $stmt = $this->monPdo->prepare($sql);

        $stmt->bindValue(1, $idVisiteur, PDO::PARAM_STR);
        $stmt->bindValue(2, $leMois, PDO::PARAM_STR);

        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //dd($results);

        return $results;

    }



/**
 * Retourne les informations d'une fiche de frais d'un visiteur pour un mois donné

 * @param $idVisiteur
 * @param $mois sous la forme aaaamm
 * @return un tableau avec des champs de jointure entre une fiche de frais et la ligne d'état
*/
	public function getLesInfosFicheFrais($idVisiteur,$mois){
		$req = "select fichefrais.idEtat as idEtat, fichefrais.dateModif as dateModif, fichefrais.nbJustificatifs as nbJustificatifs,
			fichefrais.montantValide as montantValide, etat.libelle as libEtat from  fichefrais inner join etat on fichefrais.idEtat = etat.id
			where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		$res = $this->monPdo->query($req);
		$laLigne = $res->fetch();
		return $laLigne;
	}
/**
 * Modifie l'état et la date de modification d'une fiche de frais

 * Modifie le champ idEtat et met la date de modif à aujourd'hui
 * @param $idVisiteur
 * @param $mois sous la forme aaaamm
 */

	public function majEtatFicheFrais($idVisiteur,$mois,$etat){
		$req = "update ficheFrais set idEtat = '$etat', dateModif = now()
		where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		$this->monPdo->exec($req);
	}




/*       FONCTION POUR LES MISSION POUR LA GESTION DE VISITEUR           */


	public function getLesVisiteurs()
	{
		$sql = "SELECT visiteur.id as id, visiteur.nom as nom, visiteur.prenom as prenom
		FROM visiteur
        WHERE typeUser = 1 ";

		$stmt = $this->monPdo->prepare($sql);

		$stmt->execute();

		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);


		return $results;

	}

    function getLesFichesFrais()
    {

        $sql ="SELECT *
        FROM fichefrais";

        $stmt = $this->monPdo->prepare($sql);

        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;

    }

	public function getLesVisiteursIdNomPrenom($idVisiteur)
	{
		$sql = "SELECT *
		FROM visiteur
		WHERE id = ?";





		$stmt = $this->monPdo->prepare($sql);



		$stmt->bindValue(1, $idVisiteur, PDO::PARAM_STR);

		$stmt->execute();

		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);


		return $results;

	}



	public function getModificationVisteur($nom, $prenom, $login, $mdp, $adresse, $cp, $ville, $dateEmbauche, $id)
	{
		$sql = "UPDATE `visiteur`
		SET `nom`= ?,`prenom`= ?,`login`= ?,`mdp`= ?,`adresse`= ?,`cp`= ?,`ville`= ?,`dateEmbauche`= ?
		WHERE `id` = ?";

		//dd($sql);

		$stmt = $this->monPdo->prepare($sql);
		//dd($stmt);


		$stmt->bindValue(1, $nom, PDO::PARAM_STR);
		$stmt->bindValue(2, $prenom, PDO::PARAM_STR);
		$stmt->bindValue(3, $login, PDO::PARAM_STR);
		$stmt->bindValue(4, $mdp, PDO::PARAM_STR);
		$stmt->bindValue(5, $adresse, PDO::PARAM_STR);
		$stmt->bindValue(6, $cp, PDO::PARAM_STR);
		$stmt->bindValue(7, $ville, PDO::PARAM_STR);
		$stmt->bindValue(8, $dateEmbauche, PDO::PARAM_STR);
        $stmt->bindValue(9, $id, PDO::PARAM_STR);




		$stmt->execute();
		//dd($stmt);
		echo" <br> ";
		var_dump($stmt);

		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

		echo" <br> ";
		var_dump($results);


		return $results;

	}


	public function insertVisiteur($id, $nom, $prenom, $login, $mdp, $adresse, $cp, $ville, $dateEmbauche)
	{
		$sql = "INSERT INTO `visiteur`(`id`, `nom`, `prenom`, `login`, `mdp`, `adresse`, `cp`, `ville`, `dateEmbauche`)
		VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

		$stmt = $this->monPdo->prepare($sql);
		//dd($stmt);


		$stmt->bindValue(1, $id, PDO::PARAM_STR);
		$stmt->bindValue(2, $nom, PDO::PARAM_STR);
		$stmt->bindValue(3, $prenom, PDO::PARAM_STR);
		$stmt->bindValue(4, $login, PDO::PARAM_STR);
		$stmt->bindValue(5, $mdp, PDO::PARAM_STR);
		$stmt->bindValue(6, $adresse, PDO::PARAM_STR);
		$stmt->bindValue(7, $cp, PDO::PARAM_STR);
		$stmt->bindValue(8, $ville, PDO::PARAM_STR);
		$stmt->bindValue(9, $dateEmbauche, PDO::PARAM_STR);



		$stmt->execute();
		echo" <br> ";
		var_dump($stmt);

		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

		echo" <br> ";
		var_dump($results);

		return $results;


	}

    public function insertFicheFrais($id, $mois, $nbJustificatifs, $montantValide, $dateModif, $idEtat)
    {

        $sql = "INSERT INTO `fichefrais`(`idVisiteur`, `mois`, `nbJustificatifs`, `montantValide`, `dateModif`, `idEtat`)
		VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->monPdo->prepare($sql);
        //dd($stmt);




        $stmt->bindValue(1, $id, PDO::PARAM_STR);
        $stmt->bindValue(2, $mois, PDO::PARAM_STR);
        $stmt->bindValue(3, $nbJustificatifs, PDO::PARAM_STR);
        $stmt->bindValue(4, $montantValide, PDO::PARAM_STR);
        $stmt->bindValue(5, $dateModif, PDO::PARAM_STR);
        $stmt->bindValue(6, $idEtat, PDO::PARAM_STR);



        $stmt->execute();
        echo" <br> ";
        var_dump($stmt);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo" <br> ";
        var_dump($results);

        return $results;


    }

    public function insertLigneFraisForfait($id, $mois, $idFraisForfait, $quantite)
    {

        $sql = "INSERT INTO `lignefraisforfait`(`idVisiteur`, `mois`, `idFraisForfait`, `quantite`)
		VALUES (?, ?, ?, ?)";

        $stmt = $this->monPdo->prepare($sql);
        //dd($stmt);


        $stmt->bindValue(1, $id, PDO::PARAM_STR);
        $stmt->bindValue(2, $mois, PDO::PARAM_STR);
        $stmt->bindValue(3, $idFraisForfait, PDO::PARAM_STR);
        $stmt->bindValue(4, $quantite, PDO::PARAM_STR);



        $stmt->execute();
        echo" <br> ";
        var_dump($stmt);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo" <br> ";
        var_dump($results);

        return $results;


    }



    public function deleteLigneFraiForfait($id)
    {
        $sql = "DELETE FROM lignefraisforfait
		WHERE `idVisiteur` = ?";

        $stmt = $this->monPdo->prepare($sql);
        //dd($stmt);


        $stmt->bindValue(1, $id, PDO::PARAM_STR);


        //dd($stmt);
        $stmt->execute();
        //dd($stmt);
        echo" <br> ";
        var_dump($stmt);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo" <br> ";
        var_dump($results);

        return $results;
    }

    public function deleteFicheFrais($id)
    {
        $sql = "DELETE FROM fichefrais
		WHERE `idVisiteur` = ?";

        $stmt = $this->monPdo->prepare($sql);
        //dd($stmt);


        $stmt->bindValue(1, $id, PDO::PARAM_STR);


        //dd($stmt);
        $stmt->execute();
        //dd($stmt);
        echo" <br> ";
        var_dump($stmt);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo" <br> ";
        var_dump($results);

        return $results;
    }


	public function deleteVisiteur($id)
	{
		$sql = "DELETE FROM visiteur
		WHERE `id` = ?";

		$stmt = $this->monPdo->prepare($sql);
		//dd($stmt);


		$stmt->bindValue(1, $id, PDO::PARAM_STR);


		//dd($stmt);
		$stmt->execute();
		//dd($stmt);
		echo" <br> ";
		var_dump($stmt);

		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

		echo" <br> ";
		var_dump($results);

		return $results;



	}

    public function getUnIdVisiteur($id)
    {
        $sql = "SELECT *
        FROM visiteur
		WHERE `id` = ?";

        $stmt = $this->monPdo->prepare($sql);
        //dd($stmt);


        $stmt->bindValue(1, $id, PDO::PARAM_STR);


        //dd($stmt);
        $stmt->execute();
        //dd($stmt);
        echo" <br> ";
        var_dump($stmt);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo" <br> ";
        var_dump($results);

        return $results;



    }







}
