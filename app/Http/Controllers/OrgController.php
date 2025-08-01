<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrgResource;
use App\Models\Org;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrgController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(OrgResource::collection(Org::all()));
    }
}
