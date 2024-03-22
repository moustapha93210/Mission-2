@extends ('sommaire')
@section('contenu2')

    <div id="contenu">

        <h2>Mes Fiche de Frais</h2>

        <h3>Id et Mois Sélectionner : </h3>

        <h4>Fiche de frais du mois {{ $numAnnee }}-{{ $numMois }} :</h4>


        <div class="corpsForm">

            @foreach($afficherFicheFrais as $uneFiche)


            @endforeach

            <form action="modifierEtat" method="post">

                <table>

                    <thead>

                        <tr>

                            <th>Id</th>

                            <th>Mois</th>

                            <th>Nombre de justificatifs</th>

                            <th>Montant Validé</th>

                            <th>Date de Modification</th>

                            <th>Etat</th>

                        </tr>

                    </thead>

                    <tbody>

                          @csrf

                          <tr>

                              <td>

                                  <input type="text" name="idVisiteur" id="idVisiteur" value="{{$uneFiche['idVisiteur']}}" readonly>

                              </td>

                              <td>

                                  <input type="text" name="mois" id="mois" value="{{$uneFiche['mois']}}" readonly>

                              </td>

                              <td>

                                  <input type="text" name="nbJustificatifs" id="nbJustificatifs" value="{{$uneFiche['nbJustificatifs']}}" readonly>

                              </td>

                              <td>

                                  <input type="text" name="montantValide" id="montantValide" value="{{$uneFiche['montantValide']}}" readonly>

                              </td>

                              <td>

                                  <input type="text" name="dateModif" id="dateModif" value="{{$uneFiche['dateModif']}}" readonly>

                              </td>

                              <td>

                                  <input type="text" name="idEtat" id="idEtat" value="{{$uneFiche['idEtat']}}" readonly>

                              </td>

                              <td>

                                  <input id="ok" type="submit" value="Modifier Etat" size="20" />

                              </td>


                          </tr>

                    </tbody>



                </table>
            </form>

            <br>
            <br>

            <table>

                <thead>

                    <tr>

                        <th>Mois</th>

                        <th>IdFraisForfait</th>

                        <th>Quantite</th>


                    </tr>

                </thead>

                <tbody>

                @foreach($afficherLigneFraisForfait as $uneFiche)

                    <tr>

                        <td>{{$uneFiche['mois']}}</td>

                        <td>{{$uneFiche['idFraisForfait']}}</td>

                        <td>{{$uneFiche['quantite']}}</td>

                        <td>

                    </tr>
                @endforeach

                </tbody>



            </table>

        </div>

    </div>
@endsection

