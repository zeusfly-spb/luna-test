<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActionResource;
use App\Http\Resources\OrgResource;
use App\Models\Action;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(ActionResource::collection(Action::get()));
    }

    public function orgs(string $id): JsonResponse
    {
        return response()->json(Action::find($id)->orgs);
    }
}
