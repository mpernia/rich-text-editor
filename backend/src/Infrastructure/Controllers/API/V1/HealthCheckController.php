<?php

namespace Src\Infrastructure\Controllers\API\V1;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use OpenApi\Annotations as OA;
use Src\Infrastructure\Controllers\Controller;

/**
 * @OA\Tag(
 *     name="Health Check",
 *     description="API health check endpoints"
 * )
 */
class HealthCheckController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/health",
     *     summary="Get API health status",
     *     description="Check the health status of the API and its services",
     *     tags={"Health Check"},
     *     @OA\Response(
     *         response=200,
     *         description="Health check information",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", enum={"ok", "error"}, example="ok"),
     *             @OA\Property(property="timestamp", type="string", format="date-time"),
     *             @OA\Property(
     *                 property="services",
     *                 type="object",
     *                 @OA\Property(property="database", type="boolean"),
     *                 @OA\Property(property="app", type="boolean")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error message description"),
     *             @OA\Property(property="code", type="integer", example=500)
     *         )
     *     )
     * )
     */
    public function __invoke(): JsonResponse
    {
        $status = 'ok';
        $services = [
            'database' => true,
            'app' => true
        ];

        try {
            DB::connection()->getPdo();
        } catch (Exception $e) {
            $status = 'error';
            $services['database'] = false;
        }

        return response()->json([
            'status' => $status,
            'timestamp' => now(),
            'services' => $services
        ]);
    }
}
