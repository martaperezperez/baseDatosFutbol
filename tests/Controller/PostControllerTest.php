<?php

namespace App\Tests\Controller;

use App\Controller\PlayerController;
use App\Entity\Player;
use App\Repository\PlayerRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase
{

    private static $client;

    public function setUp(): void
    {
        parent::setUp();

        if (null === self::$client) {
            self::$client = static::createClient();
        }
    }

//-------------------------------------------------------------------INDEX PLAYER----------------------------------------------------------------------//
    public function testResponseSuccesfulIndexPlayer(): void
    {
        $client = self::$client;
        $crawler = $client->request('GET', '//futbol.localhost/player');
        $this->assertResponseIsSuccessful();
        $responseContent = $client->getResponse()->getContent();
        echo $responseContent . PHP_EOL;

    }

    public function testResponseIsJsonPlayer(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '//futbol.localhost/player');
        $this->assertResponseFormatSame("json");
        $responseContent = $client->getResponse()->getContent();
        echo $responseContent . PHP_EOL;
    }

    public function testResponseHasPlayer(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '//futbol.localhost/player');
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        $responseContent = $client->getResponse()->getContent();
        echo $responseContent . PHP_EOL;
    }

    public function testResponseExceptionPlayer(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '//futbol.localhost/player');
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $client->catchExceptions(false);
        $responseContent = $client->getResponse()->getContent();
        echo $responseContent . PHP_EOL;
    }
//------------------------------------------------------------------------ METODO createPlayerData ----------------------------------------------------------------------------//
    private function createPlayerData(): array
    {
        return [
            "dni" => "213045" . rand(10, 99) . "O",
            "name" => "Marta",
            "last_name" => "Perez",
            "team" => "Hosfdst",
            "salary" => 1000,
            "position" => "Portero",
            "dorsal" => rand(1, 99),
            "email" => "marta.perez_" . rand(10, 50) . "@xilon.es",
            "phone" => "125656" . rand(100, 999)];
    }
//---------------------------------------------------------------- CREATE PLAYER ----------------------------------------------------------------------------------------//
    public function testResponseSuccessfulCreatePlayer(): void
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '//futbol.localhost/player/create',$this->createPlayerData());
        $this->assertResponseIsSuccessful();
    }

    public function  testResponseIsJsonCreatePlayer():void
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '//futbol.localhost/player/create', $this->createPlayerData());
        $this->assertResponseFormatSame("json");
    }
    public function testResponseHasCreatePlayer (): void {
           $client = static ::createClient();
           $crawler = $client->request('POST', '//futbol.localhost/player/create', $this->createPlayerData());
           $response = $client->getResponse();
           $this->assertTrue($response->headers->contains('Content-Type','application/json'));
           $this->assertJson($response->getContent());
           $responseData= json_decode($response->getContent(), true);
       }

       public function testResponseExceptionCreatePlayer(): void {
           $client= static ::createClient();
           $crawler = $client->request('POST','//futbol.localhost/player/create', $this->createPlayerData());
           $response = $client->getResponse();
           $this->assertTrue($response->headers->contains('Content-Type','application/json'));
           $this->assertJson($response->getContent());
           $client->catchExceptions(false);
       }
//------------------------------------------------------------------------ METODO createRandPlayer -----------------------------------------------------------------//
    private function createRandPlayer(): int
    {
        $client = self::$client;
        $crawler = $client->request('GET', '//futbol.localhost/player');
        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);
        $ids = [];
        foreach ($data["players"] as $player) {
            $ids[] = $player["id"];
        }
        return $ids[array_rand($ids)];
    }
