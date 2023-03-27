<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Product",
 *     description="API Endpoints of Product Management"
 * )
 */
class ProductController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Product::class, 'product');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */

    /**
     * @OA\Get(
     * path="/api/product",
     * operationId="ProductIndex",
     * tags={"Product"},
     * summary="Get All Products",
     *      @OA\Response(
     *          response=200,
     *          description="Successfully",
     *          @OA\JsonContent()
     *       ),
     * )
     */
    public function index(): JsonResponse
    {
        $products = Product::all();

        return response()->json([
            "status" => "success",
            "length" => count($products),
            "data" =>new ProductCollection($products),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProductRequest $request
     * @return JsonResponse
     */

    /**
     * @OA\Post(
     * path="/api/product",
     * operationId="ProductStore",
     * tags={"Product"},
     * summary="Store Product",
     *     security={ {"sanctum": {} }},
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"title", "amount", "price", "discount", "image", "description", "category_id"},
     *               @OA\Property(property="title", type="text"),
     *               @OA\Property(property="amount", type="integer"),
     *               @OA\Property(property="price", type="float"),
     *               @OA\Property(property="discount", type="integer"),
     *               @OA\Property(property="image", type="text"),
     *               @OA\Property(property="description", type="text"),
     *               @OA\Property(property="category_id", type="integer"),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="Successfully",
     *          @OA\JsonContent()
     *       ),
     * )
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        // generate random name for the image
        $random = rand(0, 100000);
        $imageName = "Image" . date('ymd') . $random .'.'.$request->image->extension();

        // store the image in storage folder storage/app/public/products/images
        $request->image->storeAs("public/products/images", $imageName);

        // override the new name of image to request before storing in database
        $product_array = $request->all();
        $product_array["image"] = $imageName;
        $product_array["user_id"] = Auth::user()->id;

//        dd($product_array);

        $product = Product::create($product_array);

        return response()->json([
            "status" => "success",
            "message" => "product created successfully",
            "data" => $product,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return JsonResponse
     */

    /**
     * @OA\Get(
     * path="/api/product/{id}",
     * operationId="ProductShow",
     * tags={"Product"},
     * summary="Get Specific Product",
     *     @OA\Parameter(
     *          name="id",
     *          description="Product ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successfully",
     *          @OA\JsonContent()
     *       ),
     * )
     */
    public function show(Product $product): JsonResponse
    {
        $product->category;
        return response()->json([
            "status" => "success",
            "data" => new ProductResource($product),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return JsonResponse
     */

    /**
     * @OA\Put(
     * path="/api/product/{id}",
     * operationId="ProductUpdate",
     * tags={"Product"},
     * summary="Update Product",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *          name="id",
     *          description="Product ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"title", "amount", "price", "discount", "image", "description", "category_id"},
     *               @OA\Property(property="title", type="text"),
     *               @OA\Property(property="amount", type="integer"),
     *               @OA\Property(property="price", type="float"),
     *               @OA\Property(property="discount", type="integer"),
     *               @OA\Property(property="image", type="text"),
     *               @OA\Property(property="description", type="text"),
     *               @OA\Property(property="category_id", type="integer"),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="Successfully",
     *          @OA\JsonContent()
     *       ),
     * )
     */
    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $product->update($request->all());

        return response()->json([
            "status" => "success",
            "message" => "product updated successfully",
            "data" => $product,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return JsonResponse
     */

    /**
     * @OA\Delete(
     * path="/api/product/{id}",
     * operationId="ProductDelete",
     * tags={"Product"},
     * summary="Delete Specific Product",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *          name="id",
     *          description="Product ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successfully",
     *          @OA\JsonContent()
     *       ),
     * )
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json([
            "status" => "success",
            "message" => "product deleted successfully",
            "data" => $product,
        ]);
    }
}
