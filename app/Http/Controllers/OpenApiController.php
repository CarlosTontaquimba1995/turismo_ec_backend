<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Turismo Ecuador API",
 *     description="API para el manejo de información turística de Ecuador",
 *     @OA\Contact(
 *         email="soporte@turismo-ec.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="API Server"
 * )
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 * @OA\Tag(
 *     name="Authentication",
 *     description="Authentication endpoints"
 * )
 * @OA\Tag(
 *     name="Test",
 *     description="Test endpoints"
 * )
 */
class OpenApiController
{
    // This class is only used for OpenAPI documentation
}
