@extends ('sommaire')
@section('contenu1')
    <div id="contenu">
        <h2>L'Etat à Modifier</h2>

        <div class="">


            @foreach($trouverFicheFrais as $uneFicheFrais)


            @endforeach

            <form action="etatEstModifier" method="post">

                @csrf

                <input type="hidden" name="idVisiteur" id="idVisiteur" value="{{$uneFicheFrais['idVisiteur']}}">

                <br>
                <br>

                <label name="mois" for="mois">Mois : </label>
                <input type="text" name="mois" id="mois" value="{{$uneFicheFrais['mois']}}" readonly>

                <br>
                <br>

                <label name="nbJustificatifs" for="nbJustificatifs">Nombre de justificatifs : </label>
                <input type="text" name="mois" id="mois" value="{{$uneFicheFrais['nbJustificatifs']}}" readonly>

                <br>
                <br>

                <label name="montantValide" for="montantValide">Montant valide : </label>
                <input type="text" name="montantValide" id="montantValide" value="{{$uneFicheFrais['montantValide']}}" readonly>

                <br>
                <br>

                <label name="dateModif" for="dateModif">Date de modification : </label>
                <input type="text" name="dateModif" id="dateModif" value="{{$dateModif}}" readonly>

                <br>
                <br>


                <label name="idEtat" for="idEtat">Etat : </label>
                <input type="text" name="idEtat" id="idEtat" value="{{$uneFicheFrais['idEtat']}}">

                <br>
                <br>

                <input type="submit" id="btn" value="Valider">

            </form>

        </div>
@endsection
