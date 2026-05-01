<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WhiskyTastingResource;
use App\Models\WhiskyTasting;
use Illuminate\Http\Request;

class WhiskyController extends Controller
{
    public function index()
    {
         $whiskies = WhiskyTasting::query()
             ->with([
                 'country',
                 'region',
                 'distillery',
                 'type',
                 'caskType',
                 'finish',
                 'color',
                 'flavours',
             ])
             ->orderByDesc('date_of_tasting')
             ->get();

         return WhiskyTastingResource::collection($whiskies);
    }
}
