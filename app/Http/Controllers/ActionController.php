<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActionResource;
use App\Http\Resources\OrgResource;
use App\Models\Action;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Деятельность",
 * )
 */

class ActionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/actions",
     *     summary="Получить список сфер деятельности",
     *     tags={"Деятельность"},
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ"
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json(ActionResource::collection(Action::get()));
    }

    /**
     * @OA\Get(
     *     path="/api/actions/orgs/{id}",
     *     summary="Получить организации по ID деятельности",
     *     tags={"Деятельность"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID деятельности",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Информация об организациях"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Организации деятельности не найдены"
     *     )
     * )
     */
    public function orgs(string $id): JsonResponse
    {
        $action = Action::with('children')->find($id);
        $orgs = $action->descendantOrgs();
        return response()->json(OrgResource::collection($orgs));
    }
}
