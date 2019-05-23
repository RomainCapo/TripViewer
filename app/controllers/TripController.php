<?php

class TripController
{
  /**
   * Affiche la liste des voyages, selon l'id de l'utilisateur
   * @return view vue des voyages sous formes de listes
   */
  public function index()
  {
    User::userIsConnected();
    return Helper::view("viewList", ['trips' => Trip::fetchTripById(unserialize($_SESSION['login'])->getId())]);
  }

  /**
   * affiche la vue de la map
   * @return view vue de la map
   */
  public function mapView()
  {
    User::userIsConnected();
    return Helper::view("tripMap");
  }

  /**
   * Retourne un json avec tous les voyages de l'utilisateur
   * @return json voyage de l'utilisateur
   */
  public function getAllUserTripCoord()
  {
    User::userIsConnected();
    $userId = unserialize($_SESSION['login'])->getId();
    echo json_encode(Trip::getUserTripInfo($userId));
  }

  /**
   * permet d'afficher un voyage sur une page individuelle
   * @return view la vue pour visualiser le voyage, on redirection s'il y a une erreur
   */
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