//------------------------------------------------------------------- DELETE PLAYER --------------------------------------------------------------------------------//
    public function testResponseSuccessfulDeletePlayer(): void
    {
         $client= static ::createClient();
        $crawler = $client->request('DELETE', '//futbol.localhost/player/delete/'.$this->createRandPlayer());
        $this->assertResponseIsSuccessful();
        echo ("PLAYER: " . $this->createRandPlayer() . " DELETED") . PHP_EOL;
    }
    public function testResponseIsJsonDeletePlayer(): void {
        $client= static ::createClient();
        $crawler=$client->request('DELETE', '//futbol.localhost/player/delete/'.$this->createRandPlayer());
        $this->assertResponseFormatSame("json");
        $this->assertResponseIsSuccessful();
        echo ("PLAYER: " . $this->createRandPlayer() . " DELETED") . PHP_EOL;
    }
    public function testResponseHasDeletePlayer():void {
        $client= static ::createClient();
        $crawler = $client->request('DELETE', '//futbol.localhost/player/delete/'.$this->createRandPlayer());
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $client->catchExceptions(false);
        $this->assertResponseIsSuccessful();
        echo ("PLAYER: " . $this->createRandPlayer() . " DELETED") . PHP_EOL;
    }
    public function testResponseExceptionDeletePlayer():void{
         $client= static ::createClient();
        $crawler = $client->request('DELETE', '//futbol.localhost/player/delete/'.$this->createRandPlayer());
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $client->catchExceptions(false);
        $this->assertResponseIsSuccessful();
        echo ("PLAYER: " . $this->createRandPlayer() . " DELETED") . PHP_EOL;
    }
//-------------------------------------------------------------- SHOW PLAYER ---------------------------------------------------------------------------------------//
    public function testResponseSuccessfulShowPlayer(): void{
        $client= static ::createClient();
        $crawler = $client->request('GET', '//futbol.localhost/player/show/'.$this->createRandPlayer());
        $this->assertResponseIsSuccessful();
    }
    public function testResponseIsJsonShowPlayer(): void {
        $client= static ::createClient();
        $crawler=$client->request('GET', '//futbol.localhost/player/show/'.$this->createRandPlayer());
        $this->assertResponseFormatSame("json");
    }
    public function testResponseHasShowPlayer():void {
        $client= static ::createClient();
        $crawler = $client->request('GET', '//futbol.localhost/player/show/'.$this->createRandPlayer());
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $client->catchExceptions(false);
    }
    public function testResponseExceptionShowPlayer():void{
         $client= static ::createClient();
        $crawler = $client->request('GET', '//futbol.localhost/player/show/'.$this->createRandPlayer());
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $client->catchExceptions(false);
    }

//------------------------------------------------------------- UPDATE PLAYER -------------------------------------------------------------------------------------//
    public function testResponseSuccessfulUpdatePlayer(): void{
         $client= static ::createClient();
        $crawler = $client->request('PUT', '//futbol.localhost/player/update/'.$this->createRandPlayer(), $this->createPlayerData());
        $this->assertResponseIsSuccessful();

    }
    public function testResponseIsJsonUpdatePlayer(): void{
        $client= static ::createClient();
        $crawler = $client->request('PUT', '//futbol.localhost/player/update/'.$this->createRandPlayer(), $this->createPlayerData());
        $this->assertResponseFormatSame("json");
    }
    public function testResponseHasUpdatePlayer():void{
        $client= static ::createClient();
        $crawler = $client->request('PUT', '//futbol.localhost/player/update/'.$this->createRandPlayer(),$this->createPlayerData());
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type','application/json'));
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(),true);
    }
    public function testResponseExceptionUpdatePlayer(): void{
        $client= static ::createClient();
        $crawler = $client->request('PUT','//futbol.localhost/player/update/'.$this->createRandPlayer());
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type','application/json'));
        $this->assertJson($response->getContent());
        $client->catchExceptions(false);
    }
