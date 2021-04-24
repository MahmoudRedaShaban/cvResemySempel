<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use PHPUnit\Util\Json;

class UserDetailsTest extends TestCase
{
    public $authuser = "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIyIiwianRpIjoiNWY0ZDllOGNhNzI5MjM1OGZhZmFjMWU0OTI2MDY5NDhkYjkzODIwNDEyNjAxM2M5ODgzZmM4MDQ1NmQ1YmIyOWJhMjI1ZWMxYmMwODg0MWQiLCJpYXQiOjE2MTkyMTc3MzMuNzUxNDksIm5iZiI6MTYxOTIxNzczMy43NTE0OTgsImV4cCI6MTY1MDc1MzczMi45MTk2OTksInN1YiI6IjEiLCJzY29wZXMiOltdfQ.iK5nv1fFdH9iJnMjtR0nslLAm8XhrqeCGMjJU2gIEd7_AgUePTv3cGUjdYmEzZJdA5NLAHX07ovEazTVTt7JONVo2u9WHHkisFiMk4XUmruYnKh-yM0l2ybMrq5JLRwpxOOTritQMARUI83CrbHobJBsQvFXikZrM_djNfaPEWNfi6OFrWFZvH_yk39Osw-SPucY84MC3YGZcjRwerC6zpntkACFE69YbvQSuVwCegAlvY0cFJ3NsDGnsfiqsm-ZiyEiWwltRVyBDSeC9_-wIqn6fGc7jiUzGaBCXoHztQrHDQUWzyWQ7YuM6JK08FBsF1L1yxXvAtX7JP7bCLiHlQjja0W_eoBwBolDAMjxD4q7xteDzw_ILkUZBgtUC3KltwdZpW8Qqme_gsGLBUdsG0bs5YqJpTogOGs8hmmV0AOlyHGnbA6q97Za0-xwjjM1npUUuZroiUjErzxMQ_D9XxWULCDdgNoVhn9_0LeEpqvFZekP-4ctLON-5BtWB8WUGMSjCq2NuQ__wZKIKkTRzr9DHWxyGLbJJjwnJb3fYZxq273FCjHuAhTvpyE40iOfxVNfB7bwdbCOKSsWynOR1_9_HwMv-67DdebrP1qIhP1w4YkQFGBatdwXA5yTM57ottBa82nnicfeyf_nqbFz7vuSPPJkFFNnpUcpcoNTmJA";

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
    /**
     * Test For Get Singl  DitelsUSer
     *
     */
    public function testGetSinglByID()
    {
        $this->get('/api/userdetails/14', [
            "Content-Type" => "application/json",
            "Authorization" => $this->authuser
        ]);
        $this->response->assertOk();
    }


    /**
     * Test For Get All  DitelsUSer
     *
     */
    public function testapi_for_get_all()
    {
        $req = $this->get('/api/userdetails', [
            "Content-Type" => "application/json",
            "Authorization" => $this->authuser
        ]);

        $this->assertResponseStatus(201);
    }

    public function test_update_by_id()
    {
        $this->put('/api/userdetails/14', [
            "fullname" => "ali",
            "email" => "yamn@hwwwh",
            "phone" => "014543333",
            "address" => "Gada",
            "summary" => "programm..."
        ], [
            "Content-Type" => "application/json",
            "Authorization" => $this->authuser
        ]);
        // $this->assertResponseStatus(201);
        $this->assertJson($this->response->getContent());
    }
    /**
     * Test For Delete Singl By Id From   DitelsUSer
     *
     */
    public function testDeletedDetaildsUser()
    {
        $this->delete('/api/userdetails/14',[],[
            "Content-Type" => "application/json",
            "Authorization" => $this->authuser
        ]);
        $this->assertResponseStatus(200);
    }
}
