<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    //

    protected function validIsEmpty($request, $keys)
    {
        $result = array();
        foreach ($keys as $key) {
            if (empty($request->$key) || !isset($request->$key)) {
                array_push($result, $key);
            }
        }
        return $result;
    }

    protected function errorFeildes($errors=null)
    {
        $resultErorrs = array();
        foreach ($errors as  $error) {
            array_push($resultErorrs, [$error => "required is ".$error]);
        }
        return $resultErorrs;
    }


}
