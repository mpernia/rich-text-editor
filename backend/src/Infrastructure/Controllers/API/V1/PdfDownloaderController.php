<?php

namespace Src\Infrastructure\Controllers\API\V1;

use Illuminate\Http\Response;
use Src\Application\Services\PdfService;
use Src\Infrastructure\Controllers\Controller;

/**
 * @OA\Tag(
 *     name="Posts",
 *     description="API endpoints for managing posts"
 * )
 */
class PdfDownloaderController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/posts/{id}/pdf",
     *     summary="Download post as PDF",
     *     description="Download a specific post in PDF format",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Post ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="PDF file download",
     *         @OA\Header(
     *             header="Content-Type",
     *             description="PDF content type",
     *             @OA\Schema(type="string", example="application/pdf")
     *         ),
     *         @OA\Header(
     *             header="Content-Disposition",
     *             description="File download disposition",
     *             @OA\Schema(type="string", example="attachment; filename=post-1.pdf")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Post not found"),
     *             @OA\Property(property="code", type="integer", example=404)
     *         )
     *     )
     * )
     */
    public function __invoke(int $id): Response
    {
        $pdfContent = PdfService::create($id);
        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => sprintf('attachment; filename="post-%s.pdf"', $id)
        ]);
    }
}