//----------------------------------------------------------- CLUB INDEX PLAYER ------------------------------------------------------------------------------------//
    public function testResponseSuccessfulClubIndexPlayer():void{
         $client= static ::createClient();
        $crawler = $client->request('GET','//futbol.localhost/club/'.$this->CreateRandClub().'/index_player');
        $this->assertResponseIsSuccessful();
        $responseContent = $client->getResponse()->getContent();
        echo $responseContent . PHP_EOL;
    }
    public function testResponseIsJsonClubIndexPlayer(): void{
        $client= static ::createClient();
        $crawler= $client->request('GET', '//futbol.localhost/club/'.$this->CreateRandClub().'/index_player');
        $this->assertResponseFormatSame("json");
        $responseContent = $client->getResponse()->getContent();
        echo $responseContent . PHP_EOL;
    }
    public function testResponseHasClubIndexPlayer():void{
        $client= static ::createClient();
        $crawler = $client->request('GET', '//futbol.localhost/club/'.$this->CreateRandClub().'/index_player');
        $response= $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type','application/json'));
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        $responseContent = $client->getResponse()->getContent();
        echo $responseContent . PHP_EOL;
    }
    public function testResponseExceptionClubIndexPlayer (): void{
        $client= static ::createClient();
        $crawler = $client->request('GET', '//futbol.localhost/club/'.$this->CreateRandClub().'/index_player');
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $client->catchExceptions(false);
        $responseContent = $client->getResponse()->getContent();
        echo $responseContent . PHP_EOL;
    }
//---------------------------------------------------------- INDEX COACH -------------------------------------------------------------------------------------------//
     public function testResponseSuccessfulIndexCoach(): void{
         $client= static ::createClient();
         $crawler = $client->request('GET', '//futbol.localhost/coach');
         $this->assertResponseIsSuccessful();
         $responseContent = $client->getResponse()->getContent();
         echo $responseContent . PHP_EOL;
     }
     public function testResponseIsJsonCoach(): void{
         $client = static::createClient();
         $crawler = $client->request('GET', '//futbol.localhost/coach');
         $this->assertResponseFormatSame("json");
         $responseContent = $client->getResponse()->getContent();
         echo $responseContent . PHP_EOL;
     }
     public function testResponseHasCoach(): void{
         $client = static::createClient();
         $crawler = $client->request('GET', '//futbol.localhost/coach');
         $response = $client->getResponse();
         $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
         $this->assertJson($response->getContent());
         $responseData = json_decode($response->getContent(), true);
         $responseContent = $client->getResponse()->getContent();
         echo $responseContent . PHP_EOL;
     }
     public function testResponseExceptionCoach(): void{
         $client = static::createClient();
         $crawler = $client->request('GET', '//futbol.localhost/coach');
         $response=$client->getResponse();
         $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
         $this->assertJson($response->getContent());
         $client->catchExceptions(false);
         $responseContent = $client->getResponse()->getContent();
         echo $responseContent . PHP_EOL;
     }
//------------------------------------------------------- METODO createCoachData ------------------------------------------------------------------------------//
    private function createCoachData(): array
    {
        return ["dni" => "123453" . rand(10, 99) . "K",
            "name" => "Ruben",
            "last_name" => "Gonzalez",
            "team" => "Ujopraestj",
            "salary" => 1022,
            "email" => "marta.perez_" . rand(10, 50) . "@xilon.es",
            "phone" => "123456" . rand(100, 999)
        ];
    }
//----------------------------------------------------- CREATE COACH -----------------------------------------------------------------------------------------//
        public function testResponseSuccessfulCreateCoach(): void{
            $client = static::createClient();
            $crawler = $client->request('POST', '//futbol.localhost/coach/create', $this->createCoachData());
            $this->assertResponseIsSuccessful();
        }
        public function testResponseIsJsonCreateCoach():void {
            $client = static::createClient();
            $crawler = $client->request('POST', '//futbol.localhost/coach/create', $this->createCoachData());
            $this->assertResponseFormatSame("json");
        }
        public function testResponseHasCreateCoach():void{
            $client = static ::createClient();
            $crawler = $client->request('POST', '//futbol.localhost/coach/create', $this->createCoachData());
            $response = $client->getResponse();
            $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
            $this->assertJson($response->getContent());
            $responseData = json_decode($response->getContent(), true );
        }
        public function testResponseExceptionCreateCoach(): void{
            $client= static::createClient();
            $crawler = $client->request('POST', '//futbol.localhost/coach/create', $this->createCoachData());
            $response = $client->getResponse();
            $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
            $this->assertJson($response->getContent());
            $client->catchExceptions(false);
        }
