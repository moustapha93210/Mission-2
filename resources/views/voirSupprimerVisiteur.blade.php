@extends ('sommaire')
    @section('contenu1')
      <div id="contenu">
        <h2>Le Visiteur à Supprimer</h2>

        <div class=""> 


            @foreach($trouverVisiteur as $untrouverVisiteur)


            @endforeach

            <form action="{{Route('supprimerVisiteur')}}" method="post">

                @csrf

                <input type="hidden" name="idVisiteur" id="idVisiteur" value="{{$untrouverVisiteur['id']}}" readonly>

                <br>
                <br>

                <label name="nom" for="nomVisiteur">Nom : </label>
                <input type="text" name="nomVisiteur" id="nomVisiteur" value="{{$untrouverVisiteur['nom']}}" readonly>



                <br>
                <br>

                <label for="prenomVisteur">Prénom : </label>
                <input type="text" name="prenomVisiteur" id="prenomVisiteur" value="{{$untrouverVisiteur['prenom']}}" readonly>

                <br>
                <br>

                <label for="loginVisteur">Login : </label>
                <input type="text" name="loginVisiteur" id="loginVisiteur" value="{{$untrouverVisiteur['login']}}" readonly>

                <input type="hidden" name="mdpVisiteur" id="mdpVisiteur" value="{{$untrouverVisiteur['mdp']}}" readonly>

                <br>
                <br>

                <label for="adresseVisteur">Adresse : </label>
                <input type="text" name="adresseVisiteur" id="adresseVisiteur" value="{{$untrouverVisiteur['adresse']}}" readonly>

                <br>
                <br>

                <label for="cpVisteur">Code Postal : </label>
                <input type="text" name="cpVisiteur" id="cpVisiteur" value="{{$untrouverVisiteur['cp']}}" readonly>

                <br>
                <br>

                <label for="villeVisteur">Ville : </label>
                <input type="text" name="villeVisiteur" id="villeVisiteur" value="{{$untrouverVisiteur['ville']}}" readonly>

                <br>
                <br>

                <label for="dateVisteur">Date embauche : </label>
                <input type="text" name="dateVisiteur" id="dateVisiteur" placeholder="YYYY-MM-DD" value="{{$untrouverVisiteur['dateEmbauche']}}" readonly>


                <br>
                <br>

                <input type="submit" id="btn" value="Valider">


            </form>
            


            

        </div>
  @endsection 