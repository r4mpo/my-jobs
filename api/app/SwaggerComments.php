<?php

namespace App;

/**
 * @OA\Info(
 *      version="0.0.1",
 *      title="My Jobs",
 *      description="Laravel API documentation for the 'My Jobs' application.",
 *      @OA\Contact(
 *          email="erick1souza1ago04@gmail.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Demo API Server"
 * )
 * 
 * @OA\SecurityScheme(
 *     type="http",
 *     securityScheme="bearerAuth",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 *
*/

class SwaggerComments
{
    public function documentation()
    {
        // 
    }
}