<?php

/**
 * @OA\Info(
 *   title="TTCMS API",
 *   description="Endpoints for the TTCMS API",
 *   version="1.0",
 *   @OA\Contact(
 *     email="basar.carovac@stu.ibu.edu.ba",
 *     name="Basar Carovac"
 *   )
 * ),
 * @OA\OpenApi(
 *   @OA\Server(
 *       url=BASE_URL,
 *   )
 * ),
 * @OA\SecurityScheme(
 *     securityScheme="JWTAuth",
 *     type="apiKey",
 *     in="header",
 *     name="Authorization"
 * )
 */