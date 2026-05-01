<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WhiskyDistillery;
use Illuminate\Http\Request;

class DistilleryController extends Controller
{
    public function index()
    {
        return WhiskyDistillery::query()
            ->get();
    }
}