//------------------------------------------------------ METODO CreateRandCoach --------------------------------------------------------------------------------------//
    private function CreateRandCoach(): int
    {
        $client = self::$client;
        $crawler = $client->request('GET', '//futbol.localhost/coach');
        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);
        $ids = [];
        foreach ($data["Coachs"] as $coach) {
            $ids[] = $coach["id"];
        }
        return $ids[array_rand($ids)];
    }
//-------------------------------------------------------- DELETE COACH ----------------------------------------------------------------------------------------------//
    public function testResponseSuccessfulDeleteCoach():void{
        $client= static::createClient();
        $crawler = $client->request('DELETE', '//futbol.localhost/coach/delete/'.$this->CreateRandCoach());
        $this->assertResponseIsSuccessful();
        echo ("COACH: " . $this->CreateRandCoach() . " DELETED") . PHP_EOL;

    }
    public function testResponseIsJsonDeleteCoach(): void {
       $client= static::createClient();
        $crawler= $client->request('DELETE', '//futbol.localhost/coach/delete/'.$this->CreateRandCoach());
        $this->assertResponseFormatSame("json");
        $this->assertResponseIsSuccessful();
        echo ("COACH: " . $this->CreateRandCoach() . " DELETED") . PHP_EOL;
    }
    public function testResponseHasDeleteCoach(): void {
         $client= static ::createClient();
        $crawler = $client->request('DELETE', '//futbol.localhost/coach/delete/'.$this->CreateRandCoach());
        $response= $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $client->catchExceptions(false);
        $this->assertResponseIsSuccessful();
        echo ("COACH: " . $this->CreateRandCoach() . " DELETED") . PHP_EOL;
    }
    public function testResponseExceptionDeleteCoach(){
        $client= static ::createClient();
        $crawler = $client->request('DELETE', '//futbol.localhost/coach/delete/'.$this->CreateRandCoach());
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $client->catchExceptions(false);
        $this->assertResponseIsSuccessful();
        echo ("COACH: " . $this->CreateRandCoach() . " DELETED") . PHP_EOL;
    }
//------------------------------------------------------ SHOW COACH -------------------------------------------------------------------------------------------------//
        public function  testResponseSuccessfulShowCoach(): void {
            $client= static::createClient();
        $crawler = $client->request('GET', '//futbol.localhost/coach/show/'.$this->CreateRandCoach());
        $this->assertResponseIsSuccessful();
        }
    public function testResponseIsJsonShowCoach(): void {
        $client= static ::createClient();
        $crawler=$client->request('GET', '//futbol.localhost/coach/show/'.$this->CreateRandCoach());
        $this->assertResponseFormatSame("json");
    }
    public function testResponseHasShowCoach():void {
        $client= static ::createClient();
        $crawler = $client->request('GET', '//futbol.localhost/coach/show/'.$this->CreateRandCoach());
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $client->catchExceptions(false);
    }
    public function testResponseExceptionShowCoach():void{
         $client= static ::createClient();
        $crawler = $client->request('GET', '//futbol.localhost/coach/show/'.$this->CreateRandCoach());
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $client->catchExceptions(false);
    }
//---------------------------------------------------- UPDATE COACH -------------------------------------------------------------------------------------------------//
    public function testResponseSuccessfulUpdateCoach(): void {
        $client= static::createClient();
        $crawler = $client->request('PUT', '//futbol.localhost/coach/update/'.$this->CreateRandCoach(), $this->createCoachData());
        $this->assertResponseIsSuccessful();
    }
    public function testResponseIsJsonUpdateCoach(): void {
        $client= static::createClient();
        $crawler = $client->request('PUT', '//futbol.localhost/coach/update/'.$this->CreateRandCoach(),$this->createCoachData());
        $this->assertResponseFormatSame("json");
    }
    public function testResponseHasUpdateCoach():void{
       $client= static::createClient();
        $crawler = $client->request('PUT','//futbol.localhost/coach/update/'.$this->CreateRandCoach(), $this->createCoachData());
        $response= $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type','application/json'));
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
    }
    public function testResponseExceptionUpdateCoach(): void {
        $client= static::createClient();
        $crawler = $client->request('PUT', '//futbol.localhost/coach/update/'.$this->CreateRandCoach(),$this->createCoachData());
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type','application/json'));
        $this->assertJson($response->getContent());
        $client->catchExceptions(false);
    }
