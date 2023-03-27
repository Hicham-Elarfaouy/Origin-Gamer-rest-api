<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *    title="Gaming Api",
 *    version="1.0.0",
 *    description="Développer une REST API de Gestion des produits de gaming Origin Gamer  en utilisant Laravel",
 * )
 * @OA\SecurityScheme(
 *     type="http",
 *     scheme="bearer",
 *     name="Authorization",
 *     in="header",
 *     securityScheme="sanctum",
 *     description="Sanctum authentication. You must provide a bearer token obtained from /api/login endpoint."
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
