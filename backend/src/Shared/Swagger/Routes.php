<?php

namespace Src\Shared\Swagger;

/**
 * @OA\PathItem(
 *     path="/health",
 *     @OA\Get(
 *         tags={"Health"},
 *         summary="Check API health status",
 *         @OA\Response(
 *             response=200,
 *             description="Health check response",
 *             @OA\JsonContent(
 *                 @OA\Property(
 *                     property="status",
 *                     type="string",
 *                     enum={"ok", "error"}
 *                 ),
 *                 @OA\Property(
 *                     property="timestamp",
 *                     type="string",
 *                     format="date-time"
 *                 ),
 *                 @OA\Property(
 *                     property="services",
 *                     type="object",
 *                     @OA\Property(property="database", type="boolean"),
 *                     @OA\Property(property="app", type="boolean")
 *                 )
 *             )
 *         )
 *     )
 * )
 *
 * @OA\PathItem(
 *     path="/posts",
 *     @OA\Get(
 *         tags={"Posts"},
 *         summary="Get list of posts",
 *         @OA\Response(
 *             response=200,
 *             description="Successful operation",
 *             @OA\JsonContent(
 *                 type="object",
 *                 @OA\Property(
 *                     property="data",
 *                     type="array",
 *                     @OA\Items(ref="#/components/schemas/Post")
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Post(
 *         tags={"Posts"},
 *         summary="Create a new post",
 *         description="Create a new blog post with the provided data.",
 *         @OA\RequestBody(
 *             required=true,
 *             description="Post data",
 *             @OA\JsonContent(ref="#/components/schemas/CreatePostRequest")
 *         ),
 *         @OA\Response(
 *             response=201,
 *             description="Post created successfully",
 *             @OA\JsonContent(
 *                 type="object",
 *                 @OA\Property(
 *                     property="data",
 *                     ref="#/components/schemas/Post"
 *                 )
 *             )
 *         ),
 *         @OA\Response(
 *             response=400,
 *             description="Bad request - check your input format",
 *             @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *         ),
 *         @OA\Response(
 *             response=401,
 *             description="Unauthorized - authentication required",
 *             @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *         ),
 *         @OA\Response(
 *             response=422,
 *             description="Validation error - check field requirements",
 *             @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *         )
 *     )
 * )
 *
 * @OA\PathItem(
 *     path="/posts/{id}",
 *     @OA\Get(
 *         tags={"Posts"},
 *         summary="Get a specific post",
 *         @OA\Parameter(
 *             name="id",
 *             in="path",
 *             required=true,
 *             description="Post ID",
 *             @OA\Schema(type="integer")
 *         ),
 *         @OA\Response(
 *             response=200,
 *             description="Successful operation",
 *             @OA\JsonContent(
 *                 type="object",
 *                 @OA\Property(
 *                     property="data",
 *                     ref="#/components/schemas/Post"
 *                 )
 *             )
 *         ),
 *         @OA\Response(
 *             response=404,
 *             description="Post not found",
 *             @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *         )
 *     ),
 *     @OA\Put(
 *         tags={"Posts"},
 *         summary="Update an existing post",
 *         description="Update a blog post with the provided data.",
 *         @OA\Parameter(
 *             name="id",
 *             in="path",
 *             required=true,
 *             description="Post ID",
 *             @OA\Schema(type="integer")
 *         ),
 *         @OA\RequestBody(
 *             required=true,
 *             description="Post data",
 *             @OA\JsonContent(ref="#/components/schemas/UpdatePostRequest")
 *         ),
 *         @OA\Response(
 *             response=202,
 *             description="Post updated successfully",
 *             @OA\JsonContent(
 *                 type="object",
 *                 @OA\Property(
 *                     property="data",
 *                     ref="#/components/schemas/Post"
 *                 )
 *             )
 *         ),
 *         @OA\Response(
 *             response=400,
 *             description="Bad request - check your input format",
 *             @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *         ),
 *         @OA\Response(
 *             response=401,
 *             description="Unauthorized - authentication required",
 *             @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *         ),
 *         @OA\Response(
 *             response=404,
 *             description="Post not found",
 *             @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *         ),
 *         @OA\Response(
 *             response=422,
 *             description="Validation error - check field requirements",
 *             @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *         )
 *     ),
 *     @OA\Delete(
 *         tags={"Posts"},
 *         summary="Delete a post",
 *         description="Delete a blog post permanently. This action cannot be undone.",
 *         @OA\Parameter(
 *             name="id",
 *             in="path",
 *             required=true,
 *             description="Post ID",
 *             @OA\Schema(type="integer")
 *         ),
 *         @OA\Response(
 *             response=204,
 *             description="Post deleted successfully"
 *         ),
 *         @OA\Response(
 *             response=401,
 *             description="Unauthorized - authentication required",
 *             @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *         ),
 *         @OA\Response(
 *             response=404,
 *             description="Post not found",
 *             @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *         )
 *     )
 * )
 */
class Routes {}