//-------------------------------------------------------- INDEX CLUB ----------------------------------------------------------------------------------------------//
     public function testResponseSuccessfulIndexClub(): void {
         $client= static ::createClient();
         $crawler = $client->request('GET','//futbol.localhost/club');
         $this->assertResponseIsSuccessful();
     }
     public function testResponseIsJsonClub(): void {
         $client = static::createClient();
         $crawler = $client->request('GET', '//futbol.localhost/club');
         $this->assertResponseFormatSame("json");
     }
     public function testResponseHasClub(): void{
         $client = static::createClient();
         $crawler = $client->request('GET','//futbol.localhost/club');
         $response = $client->getResponse();
         $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
         $this->assertJson($response->getContent());
         $responseData= json_decode($response->getContent(), true);
     }
     public function testResponseExceptionClub(): void{
         $client= static::createClient();
         $crawler = $client->request('GET', '//futbol.localhost/club');
         $response = $client->getResponse();
         $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
         $this->assertJson($response->getContent());
         $client->catchExceptions(false);
     }
//------------------------------------------------------ METODO createClubData --------------------------------------------------------------------------------//
    private function createClubData(): array
    {
        return ["name" => "Fgdhg" . rand(0, 99),
            "budget" => 2345,
            "email" => "marta.perez_" . rand(10, 50) . "@xilon.es",
            "phone" => "123456" . rand(100, 999)
        ];
    }
//------------------------------------------------------ CREATE CLUB ------------------------------------------------------------------------------------------//
    public function testResponseSuccessfulCreateClub(): void{
        $client = static ::createClient();
        $crawler = $client->request('POST', '//futbol.localhost/club/create', $this->createClubData());
        $this->assertResponseIsSuccessful();
    }
    public function testResponseIsJsonCreateClub(): void{
        $client = static ::createClient();
        $crawler= $client->request('POST', '//futbol.localhost/club/create', $this->createClubData());
        $this->assertResponseFormatSame("json");
    }
    public function testResponseHasCreateClub():void {
        $client = static::createClient();
        $cawler = $client->request('POST', '//futbol.localhost/club/create', $this->createClubData());
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
    }
    public function testResponseExceptionCreateClub(): void {
        $client = static::createClient();
        $crawler = $client->request('POST', '//futbol.localhost/club/create', $this->createClubData());
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $client->catchExceptions(false);
    }
//----------------------------------------------------------- METODO CreateRandClub --------------------------------------------------------------------------//
    private function CreateRandClub(): int
    {
        $client = self::$client;
        $crawler = $client->request('GET', '//futbol.localhost/club');
        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);
        $ids = [];
        foreach ($data["Clubs"] as $club) {
            $ids[] = $club["id"];
        }
        return $ids[array_rand($ids)];
    }
//---------------------------------------------------------- DELETE CLUB -----------------------------------------------------------------------------------//
    public function testResponseSuccessfulDeleteClub():void{
        $client = static::createClient();
        $crawler = $client->request('DELETE', '//futbol.localhost/club/delete/'.$this->CreateRandClub());
        $this->assertResponseIsSuccessful();
        echo ("CLUB: " . $this->CreateRandClub() . " DELETED") . PHP_EOL;
    }
    public function testResponseIsJsonDeleteClub(): void{
         $client= static ::createClient();
        $crawler= $client->request('DELETE', '//futbol.localhost/club/delete/'.$this->CreateRandClub());
        $this->assertResponseFormatSame("json");
        $this->assertResponseIsSuccessful();
        echo ("CLUB: " . $this->CreateRandClub() . " DELETED") . PHP_EOL;
    }
    public function testResponseHasDeleteClub():void {
        $client= static ::createClient();
        $crawler = $client->request('DELETE', '//futbol.localhost/club/delete/'.$this->CreateRandClub());
        $response=$client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        $this->assertResponseIsSuccessful();
        echo ("CLUB: " . $this->CreateRandClub() . " DELETED") . PHP_EOL;
    }
    public function testResponseExceptionDeleteClub(): void {
        $client= static ::createClient();
        $crawler = $client->request('DELETE', '//futbol.localhost/club/delete/'.$this->CreateRandClub());
       $response= $client->getResponse();
       $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $client->catchExceptions(false);
        $this->assertResponseIsSuccessful();
        echo ("CLUB: " . $this->CreateRandClub() . " DELETED") . PHP_EOL;
    }
