<?php

class TripController
{
  //@summary Affiche la liste des voyages, selon l'id de l'utilisateur
  public function index()
  {
    User::userIsConnected();
    return Helper::view("viewList", ['trips' => Trip::fetchTripById(unserialize($_SESSION['login'])->getId())]);
  }

  //@summary permet d'afficher un voyage sur une page individuelle
  //@return la vue pour visualiser le voyage, on redirection s'il y a une erreur
  public function showTrip()
  {
    User::userIsConnected();
    if(isset($_GET["id"]) && ctype_digit($_GET["id"]) && (Trip::getIdUserByTripId($_GET['id']) == unserialize($_SESSION['login'])->getId()))
    {
      $id = $_GET['id'];

      return Helper::view("showTrip",['trips' => Trip::fetchById($id, 'trip', 'Trip')]);
    }
    else {
      header('Location: tripViewList');
      exit(0);
    } 
  }
}
