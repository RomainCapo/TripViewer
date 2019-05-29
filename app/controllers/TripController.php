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

  /**
   * Permet d'exporter tous les voyages dans un document PDF.
   */
  public function exportAllToPdf()
  {
    User::userIsConnected();
    $trips = Trip::fetchTripById(unserialize($_SESSION['login'])->getId());

    $pdf = Trip::initPdf();
    foreach ($trips as $key => $value)
    {
      //Si c'est la première page on ne veut pas de saut de ligne
      if($key == 0)
      {
        $pdf = $value->exportToPdf($pdf, false);
      }
      else
      {
        $pdf = $value->exportToPdf($pdf, true);
      }

    }
    $pdf->Output();
  }

/**
 * Permet d'exporter un seul voyage dans un document PDF
 */
  public function exportToPdf()
  {
    //On teste si l'utilisateur est connecté et que le voyage lui appartient bien
    User::userIsConnected();
    if(isset($_POST['exportToPdf'])  &&(Trip::getIdUserByTripId($_POST['exportToPdf']) == unserialize($_SESSION['login'])->getId()))
    {
      $id = $_POST['exportToPdf'];

      $pdf = Trip::initPdf();

      $trip = Trip::fetchById($id);
      $pdf = $trip->exportToPdf($pdf, false);
      $pdf->Output();
    }
    else
    {
      header('Location: tripViewList');
      exit(0);
    }
  }
}
