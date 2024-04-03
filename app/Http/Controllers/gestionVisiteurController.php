<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PdoGsb;
use MyDate;
use Barryvdh\DomPDF\Facade\Pdf;

class gestionVisiteurController extends Controller
{

    function afficherVisiteur()
    {
        if (session('gestionnaire') != null) {
            $gestionnaire = session('gestionnaire');
            $lesVisiteurs = PdoGsb::getLesVisiteurs();
            var_dump($lesVisiteurs);


            $vue = view('listevisiteur')->with('lesVisiteurs', $lesVisiteurs)
                ->with('gestionnaire', $gestionnaire);

            return $vue;
        } else {
            return view('connexion')->with('erreurs', null);

        }

    }


    function modifierVisiteur(Request $request)
    {
        if (session('gestionnaire') != null) {

            $gestionnaire = session('gestionnaire');
            //dd($gestionnaire);
            $idvisiteur = htmlentities($request['id']);
            //dd($idvisiteur);


            $trouverVisiteur = PdoGsb::getLesVisiteursIdNomPrenom($idvisiteur);
            //dd($trouverVisiteur);

            $vue = view('modifierVisiteur')->with('trouverVisiteur', $trouverVisiteur)
                ->with('gestionnaire', $gestionnaire);

            return $vue;

        } else {
            return view('connexion')->with('erreurs', null);
        }

    }


    function rajouterVisiteur(Request $request)
    {

        if (session('gestionnaire') != null) {
            $gestionnaire = session('gestionnaire');

            $id = htmlentities($request['idVisiteur']);
            var_dump("<br> Id : " . $id);

            $nom = htmlentities($request['nomVisiteur']);
            var_dump("<br> Nom : " . $nom);

            $prenom = htmlentities($request['prenomVisiteur']);
            var_dump("<br> Prenom : " . $prenom);

            $login = htmlentities($request['loginVisiteur']);
            var_dump("<br> Login : " . $login);

            $mdp = htmlentities($request['mdpVisiteur']);
            var_dump("<br> Mdp : " . $mdp);

            $adresse = htmlentities($request['adresseVisiteur']);
            var_dump("<br> Adresse : " . $adresse);

            $cp = htmlentities($request['cpVisiteur']);
            var_dump("<br> Code postale : " . $cp);

            $ville = htmlentities($request['villeVisiteur']);
            var_dump("<br> Ville : " . $ville);

            $dateEmbauche = htmlentities($request['dateVisiteur']);
            var_dump("<br> Date embauche : " . $dateEmbauche);

            /*$typeUser = htmlentities($request['typeUser']);
            var_dump("<br> Type : ". $typeUser);*/

            $trouverVisiteur = PdoGsb::getLesVisiteursIdNomPrenom($id);

            //echo "salut";
            $modif = PdoGsb::getModificationVisteur($nom, $prenom, $login, $mdp, $adresse, $cp, $ville, $dateEmbauche, $id);
            //dd($modificationVisiteur);

            $lesVisiteurs = PdoGsb::getLesVisiteurs();

            //echo "kjhfuhskf";


            $vue = view('listevisiteur')->with('lesVisiteurs', $lesVisiteurs)
                ->with('modif', $modif)
                ->with('gestionnaire', $gestionnaire);

            return $vue;
        } else {
            return view('connexion')->with('erreurs', null);
        }
    }


    function nouveauVisiteur(Request $request)
    {

        if (session('gestionnaire') != null) {

            $gestionnaire = session('gestionnaire');


            $vue = view('ajoutervisiteur')->with('gestionnaire', $gestionnaire);

            return $vue;
        } else {
            return view('connexion')->with('erreurs', null);
        }
    }


