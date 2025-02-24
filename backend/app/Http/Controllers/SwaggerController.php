<?php

namespace App\Http\Controllers;

use L5Swagger\Http\Controllers\SwaggerController as L5SwaggerController;

class SwaggerController extends L5SwaggerController
{
    public function redoc()
    {
        $documentation = config('l5-swagger.default');
        return view('l5-swagger::redoc', [
            'documentation' => $documentation,
            'urlToDocs' => route('l5-swagger.'.$documentation.'.docs')
        ]);
    }
}
