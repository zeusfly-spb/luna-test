<?php

namespace App\Http\Controllers;

use App\Http\Resources\BuildingResource;
use App\Http\Resources\OrgResource;
use App\Models\Building;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BuildingController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(BuildingResource::collection(Building::select('id', 'name', 'address')->get()));
    }

    public function orgs(string $id): JsonResponse
    {
        return response()->json(OrgResource::collection(Building::find($id)->orgs));
    }

    public function nearbyBuildings(Request $request): JsonResponse
    {
        $lat = $request->input('lat');
        $lng = $request->input('lng');
        $radius = $request->input('radius', 1000);

        $buildings = DB::table('buildings')
            ->select('id', 'name', 'address')
            ->whereRaw("ST_Distance_Sphere(location, ST_GeomFromText(?)) <= ?", [
                "POINT($lng $lat)",
                $radius
            ])
            ->get();
        return response()->json($buildings->toArray());
    }

    public function nearbyOrgs(Request $request): JsonResponse
    {
        $lat = $request->input('lat');
        $lng = $request->input('lng');
        $radius = $request->input('radius', 1000);

        $buildingIds = DB::table('buildings')
            ->whereRaw("ST_Distance_Sphere(location, ST_GeomFromText(?)) <= ?", [
                "POINT($lng $lat)",
                $radius
            ])
            ->pluck('id');

        $orgs = DB::table('orgs')
            ->whereIn('building_id', $buildingIds)
            ->get();

        return response()->json($orgs->toArray());
    }
}
