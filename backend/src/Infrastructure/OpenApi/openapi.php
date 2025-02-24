<?php

namespace Src\Infrastructure\OpenApi;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="API Editor Laravel",
 *     description="RESTful API built with Laravel following Clean Architecture principles. This API provides endpoints for managing posts, users, and system status.",
 *     @OA\Contact(
 *         email="contact@apieditor.com",
 *         name="API Editor Team"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 */

/**
 * @OA\Server(
 *     url="/",
 *     description="API Editor Server"
 * )
 */

/**
 * @OA\SecurityScheme(
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="bearerAuth"
 * )
 */

/**
 * HTTP Status Codes Used in the API:
 *
 * Success Codes:
 * @OA\Response(response=200, description="OK - The request has succeeded")
 * @OA\Response(response=201, description="Created - The request has been fulfilled and resulted in a new resource being created")
 * @OA\Response(response=202, description="Accepted - The request has been accepted for processing")
 * @OA\Response(response=204, description="No Content - The request has succeeded but returns no message body")
 *
 * Client Error Codes:
 * @OA\Response(response=400, description="Bad Request - The request could not be understood due to malformed syntax")
 * @OA\Response(response=401, description="Unauthorized - Authentication is required and has failed or has not been provided")
 * @OA\Response(response=403, description="Forbidden - The server understood the request but refuses to authorize it")
 * @OA\Response(response=404, description="Not Found - The requested resource could not be found")
 * @OA\Response(response=422, description="Unprocessable Entity - The request was well-formed but was unable to be followed due to semantic errors")
 * @OA\Response(response=429, description="Too Many Requests - The user has sent too many requests in a given amount of time")
 *
 * Server Error Codes:
 * @OA\Response(response=500, description="Internal Server Error - The server encountered an unexpected condition")
 * @OA\Response(response=503, description="Service Unavailable - The server is currently unable to handle the request")
 */
