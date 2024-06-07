<?php

/**
 * @OA\Info(
 *     title="Property API",
 *     version="1.0.0",
 *     description="API for managing properties",
 *     @OA\Contact(
 *         email="your-email@example.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */

/**
 * @OA\Server(
 *     url="http://localhost:8000/api",
 *     description="Local Development Server"
 * )
 */

/**
 * @OA\Schema(
 *     schema="Property",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the property"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="Title of the property"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the property"
 *     ),
 *     @OA\Property(
 *         property="address_line",
 *         type="string",
 *         description="Address line of the property"
 *     ),
 *     @OA\Property(
 *         property="municipality",
 *         type="string",
 *         description="Municipality where the property is located"
 *     ),
 *     @OA\Property(
 *         property="num_bedrooms",
 *         type="integer",
 *         description="Number of bedrooms"
 *     ),
 *     @OA\Property(
 *         property="square_meters",
 *         type="integer",
 *         description="Size of the property in square meters"
 *     ),
 *     @OA\Property(
 *         property="price",
 *         type="number",
 *         description="Price of the property"
 *     ),
 *     @OA\Property(
 *         property="image_url",
 *         type="string",
 *         description="URL of the property's image"
 *     )
 * )
 */

?>
