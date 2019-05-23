<?php
declare(strict_types=1);

require_once('./core/bootstrap.php');

use PHPUnit\Framework\TestCase;

/*
Classe de test qui a pur but de tester les différentes méthodes de la classe Destination
*/
final class TestDestination extends TestCase
{
    /*
    Méthodes testées :
      - saveDestination
      - getDestinationById
      - destinationInDb
      - getDestInfo
    */

    /*
    Ce test a pour but de confirmer l'ajout d'une destination dans la base de données.
    On crée un array avec la latitude, longitude et le pays, puis on appelle la méthode saveDestination. Elle retourne l'id.
    On réalise un assert en comparant le nom de la destination en passant l'id reçu auparavant avec la destination qu'on doit normalement recevoir
    On retourne l'id, avec le @depends de la function de test testGetDestInfo() situé plu bas, on pourra récupérer cette valeur pour d'autres tests
    */
    public function testAjoutDb()
    {
      $arrayDest = array("latitude" => 46.95, "longitude" => 6.8333, "country" => "switzerland");
      $idDest = Destination::saveDestination("boudry", $arrayDest);

      $this->assertEquals(Destination::getDestinationById($idDest), 'boudry');

      return $idDest;
    }

    /*
    Ce test a pour but de tester si une destination est bien dans la base de données.
    On fait un assert entre l'appel de la méthode destinationInDb() avec le nom d'une destination, celle-ci renverra un boolean.
    Comme nous avons ajouté précédement boudry à la base de données, celle-ci doit normalemement renvoyée true.
    */
    public function testDestinatioIsInDb():void
    {
      $this->assertEquals(Destination::destinationInDb("boudry"), true);
    }

    /*
    On test ici la méthode getDestInfo(), à laquelle on passe l'id que nous avons récupérée du premier test.
    On effectue ensuite trois asserts, un pour chaque donnée retournée (en effet getDestInfo() retourne un tableau avec des informations comme la latitude ou le pays par exemple).
    */

    /**
     * @depends testAjoutDb
     */
    public function testGetDestInfo(): void
    {
        $arrayData = Destination::getDestInfo(func_get_args()[0]);
        $this->assertEquals($arrayData['coun'], 'switzerland');
        $this->assertEquals($arrayData['lat'], 46.95);
        $this->assertEquals($arrayData['lng'], 6.8333);
    }
}