    function ajouterVisiteur(Request $request)
    {

        if (session('gestionnaire') != null) {

            $gestionnaire = session('gestionnaire');


            //INSERT POUR VISITEUR
            $id = htmlentities($request['idVisiteur']);
            var_dump("<br> Id : " . $id);

            $nom = htmlentities($request['nomVisiteur']);
            var_dump("<br> Nom : " . $nom);

            $prenom = htmlentities($request['prenomVisiteur']);
            var_dump("<br> Prenom : " . $prenom);

            $login = htmlentities($request['loginVisiteur']);
            var_dump("<br> Login : " . $login);

            $mdp = htmlentities($request['mdpVisiteur']);
            var_dump("<br> Mdp : " . $mdp);

            $adresse = htmlentities($request['adresseVisiteur']);
            var_dump("<br> Adresse : " . $adresse);

            $cp = htmlentities($request['cpVisiteur']);
            var_dump("<br> Code postale : " . $cp);

            $ville = htmlentities($request['villeVisiteur']);
            var_dump("<br> Ville : " . $ville);

            $dateEmbauche = htmlentities($request['dateVisiteur']);
            var_dump("<br> Date embauche : " . $dateEmbauche);


            $typeUser = htmlentities($request['typeUser']);
            var_dump("<br> Date embauche : " . $dateEmbauche);

            $insertVisiteur = PdoGsb::insertVisiteur($id, $nom, $prenom, $login, $mdp, $adresse, $cp, $ville, $dateEmbauche, $typeUser);

            $lesVisiteurs = PdoGsb::getLesVisiteurs();


            //INSERT POUR FicheFrais
            $dateCoupe = date_parse($request['dateVisiteur']);
            $jour = $dateCoupe['day'];
            $mois = $dateCoupe['month'];
            $annee = $dateCoupe['year'];
            echo "<br>anée : " . $annee;
            echo "<br>mois : " . $mois;

            if ($mois < 10) {
                $mois = "0" . $dateCoupe['month'];
            }

            $date = $annee . $mois;

            echo "<br>date pour ficheFrais : " . $date;


            $nbJustificatifs = 0;

            $montantValide = 0;

            $dateModif = now();
            //dd($date_modif);

            $idEtat = "CR";


            $insertFicheFrais = PdoGsb::insertFicheFrais($id, $date, $nbJustificatifs, $montantValide, $dateModif, $idEtat);


            //INSERT POUR LigneFraisForfaitETP
            $idLigneFraisForfaitETP = $id;

            $idFraisForfaitETP = "ETP";

            $quantite = 0;

            $insertLigneFraisForfaitETP = PdoGsb::insertLigneFraisForfait($idLigneFraisForfaitETP, $date, $idFraisForfaitETP, $quantite);


            //INSERT POUR LigneFraisForfaitKM
            $idFraisForfaitKM = "KM";

            $quantite = 0;

            $insertLigneFraisForfaitKM = PdoGsb::insertLigneFraisForfait($id, $date, $idFraisForfaitKM, $quantite);


            //INSERT POUR LigneFraisForfaitNUI
            $idFraisForfaitNUI = "NUI";

            $quantite = 0;


            $insertLigneFraisForfaitNUI = PdoGsb::insertLigneFraisForfait($id, $date, $idFraisForfaitNUI, $quantite);


            //INSERT POUR LigneFraisForfaitREP
            $idFraisForfaitREP = "REP";

            $quantite = 0;


            $insertLigneFraisForfaitREP = PdoGsb::insertLigneFraisForfait($id, $date, $idFraisForfaitREP, $quantite);


            //echo "kjhfuhskf";


            $vue = view('listevisiteur')->with('gestionnaire', $gestionnaire)
                ->with('insertFichFrais', $insertFicheFrais)
                ->with('insertLigneFraisForfaitETP', $insertLigneFraisForfaitETP)
                ->with('insertLigneFraisForfaitKM', $insertLigneFraisForfaitKM)
                ->with('insertLigneFraisForfaitNUI', $insertLigneFraisForfaitNUI)
                ->with('insertLigneFraisForfaitREP', $insertLigneFraisForfaitREP)
                ->with('insertVisiteur', $insertVisiteur)
                ->with('lesVisiteurs', $lesVisiteurs);

            return $vue;
        } else {
            return view('connexion')->with('erreurs', null);
        }
    }


