<?php
// app/swagger.php

/**
 * @OA\Info(
 *   title="Mi API",
 *   version="1.0",
 *   description="Descripción de mi API",
 * )
 * @OA\Server(
 *   url=L5_SWAGGER_CONST_HOST,
 *   description="API Server"
 * )
 * @OA\SecurityScheme(
 *   securityScheme="bearerAuth",
 *   in="header",
 *   name="Authorization",
 *   type="http",
 *   scheme="bearer",
 *   bearerFormat="JWT",
 * )
 */