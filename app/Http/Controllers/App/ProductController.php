<?php

namespace App\Http\Controllers\App;

use App\Category;
use App\Color;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductColor;
use App\ProductPrice;
use App\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view("pages.product.index", compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();
        return view("pages.product.create", compact("colors", "categories", "sizes"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validation = Validator::make($request->all(), Product::$rules, Product::$messages);

        if (!$validation->fails()) {
            $result = Product::saveData($request);
            if ($result["status"] == true) {
                return redirect()
                    ->route("product.index")
                    ->withToastSuccess("Berhasil menambahkan produk!");
            }
        } else {
            return redirect()
                ->back()
                ->withToastError($validation->errors()->first());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();

        $product = Product::with("category", "colors", "sizes", "pictures", "prices")
            ->where("id", $id)
            ->first();

        return view("pages.product.edit", compact("product", "categories", "colors", "sizes"));
    }


    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), Product::$rules, Product::$messages);

        if (!$validation->fails()) {
            $result = Product::updateData($id, $request);
            if ($result["status"] == true) {
                return redirect()
                    ->route("product.index")
                    ->withToastSuccess("Berhasil mengupdate produk!");
            }
        } else {
            return redirect()
                ->back()
                ->withToastError($validation->errors()->first());
        }
    }

    public function savePrice(Request $request, $id)
    {
        if ($request->price <= 0) {
            return redirect()
                ->route("product.index")
                ->withToastSuccess("Harga produk tidak boleh 0!");
        }

        if (ProductPrice::where("product_id", $id)->where("size_id", $request->size)->get()->count() > 0) {
            return redirect()
                ->route("product.index")
                ->withToastSuccess("Sudah ada harga untuk size yang di pilih!");
        }

        $price = new ProductPrice;
        $price->size_id  = $request->size;
        $price->price  = $request->price;
        $price->product_id  = $id;
        $price->save();

        return redirect()
            ->route("product.index")
            ->withToastSuccess("Berhasil menambahkan harga produk!");
    }
}