//--------------------------------------------------------- SHOW CLUB -------------------------------------------------------------------------------------//
    public function testResponseSuccessfulShowClub(): void {
        $client = static::createClient();
        $crawler = $client->request('GET', '//futbol.localhost/club/show/'.$this->CreateRandClub());
        $this->assertResponseIsSuccessful();
  }
    public function testResponseIsJsonShowClub(): void {
        $client = static::createClient();;
        $crawler=$client->request('GET', '//futbol.localhost/club/show/'.$this->CreateRandClub());
        $this->assertResponseFormatSame("json");
    }
    public function testResponseHasShowClub():void {
        $client = static::createClient();;
        $crawler = $client->request('GET', '//futbol.localhost/club/show/'.$this->CreateRandClub());
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $client->catchExceptions(false);
    }
    public function testResponseExceptionShowClub():void{
         $client= static ::createClient();
        $crawler = $client->request('GET', '//futbol.localhost/club/show/'.$this->CreateRandClub());
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $client->catchExceptions(false);
    }
//-------------------------------------------------------- UPDATE CLUB -----------------------------------------------------------------------------------//
    public function testResponseSuccessfulUpdateClub(): void {
        $client = static::createClient();
        $crawler = $client->request('PUT', '//futbol.localhost/club/update/'.$this->CreateRandClub(), $this->createClubData());
        $this->assertResponseIsSuccessful();
    }
    public function testResponsIsJsonUpdateClub():void{
       $client = static::createClient();
        $crawler = $client->request('PUT', '//futbol.localhost/club/update/'.$this->CreateRandClub(), $this->createClubData());
        $this->assertResponseFormatSame("json");
    }
    public function testResponseHasUpdateClub(): void {
          $client = static::createClient();
        $crawler = $client->request('PUT', '//futbol.localhost/club/update/'.$this->CreateRandClub(), $this->createClubData());
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type','application/json'));
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
    }
    public function testResponseExceptionUpdateClub():void{
        $client = static::createClient();
        $crawler = $client->request('PUT', '//futbol.localhost/club/update/'.$this->CreateRandClub(), $this->createClubData());
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type','application/json'));
        $this->assertJson($response->getContent());
        $client->catchExceptions(false);
}
//----------------------------------------------------- CLUB CREATE PLAYER -----------------------------------------------------------------------------//
    public function testResponseSuccessfulClubCreatePlayer(): void {
        $client = static::createClient();
        $crawler = $client->request('POST', '//futbol.localhost/club/'.$this->CreateRandClub().'/create_player/', $this->createPlayerData());
        $this->assertResponseIsSuccessful();
    }
    public function testResponseIsJsonClubCreatePlayer(): void{
        $client = static::createClient();
        $crawler = $client->request('POST', '//futbol.localhost/club/'.$this->CreateRandClub().'/create_player/',$this->createPlayerData());
        $this->assertResponseFormatSame("json");
    }
    public function testResponseHasClubCreatePlayer (): void{
       $client = static::createClient();
        $crawler= $client->request('POST', '//futbol.localhost/club/'.$this->CreateRandClub().'/create_player/', $this->createPlayerData());
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
    }
    public function testResponseExceptionClubCreatePlayer():void{
         $client = static::createClient();
        $crawler= $client->request('POST','//futbol.localhost/club/'.$this->CreateRandClub().'/create_player/',$this->createPlayerData());
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type','application/json'));
        $this->assertJson($response->getContent());
        $client->catchExceptions(false);
    }
