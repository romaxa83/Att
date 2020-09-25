<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CarController extends ApiController
{
    public function index(Request $request)
    {
        try {

            return $this->errorJsonMessage('ee');
        } catch (\Exception $error){
            return $this->errorJsonMessage($error->getMessage());
        }
    }
}
