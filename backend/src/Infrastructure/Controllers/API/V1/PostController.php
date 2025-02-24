<?php

namespace Src\Infrastructure\Controllers\API\V1;

use Illuminate\Http\{JsonResponse, Request};
use OpenApi\Annotations as OA;
use Src\Application\Actions\Post\{PostCreator, PostDestroyer, PostFinder, PostUpdater};
use Src\Application\DataTransferObjects\PostDto;
use Src\Application\Services\PostService;
use Src\Infrastructure\Controllers\Controller;
use Src\Infrastructure\Requests\{CreatePostRequest, UpdatePostRequest};
use Src\Infrastructure\Responses\PostResource;
use Symfony\Component\HttpFoundation\Response;

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
 *
 * @OA\Schema(
 *     schema="CreatePostRequest",
 *     required={"title", "content"},
 *     @OA\Property(property="title", type="string", example="Nuevo Título del Post"),
 *     @OA\Property(property="content", type="string", example="Nuevo Contenido del post")
 * )
 *
 * @OA\Schema(
 *     schema="UpdatePostRequest",
 *     required={"title", "content"},
 *     @OA\Property(property="title", type="string", example="Título Actualizado"),
 *     @OA\Property(property="content", type="string", example="Contenido Actualizado")
 * )
 *
/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="API Editor Laravel",
 *     description="API REST implementada con Laravel siguiendo principios de Clean Architecture",
 *     @OA\Contact(
 *         email="contact@apieditor.com",
 *         name="API Editor Team"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 *
 * @OA\Server(
 *     url="/",
 *     description="API Editor Server"
 * )
 *
 * @OA\SecurityScheme(
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="bearerAuth"
 * )
 *
 * @OA\Tag(
 *     name="Posts",
 *     description="API Endpoints para gestión de posts"
 * )
 */
class PostController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/posts",
     *     summary="Obtener lista de posts",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Término de búsqueda",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de posts obtenida exitosamente",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Post")
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $search = $request->has('search') ? $request->get('search') : null;
        $posts = PostFinder::all($search);
        return response()->json(
            data: PostResource::collection($posts),
            status: Response::HTTP_OK
        );
    }

    /**
     * @OA\Post(
     *     path="/api/v1/posts",
     *     summary="Crear un nuevo post",
     *     tags={"Posts"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreatePostRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Post creado exitosamente",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación"
     *     )
     * )
     */
    public function store(CreatePostRequest $request): JsonResponse
    {
        $inMarkdown = $request->has('markdown') && asBool($request->get('markdown'));
        $post = PostService::create(
            postDto: new PostDto($request->all()),
            inMarkdown: $inMarkdown
        );
        return response()->json(
            data: new PostResource($post),
            status: Response::HTTP_CREATED
        );
    }

    /**
     * @OA\Get(
     *     path="/api/v1/posts/{id}",
     *     summary="Obtener un post específico",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del post",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post encontrado exitosamente",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post no encontrado"
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $post = PostFinder::find($id);
        return response()->json(
            data: new PostResource($post),
            status: Response::HTTP_OK
        );
    }

    /**
     * @OA\Put(
     *     path="/api/v1/posts/{id}",
     *     summary="Actualizar un post existente",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del post",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdatePostRequest")
     *     ),
     *     @OA\Response(
     *         response=202,
     *         description="Post actualizado exitosamente",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post no encontrado"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación"
     *     )
     * )
     */
    public function update(UpdatePostRequest $request, int $id): JsonResponse
    {
        $inMarkdown = $request->has('markdown') && asBool($request->get('markdown'));
        $post = PostService::update(
            id: $id,
            postDto: new PostDto($request->all()),
            inMarkdown: $inMarkdown
        );
        return response()->json(
            data: new PostResource($post),
            status:  Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/posts/{id}",
     *     summary="Eliminar un post",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del post",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Post eliminado exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post no encontrado"
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        PostDestroyer::destroy($id);
        return response()->json(
            data: [],
            status: Response::HTTP_NO_CONTENT
        );
    }
}
