<?php
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use PHPUnit\Util\Json;

class ExperiencesTest extends TestCase
{
    public $authuser = "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIyIiwianRpIjoiZWMzODFhOWRmY2YyMGZiZDZjNDQ0OGUyMzgxOTQ5ZWJiN2IxY2FmYTM3ODBkMTNkMDBhOWNkNTE4ZWFhOTFjYjk2MGY3N2IwNGM2NTM3ZWEiLCJpYXQiOjE2MTkyMjM5NjIuMDYyNDIxLCJuYmYiOjE2MTkyMjM5NjIuMDYyNDI3LCJleHAiOjE2NTA3NTk5NjIuMDI4NzYyLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.dYACEOFxUz5oYvD8kQfmJqR5NjuiXXm7JBQkYpvjxIJfPjXO3pigsJUaCXKcV_p8dDngYjLYEhDHNHEVi8DU3QkcIDlV_LjrDWxzs7lmHDbs2YCanuHOYoDZxzQd09WALK1yu3CGNkn6G5BQHfvRuCB_VCahYB2e5ZMfh1tnyJZcGkqNw2SsPuVkWTjQbqrzyfnhirUG9-hL0ekdsLLyGluTkJIs43SLSOisQkP24rtba5IyhRd4R7ziZoFFj3Nj8P2YgaKpWb0wLuD0kAqtEojWw9LMOx-9wE-0QWoO9YdEkQJgY7ukViccnwjBahFvaQlpNzyULw4ovvz0CCSsW3LXHhnDVe-GSpOucQhU755-YEF5eELKNEBRpwagw4rpLcprwJvkk7qtjJk_HbMv0iPDGiXvqSPQF8XxYReeiBwMmWvFwN-1kp3aAprHOGk-pX5-TwDQ8jbLJwRGnGgrdMXNdqyJ67YuQfNiWixNoR8gKS1CfusKT42WWzt0wWhDury80b742hCFFNxKpMlZwaL0a1-GQxvq8FPY-2J2VeZMZpwCWSe0Sd5rrvrwMOATfIo7iUPim5O6wBU_XMtLuKM3i8fLkAbkv1lX9QCwu47bqfJFtj3xq9h9iVCNweT0Q1xTDKI8y34534BdVKD-gKZWdedDbXvTBccpLBCg3OI";
    public $id_insert;
    /**
     * Test For Insert Experiences
     *
     * @test
     */
    public function insert_new_Experiences()
    {

        $this->post('/api/experiences', [
            'job_title' => "Programer",
            'employer' => "Developer",
            'city'=>"Egypt",
            "state" => "good",
            "start_date" => "2021-04-24T02:45:55.000000Z",
            "end_date"=> "2021-04-24T02:45:55.000000Z"
        ], [
            "Content-Type" => "application/json",
            "Authorization" => $this->authuser
        ]);
        $this->id_insert = $this->response->getContent();
        $this->assertJson($this->id_insert);
    }
    /**
     * Test For Get Singl  Experiences
     *
     */
    public function testGetSinglByID()
    {
        $this->get('/api/experiences/1', [
            "Content-Type" => "application/json",
            "Authorization" => $this->authuser
        ]);
        $this->response->assertOk();
    }


    /**
     * Test For Get All  Experiences
     *
     */
    public function testapi_for_get_all()
    {
        $req = $this->get('/api/experiences', [
            "Content-Type" => "application/json",
            "Authorization" => $this->authuser
        ]);

        $this->assertResponseStatus(200);
    }

    public function test_update_by_id()
    {
        $this->put('/api/experiences/1', [
            'job_title' => "Programer1",
            'employer' => "Developer1",
            'city'=>"Egypt1",
            "state" => "good1",
            "start_date" => "2011-04-24T02:45:55.000000Z",
            "end_date"=> "2011-04-24T02:45:55.000000Z"
        ], [
            "Content-Type" => "application/json",
            "Authorization" => $this->authuser
        ]);
        // $this->assertResponseStatus(201);
        $this->assertJson($this->response->getContent());
    }
    /**
     * Test For Delete Singl By Id From   Experiences
     *
     */
    public function testDeletedDetaildsUser()
    {
        $this->delete('/api/experiences/1',[],[
            "Content-Type" => "application/json",
            "Authorization" => $this->authuser
        ]);
        $this->assertResponseStatus(200);
    }
}
