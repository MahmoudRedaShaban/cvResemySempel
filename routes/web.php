<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    // return $router->app->version();
    return redirect()->route('register');
});


$router->group(['prefix'=> 'api'],function () use($router){

    /* Register */
    $router->post('/register',['as' => 'register', 'uses' =>"AuthController@register"]);
    /* TODO LOGIN */
    // $router->post('/login',"AuthController@login");

    $router->group(['middleware' => 'auth'],function ()  use($router){

        /* Logout */
        $router->post('/logout',"AuthController@logout");
        /* @final UserDetailsController */
        $router->get('/userdetails',"UserDetailsController@index");
        $router->post('/userdetails',"UserDetailsController@store");
        $router->get('/userdetails/{id}',"UserDetailsController@show");
        $router->put('/userdetails/{id}',"UserDetailsController@update");
        $router->delete('/userdetails/{id}',"UserDetailsController@destroy");
        /* @final JobsController */
        $router->get('/jobs',"JobsController@index");
        $router->post('/jobs',"JobsController@store");
        $router->get('/jobs/{id}',"JobsController@show");
        $router->put('/jobs/{id}',"JobsController@update");
        $router->delete('/jobs/{id}',"JobsController@destroy");
        /* @final EducationController */
        $router->get('/education',"EducationController@index");
        $router->post('/education',"EducationController@store");
        $router->get('/education/{id}',"EducationController@show");
        $router->put('/education/{id}',"EducationController@update");
        $router->delete('/education/{id}',"EducationController@destroy");
        /* @final ExperiencesController */
        $router->get('/experiences',"ExperiencesController@index");
        $router->post('/experiences',"ExperiencesController@store");
        $router->get('/experiences/{id}',"ExperiencesController@show");
        $router->put('/experiences/{id}',"ExperiencesController@update");
        $router->delete('/experiences/{id}',"ExperiencesController@destroy");
        /* @final SkillsController */
        $router->get('/skills',"SkillsController@index");
        $router->post('/skills',"SkillsController@store");
        $router->get('/skills/{id}',"SkillsController@show");
        $router->put('/skills/{id}',"SkillsController@update");
        $router->delete('/skills/{id}',"SkillsController@destroy");


    });



});