    function voirsupprimerVisiteur(Request $request)
    {

        if (session('gestionnaire') != null) {

            if (session('gestionnaire') != null) {

                $gestionnaire = session('gestionnaire');
                //dd($gestionnaire);
                $id = htmlentities($request['id']);
                //dd($id);


                $trouverVisiteur = PdoGsb::getLesVisiteursIdNomPrenom($id);
                //dd($trouverVisiteur);

                $vue = view('voirSupprimerVisiteur')->with('trouverVisiteur', $trouverVisiteur)
                    ->with('gestionnaire', $gestionnaire);

                return $vue;

            } else {
                return view('connexion')->with('erreurs', null);
            }

        }
    }


    function supprimerVisiteur(Request $request)
    {

        if (session('gestionnaire') != null) {

            $gestionnaire = session('gestionnaire');

            $id = htmlentities($request['idVisiteur']);
            //dd($id);
            //var_dump("<br> Id : ". $id);

            $deleteLigneFraisForfait = PdoGsb::deleteLigneFraiForfait($id);

            $deleteFicheFrais = PdoGsb::deleteFicheFrais($id);

            $deleteVisiteur = PdoGsb::deleteVisiteur($id);

            $lesVisiteurs = PdoGsb::getLesVisiteurs();

            //echo "kjhfuhskf";


            $vue = view('listevisiteur')->with('lesVisiteurs', $lesVisiteurs)
                ->with('deleteVisiteur', $deleteVisiteur)
                ->with('gestionnaire', $gestionnaire);

            return $vue;
        } else {
            return view('connexion')->with('erreurs', null);
        }
    }

    function afficherFicheFraisId(Request $request)
    {
        if (session('comptable') != null) {

            $comptable = session('comptable');

            $lesIdVisiteurs = PdoGsb::getLesIdVisiteurs();


            $vue = view('listefichefraisId')->with('lesIdVisiteurs', $lesIdVisiteurs)
                ->with('comptable', $comptable);

            return $vue;

        } else {
            return view('connexion')->with('erreurs', null);
        }


    }

    function afficherFicheFraisIdMois(Request $request)
    {
        if (session('comptable') != null) {

            $comptable = session('comptable');

            $lesIdVisiteursPourMois = htmlentities($request['lstIdVisiteur']);
            //dd($lesIdVisiteursPourMois);

            $leNomVisiteurPourMois = PdoGsb::getNomPourMois($lesIdVisiteursPourMois);
            //$cles = array_keys($leNomVisiteurPourMois);
            //dd($cles);
            //echo $leNomVisiteurPourMois[0]['nom'];

            $lePrenomVisiteurPourMois = PdoGsb::getPrenomPourMois($lesIdVisiteursPourMois);


            $lesMoisDisponibles = PdoGsb::getLesMoisDisponibles3($lesIdVisiteursPourMois);

            $vue = view('listefichefraisIdMois')->with('lesIdVisiteursPourMois', $lesIdVisiteursPourMois)
                ->with('leNomVisiteurPourMois', $leNomVisiteurPourMois)
                ->with('lePrenomVisiteurPourMois', $lePrenomVisiteurPourMois)
                ->with('lesMoisDisponibles', $lesMoisDisponibles)
                ->with('comptable', $comptable);

            return $vue;

        } else {
            return view('connexion')->with('erreurs', null);
        }


    }


