<?php
declare(strict_types=1);

require_once('./core/bootstrap.php');

use PHPUnit\Framework\TestCase;

final class TestDestination extends TestCase
{
    /*
    Méthodes testées :
      - saveDestination
      - getDestinationById
      - destinationInDb
      - getDestInfo
    */

    public function testAjoutDb()
    {
      $arrayDest = array("latitude" => 46.95, "longitude" => 6.8333, "country" => "switzerland");
      $idDest = Destination::saveDestination("boudry", $arrayDest);

      $this->assertEquals(Destination::getDestinationById($idDest), 'boudry');

      return $idDest;
    }

    public function testDestinatioIsInDb():void
    {
      $this->assertEquals(Destination::destinationInDb("boudry"), true);
    }

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
