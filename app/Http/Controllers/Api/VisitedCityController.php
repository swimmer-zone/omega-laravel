<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VisitedCity;
use Illuminate\Http\Request;

class VisitedCityController extends Controller
{
    public function index()
    {
        return VisitedCity::query()
            ->get();
    }
}
