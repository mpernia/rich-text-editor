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
 *     @OA\Property(property="title", type="string", example="Título del Post"),
 *     @OA\Property(property="content", type="string", example="Contenido del post"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */

/**
 * @OA\Schema(
 *     schema="CreatePostRequest",
 *     required={"title", "content"},
 *     @OA\Property(property="title", type="string", example="Nuevo Título del Post"),
 *     @OA\Property(property="content", type="string", example="Nuevo Contenido del post")
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdatePostRequest",
 *     required={"title", "content"},
 *     @OA\Property(property="title", type="string", example="Título Actualizado"),
 *     @OA\Property(property="content", type="string", example="Contenido Actualizado")
 * )
 */
