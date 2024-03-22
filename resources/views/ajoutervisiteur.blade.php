@extends ('sommaire')
    @section('contenu1')
      <div id="contenu">
        <h2>Ajouter un visiteur :</h2>

        <div class="">


            <form action="{{Route('ajouterVisiteur')}}" method="post">

                @csrf

                <label name="id" for="idVisiteur">Id : </label>
                <input type="text" name="idVisiteur" id="idVisiteur" value="">

                <br>
                <br>

                <label name="nom" for="nomVisiteur">Nom : </label>
                <input type="text" name="nomVisiteur" id="nomVisiteur" value="">



                <br>
                <br>

                <label for="prenomVisteur">Prénom : </label>
                <input type="text" name="prenomVisiteur" id="prenomVisiteur" value="">

                <br>
                <br>

                <label for="loginVisteur">Login : </label>
                <input type="text" name="loginVisiteur" id="loginVisiteur" value="">

                <br>
                <br>

                <label name="mdpVisiteur" for="mdpVisiteur">Mot de Passe : </label>
                <input type="password" name="mdpVisiteur" id="mdpVisiteur" value="">

                <br>
                <br>

                <label for="adresseVisteur">Adresse : </label>
                <input type="text" name="adresseVisiteur" id="adresseVisiteur" value="">

                <br>
                <br>

                <label for="cpVisteur">Code Postal : </label>
                <input type="text" name="cpVisiteur" id="cpVisiteur" value="">

                <br>
                <br>

                <label for="villeVisteur">Ville : </label>
                <input type="text" name="villeVisiteur" id="villeVisiteur" value="">

                <br>
                <br>

                <label for="dateVisteur">Date embauche : </label>
                <input type="text" name="dateVisiteur" id="dateVisiteur" placeholder="YYYY-MM-DD" value="">



                <input type="hidden" name="typeUser" id="dateVisiteur" placeholder="YYYY-MM-DD" value="">


                <br>
                <br>

                <input type="submit" id="btn" value="Valider">



            </form>





        </div>
  @endsection
