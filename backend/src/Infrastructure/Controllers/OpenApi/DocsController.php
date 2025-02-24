<?php

namespace Src\Infrastructure\Controllers\OpenApi;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use L5Swagger\Http\Controllers\SwaggerController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DocsController extends SwaggerController
{
    public function swagger(Request $request): View
    {
        $documentation = config('l5-swagger.default');
        $urlToDocs = route('l5-swagger.'.$documentation.'.docs', ['format' => 'json']);

        $useAbsolutePath = config('l5-swagger.documentations.'.$documentation.'.paths.use_absolute_path');
        $assetPublicPath = ($useAbsolutePath) ? asset('vendor/swagger-api/swagger-ui/dist/') : '/vendor/swagger-api/swagger-ui/dist/';
        $assetPath = 'vendor/swagger-api/swagger-ui/dist/';

        return view('views::swagger', [
            'documentation' => $documentation,
            'secure' => false,
            'urlToDocs' => $urlToDocs,
            'useAbsolutePath' => $useAbsolutePath,
            'assetPublicPath' => $assetPublicPath,
            'assetPath' => $assetPath,
            'darkMode' => config('l5-swagger.defaults.ui.display.dark_mode', false),
            'operationsSorter' => config('l5-swagger.defaults.ui.display.operations_sorter', 'alpha'),
            'tagsSorter' => config('l5-swagger.defaults.ui.display.tags_sorter', 'alpha'),
            'docExpansion' => config('l5-swagger.defaults.ui.display.doc_expansion', 'list'),
            'filter' => config('l5-swagger.defaults.ui.display.filter', true),
            'persistAuthorization' => config('l5-swagger.defaults.ui.display.persist_authorization', false)
        ]);
    }

    public function docs(Request $request): JsonResponse|BinaryFileResponse
    {
        $documentation = config('l5-swagger.default');
        $filePath = storage_path('api-docs/' . config('l5-swagger.documentations.default.paths.docs_json'));

        if (!File::exists($filePath)) {
            $this->generate($documentation);
        }

        if (!File::exists($filePath)) {
            return response()->json(['error' => 'Documentation not found'], 404);
        }

        return response()->file($filePath, [
            'Content-Type' => 'application/json'
        ]);
    }

    public function redoc(): View
    {
        $documentation = config('l5-swagger.default');
        $urlToDocs = route('l5-swagger.'.$documentation.'.docs', ['format' => 'json']);

        return view('views::redoc', [
            'documentation' => 'default',
            'secure' => false,
            'urlToDocs' => $urlToDocs
        ]);
    }

    public function asset(Request $request)
    {

    }
}
