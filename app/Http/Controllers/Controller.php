<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(title="hoydigo API", version="1.0.0")
 * @OA\SecurityScheme(
 *     type="http",
 *     name="Bearer Token",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="bearer",
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
