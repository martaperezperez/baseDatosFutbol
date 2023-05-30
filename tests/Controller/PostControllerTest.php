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


     public function testResponseSuccesfulIndexPlayer(): void {
        $client = self::$client;
         $crawler = $client->request('GET', '//futbol.localhost/player');
         $this->assertResponseIsSuccessful();
         $responseContent = $client->getResponse()->getContent();
         echo $responseContent . PHP_EOL;

     }
     public function testResponseIsJsonPlayer(): void{
         $client = static::createClient();
         $crawler = $client->request('GET', '//futbol.localhost/player');
         $this->assertResponseFormatSame("json");
     }
     public function testResponseHasPlayer(): void {
         $client = static::createClient();
         $crawler = $client->request('GET', '//futbol.localhost/player');
         $response=$client->getResponse();
         $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
         $this->assertJson($response->getContent());
         $responseData = json_decode($response->getContent(), true);
     }
     public function testResponseExceptionPlayer(): void{
         $client = static::createClient();
         $crawler = $client->request('GET', '//futbol.localhost/player');
         $response=$client->getResponse();
         $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
         $this->assertJson($response->getContent());
         $client->catchExceptions(false);
     }



       private function createPlayerData(): array
        {
        return [
            "dni" => "213045".rand(10,99)."O",
            "name" => "Marta",
            "last_name" => "Perez",
            "team" => "Hosfdst",
            "salary" => 1000,
            "position" => "Portero",
            "dorsal" => rand(1,99),
            "email" => "marta.perez_".rand(10,50)."@xilon.es",
            "phone" => "125656".rand(100,999)];
        }

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






    private function createRandPlayer(): int
    {
        $client = self::$client;
        $crawler = $client->request('GET', '//futbol.localhost/player');
        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);
        $ids=[];
        foreach($data["players"] as $player){
            $ids[]=$player["id"];
        }
        return $ids[array_rand($ids)];
    }



    public function testResponseSuccessfulDeletePlayer(): void
    {
         $client= static ::createClient();
        $crawler = $client->request('DELETE', '//futbol.localhost/player/delete/'.$this->createRandPlayer());
        $this->assertResponseIsSuccessful();
    }



    public function testResponseSuccessfulShowPlayer(): void{
        $client= static ::createClient();
        $crawler = $client->request('GET', '//futbol.localhost/player/show/'.$this->createRandPlayer());
        $this->assertResponseIsSuccessful();
    }



    public function testResponseSuccessfulUpdatePlayer(): void{
         $client= static ::createClient();
        $crawler = $client->request('PUT', '//futbol.localhost/player/update/'.$this->createRandPlayer(), $this->createPlayerData());
        $this->assertResponseIsSuccessful();

    }



    public function testResponseSuccessfulClubIndexPlayer():void{
         $client= static ::createClient();
        $crawler = $client->request('GET','//futbol.localhost/club/'.$this->CreateRandClub().'/index_player');
        $this->assertResponseIsSuccessful();
    }



     public function testResponseSuccessfulIndexCoach(): void{
         $client= static ::createClient();
         $crawler = $client->request('GET', '//futbol.localhost/coach');
         $this->assertResponseIsSuccessful();
     }
     public function testResponseIsJsonCoach(): void{
         $client = static::createClient();
         $crawler = $client->request('GET', '//futbol.localhost/coach');
         $this->assertResponseFormatSame("json");
     }
     public function testResponseHasCoach(): void{
         $client = static::createClient();
         $crawler = $client->request('GET', '//futbol.localhost/coach');
         $response = $client->getResponse();
         $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
         $this->assertJson($response->getContent());
         $responseData = json_decode($response->getContent(), true);
     }
     public function testResponseExceptionCoach(): void{
         $client = static::createClient();
         $crawler = $client->request('GET', '//futbol.localhost/coach');
         $response=$client->getResponse();
         $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
         $this->assertJson($response->getContent());
         $client->catchExceptions(false);
     }



        private function createCoachData(): array {
            return ["dni"=> "123453".rand(10,99)."K",
            "name"=> "Ruben",
            "last_name"=>"Gonzalez",
            "team"=> "Ujopraestj",
            "salary"=> 1022,
            "email"=>"marta.perez_".rand(10,50)."@xilon.es",
            "phone"=> "123456".rand(100,999)
            ];
        }

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



    private function CreateRandCoach(): int
    {
        $client= self::$client;
        $crawler = $client->request('GET', '//futbol.localhost/coach');
        $response= $client->getResponse();
        $data = json_decode($response->getContent(), true);
        $ids= [];
        foreach($data["Coachs"]as $coach){
            $ids[]=$coach["id"];
        }
        return $ids[array_rand($ids)];
    }



    public function testResponseSuccessfulDeleteCoach():void{
        $client= static::createClient();
        $crawler = $client->request('DELETE', '//futbol.localhost/coach/delete/'.$this->CreateRandCoach());
        $this->assertResponseIsSuccessful();

    }



        public function  testResponseSuccessfulShowCoach(): void {
            $client= static::createClient();
        $crawler = $client->request('GET', '//futbol.localhost/coach/show/'.$this->CreateRandCoach());
        $this->assertResponseIsSuccessful();
        }



    public function testResponseSuccesfulUpdateCoach(): void {
        $client= static::createClient();
        $crawler = $client->request('PUT', '//futbol.localhost/coach/update/'.$this->CreateRandCoach(), $this->createCoachData());
        $this->assertResponseIsSuccessful();
    }



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



    private function createClubData (): array {
        return ["name"=> "Fgdhg".rand(0,99),
            "budget"=> 2345,
            "email"=> "marta.perez_".rand(10,50)."@xilon.es",
            "phone"=> "123456".rand(100,999)
        ];
    }



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



    private function CreateRandClub(): int{
        $client = self::$client;
        $crawler = $client->request('GET', '//futbol.localhost/club');
        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);
        $ids = [];
        foreach($data["Clubs"] as $club){
            $ids[]=$club["id"];
        }
        return $ids[array_rand($ids)];
    }



    public function testResponseSuccessfulDeleteClub():void{
        $client = static::createClient();
        $crawler = $client->request('DELETE', '//futbol.localhost/club/delete/'.$this->CreateRandClub());
        $this->assertResponseIsSuccessful();
    }



    public function testResponseSuccessfulShowClub(): void {
        $client = static::createClient();
        $crawler = $client->request('GET', '//futbol.localhost/club/show/'.$this->CreateRandClub());
        $this->assertResponseIsSuccessful();
    }



    public function testResponseSuccessfulUpdateClub(): void {
        $client = static::createClient();
        $crawler = $client->request('PUT', '//futbol.localhost/club/update/'.$this->CreateRandClub(), $this->createClubData());
        $this->assertResponseIsSuccessful();
    }



    public function testResponseSuccessfulClubCreatePlayer(): void {
        $client = static::createClient();
        $crawler = $client->request('POST', '//futbol.localhost/club/'.$this->CreateRandClub().'/create_player/', $this->createPlayerData());
        $this->assertResponseIsSuccessful();
    }



    public function testResponseSuccessfulClubDeletePlayer(): void {
        $client = static::createClient();
       $crawler= $client->request('DELETE', '//futbol.localhost/club/'.$this->CreateRandClub().'/delete_player/'.$this->createRandPlayer());
       $this->assertResponseIsSuccessful();
    }



    public function testResponseSuccessfulClubCreateCoach(): void {
        $client = static::createClient();
        $crawler= $client->request('POST', '//futbol.localhost/club/'.$this->CreateRandClub().'/create_coach', $this->createCoachData());
        $this->assertResponseIsSuccessful();
    }



    public function testResponseSuccessfulClubDeleteCoach():void{
        $client = static::createClient();
        $crawler = $client->request('DELETE', '//futbol.localhost/club/'.$this->CreateRandClub().'/delete_coach/'.$this->CreateRandCoach());
        $this->assertResponseIsSuccessful();
    }



}

