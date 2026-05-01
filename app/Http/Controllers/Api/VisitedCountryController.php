<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VisitedCountry;
use Illuminate\Http\Request;

class VisitedCountryController extends Controller
{
    public function index()
    {
        return VisitedCountry::query()
            ->get();
    }
}
