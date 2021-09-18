<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\ApiBaseController as ApiBaseController;
use Illuminate\Http\Request;
use App\Models\country;
use App\Http\Resources\Country as CountryResource;
class CountryController extends ApiBaseController
{
    //showing all countries
    public function index()
    {
        $countries = country::all();
        if($countries){
        return $this->sendResponse(CountryResource::collection($countries), 'countries retrieved successfully.');
        }
        return $this->sendError('countries are not found.');

    }
}
