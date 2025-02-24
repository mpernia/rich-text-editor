<?php

namespace Src\Infrastructure\OpenApi;

/**
 * @OA\Schema(
 *     schema="Error",
 *     @OA\Property(property="message", type="string", example="Error message description"),
 *     @OA\Property(property="code", type="integer", example=404)
 * )
 */

/**
 * @OA\Schema(
 *     schema="HealthCheck",
 *     @OA\Property(property="status", type="string", enum={"ok", "error"}, example="ok"),
 *     @OA\Property(property="timestamp", type="string", format="date-time"),
 *     @OA\Property(
 *         property="services",
 *         type="object",
 *         @OA\Property(property="database", type="boolean"),
 *         @OA\Property(property="app", type="boolean")
 *     )
 * )
 */

/**
 * @OA\Schema(
 *     schema="User",
 *     required={"id", "name", "email"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */

/**
 * @OA\Schema(
 *     schema="Status",
 *     required={"id", "name"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Active")
 * )
 */

/**
 * @OA\Schema(
 *     schema="Post",
 *     required={"id", "title", "content"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Sample Post Title"),
 *     @OA\Property(property="content", type="string", example="This is the content of the post"),
 *     @OA\Property(property="status_id", type="integer", example=1),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */

/**
 * @OA\Response(
 *     response="NotFound",
 *     description="Resource not found",
 *     @OA\JsonContent(ref="#/components/schemas/Error")
 * )
 */

/**
 * @OA\Response(
 *     response="Unauthorized",
 *     description="Unauthorized access",
 *     @OA\JsonContent(ref="#/components/schemas/Error")
 * )
 */

/**
 * @OA\Response(
 *     response="ValidationError",
 *     description="Validation error",
 *     @OA\JsonContent(
 *         @OA\Property(property="message", type="string", example="The given data was invalid."),
 *         @OA\Property(
 *             property="errors",
 *             type="object",
 *             @OA\AdditionalProperties(
 *                 type="array",
 *                 @OA\Items(type="string")
 *             )
 *         )
 *     )
 * )
 */

/**
 * @OA\Schema(
 *     schema="HealthCheck",
 *     @OA\Property(property="status", type="string", enum={"ok", "error"}, example="ok"),
 *     @OA\Property(property="timestamp", type="string", format="date-time"),
 *     @OA\Property(
 *         property="services",
 *         type="object",
 *         @OA\Property(property="database", type="boolean"),
 *         @OA\Property(property="app", type="boolean")
 *     )
 * )
 */

/**
 * @OA\Schema(
 *     schema="Status",
 *     required={"id", "name"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Active")
 * )
 */

/**
 * @OA\Schema(
 *     schema="User",
 *     required={"id", "name", "email"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
