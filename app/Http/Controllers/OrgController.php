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

    public function show(string $id): JsonResponse
    {
        return response()->json(new OrgResource(Org::with('actions')->find($id)));
    }

    public function by_name(Request $request): JsonResponse
    {
        $name = $request->get('name');
        return response()->json(OrgResource::collection($orgs = Org::where('name', 'like', '%' . $name . '%')->get()));
    }
}
