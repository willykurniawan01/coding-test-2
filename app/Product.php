<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Color;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    public static $rules = [
        "name" => "required",
    ];

    public static $messages = [
        "name.required" => "Nama produk tidak boleh kosong!"
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function pictures()
    {
        return $this->hasMany(ProductPicture::class);
    }

    public function prices()
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, "product_colors");
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, "product_sizes");
    }

    public static function saveData($request)
    {
        try {
            DB::beginTransaction();

            $product = new Product;
            $product->name = $request->name;
            $product->description = $request->description;
            $product->category_id = $request->category;
            $product->save();

            $product->colors()->attach($request->colors);
            $product->sizes()->attach($request->sizes);

            if ($request->hasFile("picture")) {
                foreach ($request->file("picture") as $eachPicture) {
                    $url = asset(Storage::url($eachPicture->store('/services', 'public')));

                    $picture = new ProductPicture;
                    $picture->product_id = $product->id;
                    $picture->url = $url;
                    $picture->save();
                }
            }


            DB::commit();
            $result["status"] = true;
            $result["message"] = "Berhasil menambahkan produk!";
            return $result;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public static function updateData($id, $request)
    {
        try {
            DB::beginTransaction();

            $product = Product::find($id);
            $product->name = $request->name;
            $product->description = $request->description;
            $product->category_id = $request->category;
            $product->save();

            $product->colors()->sync($request->colors);
            $product->sizes()->sync($request->sizes);

            DB::commit();
            $result["status"] = true;
            $result["message"] = "Berhasil mengupdate produk!";
            return $result;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
