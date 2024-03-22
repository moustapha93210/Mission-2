<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PdoGsb;

class connexionController extends Controller
{
    function connecter(){

        return view('connexion')->with('erreurs',null);
    }

    function valider(Request $request)
    {
        $login = $request['login'];

        $mdp = $request['mdp'];

        $visiteur = PdoGsb::getInfosVisiteur($login,$mdp);
        $gestionnaire = $visiteur;
        $comptable = $visiteur;

        if(!is_array($visiteur)){

            $erreurs[] = "Login ou mot de passe incorrect(s)";
            return view('connexion')->with('erreurs',$erreurs);
        }
        else if ($visiteur['type'] == 1)
        {
            session(['visiteur' => $visiteur]);
            return view('sommaire')->with('visiteur',session('visiteur'));
        }
        else if ($visiteur['type'] == 2)
        {
            session(['gestionnaire' => $gestionnaire]);
            return view('sommaire')->with('gestionnaire',session('gestionnaire'));
        }
        else if ($visiteur['type'] == 3)
        {
            session(['comptable' => $comptable]);
            return view('sommaire')->with('comptable',session('comptable'));
        }
    }
    function deconnecter(){
            session(['visiteur' => null]);
            return redirect()->route('chemin_connexion');


    }

}
