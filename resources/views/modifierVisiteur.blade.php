@extends ('sommaire')
    @section('contenu1')
      <div id="contenu">
        <h2>Le Visiteur à Modifier</h2>

        <div class="">


            @foreach($trouverVisiteur as $untrouverVisiteur)


            @endforeach

            <form action="{{Route('rajouterVisiteur')}}" method="post">

                @csrf

                <input type="hidden" name="idVisiteur" id="idVisiteur" value="{{$untrouverVisiteur['id']}}">

                <br>
                <br>

                <label name="nom" for="nomVisiteur">Nom : </label>
                <input type="text" name="nomVisiteur" id="nomVisiteur" value="{{$untrouverVisiteur['nom']}}">



                <br>
                <br>

                <label for="prenomVisteur">Prénom : </label>
                <input type="text" name="prenomVisiteur" id="prenomVisiteur" value="{{$untrouverVisiteur['prenom']}}">

                <br>
                <br>

                <label for="loginVisteur">Login : </label>
                <input type="text" name="loginVisiteur" id="loginVisiteur" value="{{$untrouverVisiteur['login']}}">

                <input type="hidden" name="mdpVisiteur" id="mdpVisiteur" value="{{$untrouverVisiteur['mdp']}}">

                <br>
                <br>

                <label for="adresseVisteur">Adresse : </label>
                <input type="text" name="adresseVisiteur" id="adresseVisiteur" value="{{$untrouverVisiteur['adresse']}}">

                <br>
                <br>

                <label for="cpVisteur">Code Postal : </label>
                <input type="text" name="cpVisiteur" id="cpVisiteur" value="{{$untrouverVisiteur['cp']}}">

                <br>
                <br>

                <label for="villeVisteur">Ville : </label>
                <input type="text" name="villeVisiteur" id="villeVisiteur" value="{{$untrouverVisiteur['ville']}}">

                <br>
                <br>

                <label for="dateVisteur">Date embauche : </label>
                <input type="text" name="dateVisiteur" id="dateVisiteur" placeholder="YYYY-MM-DD" value="{{$untrouverVisiteur['dateEmbauche']}}">


                <input type="hidden" name="typeUser" id="typeUser" placeholder="YYYY-MM-DD" value="{{$untrouverVisiteur['typeUser']}}">

                <br>
                <br>

                <input type="submit" id="btn" value="Valider">



            </form>





        </div>
  @endsection
