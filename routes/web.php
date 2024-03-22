<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
        /*-------------------- Use case connexion---------------------------*/
Route::get('/',[
        'as' => 'chemin_connexion',
        'uses' => 'connexionController@connecter'
]);

Route::post('/',[
        'as'=>'chemin_valider',
        'uses'=>'connexionController@valider'
]);
Route::get('deconnexion',[
        'as'=>'chemin_deconnexion',
        'uses'=>'connexionController@deconnecter'
]);

         /*-------------------- Use case état des frais---------------------------*/
Route::get('selectionMois',[
        'as'=>'chemin_selectionMois',
        'uses'=>'etatFraisController@selectionnerMois'
]);

Route::post('listeFrais',[
        'as'=>'chemin_listeFrais',
        'uses'=>'etatFraisController@voirFrais'
]);

         /*-------------------- Use case gérer les frais---------------------------*/

Route::get('gererFrais',[
        'as'=>'chemin_gestionFrais',
        'uses'=>'gererFraisController@saisirFrais'
]);

Route::post('sauvegarderFrais',[
        'as'=>'chemin_sauvegardeFrais',
        'uses'=>'gererFraisController@sauvegarderFrais'
]);

         /*-------------------- Use case gérer les visiteurs---------------------------*/


Route::get('test',[
        'as'=>'chemin_test',
        'uses'=>'etatFraisController@test'
]);

Route::get('afficherVisiteur', [
        'as' =>'chemin_afficherVisiteur',
        'uses'=>'gestionVisiteurController@afficherVisiteur'
]);

Route::get('modifierVisiteur', [
        'as' =>'chemin_modifierVisiteur',
        'uses'=>'gestionVisiteurController@modifierVisiteur'
]);

Route::post('rajouterVisiteur', [
        'as' =>'rajouterVisiteur',
        'uses'=>'gestionVisiteurController@rajouterVisiteur'
]);

Route::get('nouveauVisiteur', [
        'as' =>'nouveauVisiteur',
        'uses'=>'gestionVisiteurController@nouveauVisiteur'
]);

Route::post('ajouterVisiteur', [
        'as' =>'ajouterVisiteur',
        'uses'=>'gestionVisiteurController@ajouterVisiteur'
]);

Route::get('voirsupprimerVisiteur', [
        'as' =>'voirsupprimerVisiteur',
        'uses'=>'gestionVisiteurController@voirsupprimerVisiteur'
]);

Route::post('supprimerVisiteur', [
        'as' =>'supprimerVisiteur',
        'uses'=>'gestionVisiteurController@supprimerVisiteur'
]);


        /*-------------------- Use case Comptables---------------------------*/

Route::get('afficherFicheFraisId', [
        'as' =>'afficherFicheFraisId',
        'uses' =>'gestionVisiteurController@afficherFicheFraisId'
]);

Route::post('afficherFicheFraisIdMois', [
    'as' =>'afficherFicheFraisIdMois',
    'uses' =>'gestionVisiteurController@afficherFicheFraisIdMois'
]);

Route::post('afficherFicheFraisSelectionner', [
    'as' =>'afficherFicheFraisSelectionner',
    'uses' =>'gestionVisiteurController@afficherFicheFraisSelectionner'
]);

Route::post('modifierEtat', [
    'as' =>'modifierEtat',
    'uses' =>'gestionVisiteurController@modifierEtat'
]);

Route::post('etatEstModifier', [
    'as' =>'etatEstModifier',
    'uses' =>'gestionVisiteurController@etatEstModifier'
]);

Route::get('genererPDF', [
    'as' =>'genererPDF',
    'uses' =>'gestionVisiteurController@genererPDF'
]);