//----------------------------------------------------- CLUB DELETE PLAYER ------------------------------------------------------------------------------//
    public function testResponseSuccessfulClubDeletePlayer(): void {
        $client = static::createClient();
       $crawler= $client->request('DELETE', '//futbol.localhost/club/'.$this->CreateRandClub().'/delete_player/'.$this->createRandPlayer());
       $this->assertResponseIsSuccessful();
        echo ("PLAYER : " . $this->createRandPlayer() . " IN CLUB: " . $this->CreateRandClub() ." DELETED") . PHP_EOL;
    }
    public function testResponseIsJsonClubDeletePlayer(): void{
        $client = static::createClient();
        $crawler = $client->request('DELETE', '//futbol.localhost/club/'.$this->CreateRandClub().'/delete_player/'.$this->createRandPlayer());
        $this->assertResponseFormatSame("json");
    }
    public function testResponseHasClubDeletePlayer(): void
    {
        $client = static::createClient();
        $crawler = $client->request('DELETE', '//futbol.localhost/club/'.$this->CreateRandClub().'/delete_player/'.$this->createRandPlayer());
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);

    }

    public function testResponseExceptionClubDeletePlayer(): void
    {
        $client = static::createClient();
        $crawler = $client->request('DELETE', '//futbol.localhost/club/'.$this->CreateRandClub().'/delete_player/'.$this->createRandPlayer());
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $client->catchExceptions(false);
    }
//------------------------------------------------------ CLUB CREATE COACH -----------------------------------------------------------------------------//
    public function testResponseSuccessfulClubCreateCoach(): void
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '//futbol.localhost/club/' . $this->CreateRandClub() . '/create_coach', $this->createCoachData());
        $this->assertResponseIsSuccessful();
    }

    public function testResponseIsJsonClubCreateCoach(): void
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '//futbol.localhost/club/' . $this->CreateRandClub() . '/create_coach', $this->createCoachData());
        $this->assertResponseFormatSame("json");
    }

    public function testResponseHasClubCreateCoach(): void
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '//futbol.localhost/club/' . $this->CreateRandClub() . '/create_coach', $this->createCoachData());
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
    }

    public function testResponseExceptionClubCreateCoach(): void
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '//futbol.localhost/club/' . $this->CreateRandClub() . '/create_coach', $this->createCoachData());
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $client->catchExceptions(false);
    }

//----------------------------------------------------- CLUB DELETE COACH -------------------------------------------------------------------------------//
    public function testResponseSuccessfulClubDeleteCoach(): void
    {
       $client = static::createClient();
        $crawler = $client->request('DELETE', '//futbol.localhost/club/'.$this->CreateRandClub().'/delete_coach/'.$this->CreateRandCoach());
        $this->assertResponseIsSuccessful();
        echo ("COACH : " . $this->CreateRandCoach() . " IN CLUB: " . $this->CreateRandClub() ." DELETED") . PHP_EOL;
    }
    public function testResponseIsJsonClubDeleteCoach(): void{
        $client = static::createClient();
        $crawler = $client->request('DELETE', '//futbol.localhost/club/'.$this->CreateRandClub().'/delete_coach/'.$this->CreateRandCoach());
        $this->assertResponseFormatSame("json");
    }
    public function testResponseHasClubDeleteCoach(): void
    {
        $client = static::createClient();
        $crawler = $client->request('DELETE', '//futbol.localhost/club/'.$this->CreateRandClub().'/delete_coach/'.$this->CreateRandCoach());
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);

    }


    public function testResponseExceptionClubDeleteCoach(): void
    {
        $client = static::createClient();
        $crawler = $client->request('DELETE', '//futbol.localhost/club/'.$this->CreateRandClub().'/delete_coach/'.$this->CreateRandCoach());
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $client->catchExceptions(false);
    }


}

