<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductSizeResource;
use App\Product;
use App\ProductPrice;
use App\Size;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with("category", "colors", "sizes", "pictures", "prices")
            ->get();

        return new ProductCollection($products);
    }

    public function show($id)
    {
        $product = Product::with("category", "colors", "sizes", "pictures", "prices")
            ->where("id", $id)
            ->first();

        return new ProductResource($product);
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $category = $request->category;

        $query = Product::with("category", "colors", "sizes", "pictures");
        if (isset($keyword)) {
            $query->where("name", "like", "%" . $keyword . "%");
        }

        if (isset($category)) {
            $query->where("category_id", $category);
        }
        $products =  $query->get();

        return new ProductCollection($products);
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), Product::$rules, Product::$messages);

        if (!$validation->fails()) {
            $result = Product::saveData($request);
            if ($result["status"] == true) {
                return response()
                    ->json(["message" => "Berhasil menambahkan produk"], 200);
            }
        } else {
            return response()
                ->json(["data" => $validation->errors()], 403);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $product = Product::with("colors", "sizes")->where("id", $id)->first();
            $product->colors()->detach($product->colors->pluck("id"));
            $product->sizes()->detach($product->sizes->pluck("id"));
            $product->delete();
            DB::commit();

            return response()
                ->json(["message" => "Berhasil menghapus produk"], 200);
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), Product::$rules, Product::$messages);

        if (!$validation->fails()) {
            $result = Product::updateData($id, $request);
            if ($result["status"] == true) {
                return response()
                    ->json(["message" => "Berhasil mengupdate produk"], 200);
            }
        } else {
            return response()
                ->json(["data" => $validation->errors()], 403);
        }
    }

    public function getPrice($id)
    {
        $prices = ProductPrice::with("size", "product")->where("product_id", $id)->get();

        return new ProductResource($prices);
    }


    public function getSize($id)
    {
        $prices = Product::with("sizes")->where("id", $id)->first();

        return new ProductResource($prices);
    }
}
