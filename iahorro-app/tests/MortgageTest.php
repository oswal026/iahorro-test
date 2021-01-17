<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class MortgageTest extends TestCase
{
    public function testStore()
    {
        $this->seeInDatabase('time_zones', ['id' => 1]);

        //Validate request
        $response = $this->call('POST', 'api/mortgage/store', [
            "first_name" =>"Jose",
            "last_name" => "Perez",
            "email" => "jpm@gmail.com",
            "phone" => "622323524",
            "net_income" => 2100,
            "amount" => 50000,
            "time_zones_id" => 1
        ]);

        $this->assertEquals(201, $response->status());

        $this->seeInDatabase('experts', ['id' => 1]);
    }

    public function testOkJsonResponse()
    {
        $this->json('GET', 'api/mortgage/base-data', [])
            ->seeStatusCode(201)
            ->seeJsonStructure([
                'data' => [
                    'Experts' =>[],
                    'Time Zones' => []
                ]
        ]);

        $this->json('GET', 'api/mortgage/expert/1', [])
            ->seeStatusCode(201)
            ->seeJsonStructure([
                'Expert' => [],
                'Mortgage Requests' => []
            ]);

        $this->json('POST', 'api/mortgage/store', [
            "first_name" =>"Jose",
            "last_name" => "Perez",
            "email" => "jpm@gmail.com",
            "phone" => "622323524",
            "net_income" => 2100,
            "amount" => 50000,
            "time_zones_id" => 1
        ])->seeJsonEquals([
            'created' => true,
            'msg' => 'The mortgage request was created successfully.'
        ]);
    }

    public function testFailedJsonResponse()
    {
        $this->json('GET', 'api/mortgage/base-data', [])
            ->seeJson([]);

        $this->json('GET', 'api/mortgage/expert/222', [])
            ->seeJson([
                'error' => true,
                'msg' => 'Whoops, looks like something went wrong. Error: Expert not found.'
            ]);

        $this->json('POST', 'api/mortgage/store', [	])
            ->seeJson([
                'created' => false,
                'msg' => 'Whoops, looks like something went wrong. Error: The given data was invalid.'
            ]);
    }

}
