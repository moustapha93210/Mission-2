@extends ('sommaire')
    @section('contenu1')
      <div id="contenu">
        <h2>Mes Visiteurs</h2>

        <div>

            <table>

                <thead>
                    <tr>

                        <th>Id</th>

                        <th>Nom</th>

                        <th>Prenom</th>

                        <th>Boutons</th>

                    </tr>

                </thead>



                <tbody>

                    @foreach($lesVisiteurs as $unVisiteur)

                    <tr>

                        <td>{{$unVisiteur['id']}}</td>

                        <td>{{$unVisiteur['nom']}}</td>

                        <td>{{$unVisiteur['prenom']}}</td>

                        <td>
                            <a href="{{Route('chemin_modifierVisiteur', ['id'=>$unVisiteur['id']])}}" id="ok" class="btn btn-outline-info">Modifier</a>
                            <a href="{{Route('voirsupprimerVisiteur', ['id'=>$unVisiteur['id']])}}" id="ok" class="btn btn-outline-danger">Supprimer</a>
                            <a href="{{Route('genererPDF', ['id'=>$unVisiteur['id']])}}" id="ok" class="btn btn-outline-success">PDF</a>
                        </td>


                    </tr>
                    @endforeach


                </tbody>





            </table>

            <br>
            <br>

            <a href="{{Route('nouveauVisiteur')}}" id="ok" class="btn btn-outline-info">Ajouter un visiteur</a>



        </div>
  @endsection
