@extends ('sommaire')
@section('contenu1')

    <div id="contenu">
        <h2>Mes Fiche de Frais</h2>

        <h3>Mois à sélectionner : </h3>

        <div class="corpsForm">

            <form action="afficherFicheFraisSelectionner" method="post">

                @csrf

                <p>

                    <label for="lstIdVisiteur" >Visiteur : </label>
                    <select id="lstIdVisiteur" name="lstIdVisiteur" >

                            <option selected value="{{ $lesIdVisiteursPourMois }}">


                                {{ $leNomVisiteurPourMois[0]['nom'] }} {{ $lePrenomVisiteurPourMois[0]['prenom'] }}

                            </option>

                    </select>

                </p>

                <p>




                    <label for="lstMois" >Mois : </label>
                    <select id="lstMois" name="lstMois">
                        @foreach($lesMoisDisponibles as $unMois)

                            <option selected value="{{ $unMois['mois'] }}">
                                {{$unMois['numMois']}} / {{$unMois['numAnnee']}}
                            </option>

                        @endforeach

                    </select>

                </p>

                <div class="piedForm">

                    <p>
                        <input id="ok" type="submit" value="Valider" size="20" />
                    </p>

                </div>



            </form>



        </div>

    </div>
@endsection