    function afficherFicheFraisSelectionner(Request $request)
    {

        if (session('comptable') != null)
        {
            $comptable = session('comptable');

            $idVisiteur = $request['lstIdVisiteur'];
            var_dump($idVisiteur);

            /*$leNom = PdoGsb::getNomPourMois($idVisiteur);
            //dd($leNom);

            $lenom = $leNom[0]['nom'];
            //dd($lenom);

            $lePrenom = PdoGsb::getPrenomPourMois($idVisiteur);
            //dd($lePrenom);*/

            $leMois = htmlentities($request['lstMois']);
            //dd($leMois);

            $numAnnee =substr( $leMois,0,4);

            $numMois = substr($leMois, 4, 2);

            $afficherFicheFrais = PdoGsb::getLaFicheFrais($idVisiteur, $leMois);
            //dd($afficherFicheFrais);

            /*$nbJustificatifs = $afficherFicheFrais[0]['nbJustificatifs'];
            //dd($nbJustificatifs);*/

            $afficherLigneFraisForfait = PdoGsb::getLesLigneFraisForfait($idVisiteur, $leMois);


            $vue = view('afficherFicheFraisSelectionner')->with('afficherFicheFrais', $afficherFicheFrais)
                /*->with('leNom', $leNom)
                ->with('lePrenom', $lePrenom)
                ->with('nbJustificatifs', $nbJustificatifs)*/
                ->with('afficherLigneFraisForfait', $afficherLigneFraisForfait)
                ->with('numAnnee', $numAnnee)
                ->with('numMois', $numMois)
                ->with('comptable', $comptable);

            return $vue;


        }
        else
        {
            return view('connexion')->with('erreurs', null);
        }
    }


    function modifierEtat(Request $request)
    {

        if (session('comptable') != null)
        {
            $comptable = session('comptable');

            $idVisiteur = $request['idVisiteur'];
            var_dump($idVisiteur);

            $leMois = $request['mois'];
            var_dump($leMois);

            $dateModif = now();
            //dd($dateModif);

            $dateModifVrai = date_parse($dateModif);
            $jour = $dateModifVrai['day'];
            $mois = $dateModifVrai['month'];
            $annee = $dateModifVrai['year'];

            $date = $annee . "-" . $mois . "-" . $jour;
            //dd($date);

            $dateModif = $date;

            $trouverFicheFrais = PdoGsb::getLaFicheFrais($idVisiteur, $leMois);



            $vue = view('modifierEtat')->with('trouverFicheFrais', $trouverFicheFrais)
                ->with('dateModif', $dateModif)
                ->with('comptable', $comptable);

            return $vue;


        }
        else
        {
            return view('connexion')->with('erreurs', null);
        }
    }



    function etatEstModifier(Request $request)
    {

        if (session('comptable') != null)
        {
            $comptable = session('comptable');

            $idVisiteur = $request['idVisiteur'];
            var_dump($idVisiteur);

            $leMois = $request['mois'];
            var_dump($leMois);

            $nbJustificatifs = $request['nbJustificatifs'];

            $montantValide = $request['montantValide'];

            $dateModif = now();
            //dd($dateModif);

            $dateModifVrai = date_parse($dateModif);
            $jour = $dateModifVrai['day'];
            $mois = $dateModifVrai['month'];
            $annee = $dateModifVrai['year'];

            $date = $annee . "-" . $mois . "-" . $jour;
            //dd($date);

            $dateModif = $date;

            $trouverFicheFrais = PdoGsb::getLaFicheFrais($idVisiteur, $leMois);

            $modifierEtatMontantValideFicheFrais = PdoGsb::getModificationFicheFrais($leMois, $nbJustificatifs, $montantValide, $dateModif, $idVisiteur);


            $vue = view('afficherFicheFraisSelectionner')->with('trouverFicheFrais', $trouverFicheFrais)
                ->with('modifierEtatMontantValideFichFrais', $modifierEtatMontantValideFicheFrais)
                ->with('comptable', $comptable);

            return $vue;


        }
        else
        {
            return view('connexion')->with('erreurs', null);
        }
    }

    function genererPDF(Request $request)
    {

        $pdf = PDF::loadHTML("<p>Bonjour</p>");
        return $pdf->download('invoice.pdf');
        /**/

        /*if (session('comptable') != null)
        {
            $comptable = session('comptable');

            $idvisiteur = $request['idVisiteur'];
            var_dump($idvisiteur);

            $trouverUnVisiteur = PdoGsb::getUnIdVisiteur($idvisiteur);


            $pdf = Pdf::loadhtml('<h1>$trouverUnVisiteur[nom]</h1>');
            return $pdf->download('invoice.pdf');

        }
        else
        {
            return view('connexion')->with('erreurs', null);
        }*/
    }

}
