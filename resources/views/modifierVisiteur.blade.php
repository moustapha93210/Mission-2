@extends ('sommaire')
    @section('contenu1')
      <div id="contenu">
        <h2>Le Visiteur à Modifier</h2>

        <div class="">


            @foreach($trouverVisiteur as $untrouverVisiteur)


            @endforeach

            <form id="monFormulaireModifier" action="{{Route('rajouterVisiteur')}}" method="post">

                @csrf

                <input type="hidden" name="idVisiteur" id="idVisiteur" value="{{$untrouverVisiteur['id']}}" >

                <br>
                <br>

                <label name="nom" for="nomVisiteur">Nom : </label>
                <input type="text" name="nomVisiteur" id="nomVisiteur" value="{{$untrouverVisiteur['nom']}}" oninput="generateLogin()" required maxlength="255" pattern="[A-Za-zÀ-ÖØ-öø-ÿ \-]+" title="Le nom doit uniquement contenir des lettres.">



                <br>
                <br>

                <label for="prenomVisteur">Prénom : </label>
                <input type="text" name="prenomVisiteur" id="prenomVisiteur" value="{{$untrouverVisiteur['prenom']}}" oninput="generateLogin()" required maxlength="255" pattern="[A-Za-zÀ-ÖØ-öø-ÿ \-]+" title="Le prénom doit uniquement contenir des lettres.">

                <br>
                <br>

                <label for="loginVisteur">Login : </label>
                <input type="text" name="loginVisiteur" id="loginVisiteur" value="{{$untrouverVisiteur['login']}}" readonly>

                <input type="hidden" name="mdpVisiteur" id="mdpVisiteur" value="{{$untrouverVisiteur['mdp']}}">

                <br>
                <br>

                <label for="adresseVisteur">Adresse : </label>
                <input type="text" name="adresseVisiteur" id="adresseVisiteur" value="{{$untrouverVisiteur['adresse']}}" maxlength="255">

                <br>
                <br>

                <label for="cpVisteur">Code Postal : </label>
                <input type="text" name="cpVisiteur" id="cpVisiteur" value="{{$untrouverVisiteur['cp']}}" required pattern="^[0-9]{5}$" title="Le champ Code postal doit contenir exactement 5 chiffres.">

                <br>
                <br>

                <label for="villeVisteur">Ville : </label>
                <input type="text" name="villeVisiteur" id="villeVisiteur" value="{{$untrouverVisiteur['ville']}}" required maxlength="255" pattern="[A-Za-zÀ-ÖØ-öø-ÿ \-]+" title="Le champ Ville doit uniquement contenir des lettres.">

                <br>
                <br>

                <label for="dateVisteur">Date embauche : </label>
                <input type="text" name="dateVisiteur" id="dateVisiteur" placeholder="YYYY-MM-DD" value="{{$untrouverVisiteur['dateEmbauche']}}" required pattern="\d{4}-\d{2}-\d{2}" title="La date d'embauche doit être au format YYYY-MM-DD.">


                <input type="hidden" name="typeUser" id="typeUser" placeholder="" value="{{$untrouverVisiteur['typeUser']}}">

                <br>
                <br>

                <input type="submit" id="btn" value="Valider">

            </form>


            <script>

                function generateLogin() {
                    var prenom = document.getElementById("prenomVisiteur").value.trim();
                    var nom = document.getElementById("nomVisiteur").value.trim();

                    if (prenom.length > 0 && nom.length > 0) {
                        var firstLetter = prenom.charAt(0);  // Obtient la première lettre du prénom
                        var login = firstLetter + nom;  // Concatène la première lettre du prénom avec le nom complet
                        login = login.toLowerCase();  // Convertit le login en minuscules pour la cohérence
                        document.getElementById("loginVisiteur").value = login;  // Met à jour le champ de login
                    }
                }

                document.getElementById("monFormulaireModifier").onsubmit = function(){

                    var nomVisiteur = document.getElementById("nomVisiteur").value.trim();
                    var prenomVisiteur = document.getElementById("prenomVisiteur").value.trim();
                    var loginVisiteur = document.getElementById("loginVisiteur").value.trim();
                    var adresseVisiteur = document.getElementById("adresseVisiteur").value.trim();
                    var cpVisiteur = document.getElementById("cpVisiteur").value.trim();
                    var villeVisiteur = document.getElementById("villeVisiteur").value.trim();
                    var dateEmbauche = document.getElementById("dateVisiteur").value.trim();



                    var regexCp = /^[0-9]{5}$/;
                    if (!regexCp.test(cpVisiteur)) {
                        alert("Le code postal doit contenir exactement 5 chiffres.");
                        return false;
                    }

                    var regexDate = /^\d{4}-\d{2}-\d{2}$/;
                    if (!regexDate.test(dateEmbauche)) {
                        alert("La date d'embauche doit être au format YYYY-MM-DD.");
                        return false;
                    }

                    if(nomVisiteur === ""){
                        alert("Le champs \"Nom : \" doit être remplis.");
                        return false;
                    }
                    else if(prenomVisiteur === ""){
                        alert("Le champs \"Prénom : \" doit être remplis.");
                        return false;
                    }
                    else if(loginVisiteur === ""){
                        alert("Le champs \"Login : \" doit être remplis.");
                        return false;
                    }
                    else if(adresseVisiteur === ""){
                        alert("Le champs \"Adresse : \" doit être remplis.");
                        return false;
                    }
                    else if(cpVisiteur === ""){
                        alert("Le champs \"Code Postal : \" doit être remplis.");
                        return false;
                    }
                    else if(villeVisiteur === ""){
                        alert("Le champs \"Ville : \" doit être remplis.");
                        return false;
                    }
                    else if(dateEmbauche === ""){
                        alert("Le champs \"Date d'embauche : \" doit être remplis.");
                        return false;
                    }


                };




            </script>





        </div>
  @endsection
