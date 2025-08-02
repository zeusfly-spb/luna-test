<?php

namespace App\Http\Controllers;

use App\Http\Resources\BuildingResource;
use App\Http\Resources\OrgResource;
use App\Models\Building;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Tag(
 *     name="Здания",
 * )
 */

class BuildingController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/buildings",
     *     summary="Получить список зданий",
     *     tags={"Здания"},
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ"
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json(BuildingResource::collection(Building::select('id', 'name', 'address')->get()));
    }

    /**
     * @OA\Get(
     *     path="/api/buildings/orgs/{id}",
     *     summary="Получить организации по ID здания",
     *     tags={"Здания"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID здания",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Информация об организациях"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Организации здания не найдены"
     *     )
     * )
     */
    public function orgs(string $id): JsonResponse
    {
        return response()->json(OrgResource::collection(Building::find($id)->orgs));
    }

    /**
     * @OA\Post(
     *     path="/api/buildings/nearby",
     *     summary="Найти здания в заданном радиусе",
     *     tags={"Здания"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Координаты и радиус поиска",
     *         @OA\JsonContent(
     *             required={"lat", "lng"},
     *             @OA\Property(
     *                 property="lat",
     *                 type="number",
     *                 format="float",
     *                 example=55.7498,
     *                 description="Широта (latitude)"
     *             ),
     *             @OA\Property(
     *                 property="lng",
     *                 type="number",
     *                 format="float",
     *                 example=37.5377,
     *                 description="Долгота (longitude)"
     *             ),
     *             @OA\Property(
     *                 property="radius",
     *                 type="integer",
     *                 example=1000,
     *                 description="Радиус в метрах (по умолчанию 1000)"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Список зданий поблизости"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Некорректные координаты или формат запроса"
     *     )
     * )
     */

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


    /**
     * @OA\Post(
     *     path="/api/buildings/nearby/orgs",
     *     summary="Найти организации в зданиях в заданном радиусе",
     *     tags={"Здания"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Координаты и радиус поиска",
     *         @OA\JsonContent(
     *             required={"lat", "lng"},
     *             @OA\Property(
     *                 property="lat",
     *                 type="number",
     *                 format="float",
     *                 example=55.7498,
     *                 description="Широта (latitude)"
     *             ),
     *             @OA\Property(
     *                 property="lng",
     *                 type="number",
     *                 format="float",
     *                 example=37.5377,
     *                 description="Долгота (longitude)"
     *             ),
     *             @OA\Property(
     *                 property="radius",
     *                 type="integer",
     *                 example=1000,
     *                 description="Радиус в метрах (по умолчанию 1000)"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Список организаций в зданиях поблизости"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Некорректные координаты или формат запроса"
     *     )
     * )
     */
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
