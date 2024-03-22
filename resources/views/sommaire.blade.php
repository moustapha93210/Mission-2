@extends ('modeles/visiteur')
    @section('menu')
            <!-- Division pour le sommaire -->
        <div id="menuGauche">

          <div id="infosUtil">

        </div>

              <ul id="menuList">

                  @isset($visiteur)

                    <li >

                      <strong>Bonjour Visiteur <br>{{ $visiteur['nom'] . ' ' . $visiteur['prenom'] }}</strong>

                    </li>

                  <br>

                    <li class="smenu">

                        <a href="{{ route('chemin_gestionFrais')}}" title="Saisie fiche de frais ">Saisie fiche de frais</a>

                    </li>

                    <li class="smenu">

                      <a href="{{ route('chemin_selectionMois') }}" title="Consultation de mes fiches de frais">Mes fiches de frais</a>

                    </li>

                      <li class="smenu">

                          <a href="{{ route('chemin_deconnexion') }}"" title="Se déconnecter">Déconnexion</a>

                      </li>

                  @endisset



                  @isset($gestionnaire)

                      <li >

                          <strong>Bonjour Gestionnaire <br>{{ $gestionnaire['nom'] . ' ' . $gestionnaire['prenom'] }}</strong>

                      </li>

                      <br>

                      <li class="smenu">

                          <a href="{{ route('chemin_test') }}" title="test">Test</a>

                      </li>

                      <li class="smenu">

                          <a href="{{ route('chemin_afficherVisiteur') }}" title="Liste des visiteurs">Liste des visiteurs</a>

                      </li>

                      <li class="smenu">

                          <a href="{{ route('chemin_deconnexion') }}"" title="Se déconnecter">Déconnexion</a>

                      </li>

                      @endisset



                  @isset($comptable)

                      <li >

                          <strong>Bonjour Comptable <br>{{ $comptable['nom'] . ' ' . $comptable['prenom'] }}</strong>

                      </li>

                      <br>

                      <li class="smenu">

                          <a href="{{ route('afficherFicheFraisId') }}" title="Gérer les Fiches de Frais">Gérer les Fiche de Frais</a>

                      </li>

                      <li class="smenu">

                          <a href="{{ route('chemin_deconnexion') }}" title="Se déconnecter">Déconnexion</a>

                      </li>

                      @endisset

              </ul>

        </div>
    @endsection
