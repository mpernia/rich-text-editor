<?php

namespace Src\Infrastructure\Controllers\API\V1;

use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;
use Src\Application\Actions\Status\StatusFinder;
use Src\Infrastructure\Controllers\Controller;
use Src\Infrastructure\Responses\StatusResource;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Tag(
 *     name="Statuses",
 *     description="API endpoints for managing statuses"
 * )
 */
class StatusController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/statuses",
     *     summary="List all statuses",
     *     description="Get a list of all available statuses",
     *     tags={"Statuses"},
     *     @OA\Response(
     *         response=200,
     *         description="List of statuses",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Active")
     *             )
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json(
            data: StatusResource::collection(StatusFinder::all()),
            status: Response::HTTP_OK
        );
    }

    /**
     * @OA\Get(
     *     path="/api/v1/statuses/{id}",
     *     summary="Get a specific status",
     *     description="Get detailed information about a specific status",
     *     tags={"Statuses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Status ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Status details",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Active")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Status not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Status not found"),
     *             @OA\Property(property="code", type="integer", example=404)
     *         )
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        return response()->json(
            data: new StatusResource(StatusFinder::find($id)),
            status: Response::HTTP_OK
        );
    }
}
