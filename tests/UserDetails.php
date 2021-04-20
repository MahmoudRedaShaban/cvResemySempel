<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use PHPUnit\Util\Json;

class UserDetails extends TestCase
{
    public $authuser = "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIyIiwianRpIjoiNmY0YjgwYzk0NDNmNjM4MjI5ZDRhMDM1ODQ2NWRiOTM5MzAwNDM1ZThjNjJmM2ZiYzMxY2M5MjRiYTcwNzhmNzliYmNmYjMxZjVkYTIyODAiLCJpYXQiOjE2MTg4Nzg1NjIuMDA5OTk1LCJuYmYiOjE2MTg4Nzg1NjIuMDEwMDEyLCJleHAiOjE2NTA0MTQ1NjEuOTU0MDU0LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.ihiz8L3mlt2FHsjs4M8hKyjmhoWA8COUcpxvFQUqOl5gydDULtkXWlY24fX06Sw7U5mAwbWEfc69yjC3UIXs4gdQjkRa9Tk7rt2awM8H5lqVceXBkK15Ttu__KK2sY56EBAx4Nuw5uRvgYrJh676qebiMZFrDfuVOaPYkmS3-JCdKxGOhrjeUOxw6V9ws3gxTcPmhUrPUWddSGmcwLPZNGjGBAJxQtfEu1ua62kuaD72L89JMePcdL4W9Vj-_Qi4JdxJAaguNC1irpOdoZuO7C1rjGi1QAsXZd3Ss69gJovC9PiYIyTokPNJ2vKDBOmZb9ldOy6RdJ-Fdvn6V1z9oIAQRYBk-KNkptoi7Jgz-vh6_lMWeDGx4kQU9Yr2-TJPYmcNINRqMhU5GwiMzBNtmw1RO7JhrXaWOi_aipL6ikoA8SL3dzwo8SBy6-oXJ3vsT9aN3HqXdyc3QI6j_LhSGrDYmd9VNxN355ic2pz4zV5troZp55McVBdNDCkzWHxcxk9NZNh8rw1E8r8kN3EVFX8Emdi-Y73EIsrM0mrHnorM93tPwJ-C6PVQ_s4mn2UkEu825idoad266LJU8otWc6vNEqlooMJulwWiNaeoBDz6Rr-ShTrGsJPu69UxPDmtJ-MK4vO2XW0khSgHLsnwThpUkcmXAjT3hba2bic5Obk";
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetSinglByID()
    {
        $this->get('/api/userdetails/12', [
            "Content-Type" => "application/json",
            "Authorization" => $this->authuser
        ]);
        $this->response->assertOk();
    }



    public function testapi_for_get_all()
    {
        $req = $this->get('/api/userdetails', [
            "Content-Type" => "application/json",
            "Authorization" => $this->authuser
        ]);

        $this->assertResponseStatus(201);
    }

    /**
     * Test For Insert DitelsUSer
     *
     * @test
     */
    public function insert_new_user_details()
    {
        $this->post('/api/userdetails', [
            "fullname" => "mahoud",
            "email" => "mahmowwud@hwwwh",
            "phone" => "ttttww",
            "address" => "w",
            "summary" => "w"
        ], [
            "Content-Type" => "application/json",
            "Authorization" => $this->authuser
        ]);
        $this->assertJson($this->response->getContent());
    }

    public function test_update_by_id()
    {
        $this->put('/api/userdetails/12', [
            "fullname" => "ali",
            "email" => "yamn@hwwwh",
            "phone" => "012543333",
            "address" => "Gada",
            "summary" => "programm..."
        ], [
            "Content-Type" => "application/json",
            "Authorization" => $this->authuser
        ]);
        // $this->assertResponseStatus(201);
        $this->assertJson($this->response->getContent());
    }
    public function testDeletedDetaildsUser()
    {
        $this->delete('/api/userdetails/12',[],[
            "Content-Type" => "application/json",
            "Authorization" => $this->authuser
        ]);
        $this->assertResponseStatus(200);
    }
}
