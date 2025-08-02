<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrgResource;
use App\Models\Org;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;


/**
 * @OA\Info(
 *     title="Luna-Test API",
 *     version="1.0.0"
 * )
 * @OA\Tag(
 *     name="Организации",
 * )
 * @OA\SecurityScheme(
 *      type="apiKey",
 *      in="header",
 *      securityScheme="ApiKeyAuth",
 *      name="x-api-key"
 *  )
 */

class OrgController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/orgs",
     *     summary="Получить список организаций",
     *     tags={"Организации"},
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ"
     *     )
     * )
     */

    public function index(): JsonResponse
    {
        return response()->json(OrgResource::collection(Org::all()));
    }

    /**
     * @OA\Get(
     *     path="/api/orgs/{id}",
     *     summary="Получить организацию по ID",
     *     tags={"Организации"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID организации",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Информация об организации"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Организация не найдена"
     *     )
     * )
     */
    public function show(string $id): JsonResponse
    {
        return response()->json(new OrgResource(Org::with('actions')->find($id)));
    }

    /**
     * @OA\Post(
     *     path="/api/orgs/by_name",
     *     summary="Найти организации по имени",
     *     tags={"Организации"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Имя или часть имени организации",
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 example="Рога и Копыта"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Список найденных организаций"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Неверный формат запроса"
     *     )
     * )
     */
    public function by_name(Request $request): JsonResponse
    {
        $name = $request->get('name');
        return response()->json(OrgResource::collection($orgs = Org::where('name', 'like', '%' . $name . '%')->get()));
    }
}
