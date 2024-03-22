@extends ('sommaire')
@section('contenu1')

    <div id="contenu">
        <h2>Mes Fiche de Frais</h2>

        <h3>Id à sélectionner : </h3>

        <div class="corpsForm">

            <form action="afficherFicheFraisIdMois" method="post">

                @csrf

                <p>

                    <label for="lstIdVisiteur" >Visiteur : </label>
                    <select id="lstIdVisiteur" name="lstIdVisiteur">
                        @foreach($lesIdVisiteurs as $unId)

                            <option selected value="{{ $unId['id'] }}">

                                {{ $unId['nom'] }} {{ $unId['prenom'] }}

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
